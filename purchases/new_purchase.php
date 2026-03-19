<?php
session_start();
include "../config.php";

if(!isset($_SESSION['user'])){
header("Location: ../login.php");
exit();
}

$result = mysqli_query($conn,"SELECT role FROM users WHERE username='".$_SESSION['user']."'");
$user = mysqli_fetch_assoc($result);

if($user['role'] != 'admin'){
echo "Access Denied!";
exit();
}
?>

<?php
include "../config.php";

$medicines = mysqli_query($conn,"SELECT * FROM medicines");
$suppliers = mysqli_query($conn,"SELECT * FROM suppliers");

if(isset($_POST['purchase'])){
    $supplier = $_POST['supplier'];
    $tax = $_POST['tax'];
    $discount = $_POST['discount'];
    $date = date("Y-m-d");
    $total_amount = 0;

    mysqli_query($conn,"INSERT INTO purchases(supplier_name,date,total_amount,tax,discount) 
        VALUES('$supplier','$date','0','$tax','$discount')");
    $purchase_id = mysqli_insert_id($conn);

    foreach($_POST['medicine'] as $key => $medicine_id){
        $qty = $_POST['qty'][$key];
        $res = mysqli_query($conn,"SELECT * FROM medicines WHERE medicine_id=$medicine_id");
        $row = mysqli_fetch_assoc($res);
        $price = $row['price'];
        $subtotal = $price * $qty;
        $total_amount += $subtotal;

        mysqli_query($conn,"INSERT INTO purchase_items(purchase_id,medicine_id,quantity,price) 
            VALUES('$purchase_id','$medicine_id','$qty','$price')");

        mysqli_query($conn,"UPDATE medicines SET quantity = quantity + $qty WHERE medicine_id=$medicine_id");
    }

    $total_amount = $total_amount + $tax - $discount;
    mysqli_query($conn,"UPDATE purchases SET total_amount='$total_amount' WHERE purchase_id=$purchase_id");

        // Record transaction in supplier_transactions automatically
        $supplier_id = $supplier; // Assuming supplier_name is actually supplier_id
    mysqli_query($conn,"INSERT INTO supplier_transactions(supplier_id,amount,transaction_date,description)
        VALUES('$supplier_id','$total_amount','$date','Purchase ID: $purchase_id')");

    header("Location: purchase_invoice.php?id=$purchase_id");
    exit;
}
?>

<h2>New Purchase</h2>
<form method="post">
Supplier: 
<select name="supplier" required>
    <?php while($s = mysqli_fetch_assoc($suppliers)){ ?>
    <option value="<?php echo $s['supplier_id']; ?>">
        <?php echo $s['name']; ?>
    </option>
    <?php } ?>
</select><br><br>

<h3>Medicines</h3>
<div id="items">
    <div class="item">
        <select name="medicine[]" required>
            <?php mysqli_data_seek($medicines, 0); while($m = mysqli_fetch_assoc($medicines)){ ?>
            <option value="<?php echo $m['medicine_id']; ?>">
                <?php echo $m['name']; ?> (Stock: <?php echo $m['quantity']; ?>)
            </option>
            <?php } ?>
        </select>
        Qty: <input type="number" name="qty[]" value="1" min="1" required>
    </div>
</div>

Tax: <input type="number" name="tax" value="0" min="0"><br>
Discount: <input type="number" name="discount" value="0" min="0"><br><br>

<button type="submit" name="purchase">Add Purchase</button>
</form>