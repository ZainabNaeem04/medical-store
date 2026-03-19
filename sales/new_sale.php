<?php
include "../config.php";

$medicines = mysqli_query($conn,"SELECT * FROM medicines");
$customers = mysqli_query($conn,"SELECT * FROM customers");

if(isset($_POST['sell'])){
    $customer = $_POST['customer'];
    $tax = $_POST['tax'];
    $discount = $_POST['discount'];
    $date = date("Y-m-d");
    $total_amount = 0;

    mysqli_query($conn,"INSERT INTO sales(customer_name,date,total_amount,tax,discount) VALUES('$customer','$date','0','$tax','$discount')");
    $sale_id = mysqli_insert_id($conn);

    foreach($_POST['medicine'] as $key => $medicine_id){
        $qty = $_POST['qty'][$key];

        $res = mysqli_query($conn,"SELECT * FROM medicines WHERE medicine_id=$medicine_id");
        $row = mysqli_fetch_assoc($res);
        $price = $row['price'];
        $available_qty = $row['quantity'];

        if($qty > $available_qty){
            echo "<p style='color:red'>Error: Not enough stock for medicine: ".$row['name'].". Available: ".$available_qty."</p>";
            exit;
        }

        $subtotal = $price * $qty;
        $total_amount += $subtotal;

        mysqli_query($conn,"INSERT INTO sale_items(sale_id,medicine_id,quantity,price)
        VALUES('$sale_id','$medicine_id','$qty','$price')");

        mysqli_query($conn,"UPDATE medicines SET quantity = quantity - $qty WHERE medicine_id=$medicine_id");

         // Record purchase in customer_purchases automatically
        mysqli_query($conn,"INSERT INTO customer_purchases(customer_id,medicine_name,quantity,total_amount,purchase_date)
        VALUES('$customer','".$row['name']."','$qty','$subtotal','$date')");
    }

    $total_amount = $total_amount + $tax - $discount;
    mysqli_query($conn,"UPDATE sales SET total_amount='$total_amount' WHERE sale_id=$sale_id");
    header("Location: invoice.php?id=$sale_id");
    exit;
}
?>

<h2>New Sale</h2>

<form method="post">
Customer:
<select name="customer" required>
<?php while($c = mysqli_fetch_assoc($customers)){ ?>
<option value="<?php echo $c['customer_id']; ?>">
    <?php echo $c['name']; ?>
</option>
<?php } ?>
</select>

<h3>Medicines</h3>
<div id="items">
    <div class="item">
        <select name="medicine[]" required>
            <?php mysqli_data_seek($medicines, 0); while($m = mysqli_fetch_assoc($medicines)){ ?>
            <option value="<?php echo $m['medicine_id']; ?>">
                <?php echo $m['name']; ?> (Available: <?php echo $m['quantity']; ?>)
            </option>
            <?php } ?>
        </select>
        Qty:
        <input type="number" name="qty[]" value="1" min="1" required>
    </div>
</div>

Tax:
<input type="number" name="tax" value="0" min="0"><br>
Discount:
<input type="number" name="discount" value="0" min="0"><br><br>

<button type="submit" name="sell">Generate Bill</button>
</form>