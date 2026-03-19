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

$id = $_GET['id'];

$purchase = mysqli_query($conn,"SELECT * FROM purchases WHERE purchase_id=$id");
$purchase = mysqli_query($conn,"
SELECT s.*, c.name AS supplier_name
FROM purchases s
JOIN suppliers c ON s.supplier_name = c.supplier_id
WHERE s.purchase_id = $id
");
$purchase_data = mysqli_fetch_assoc($purchase);

$items = mysqli_query($conn,"
SELECT pi.*, m.name AS medicine_name 
FROM purchase_items pi
JOIN medicines m ON pi.medicine_id = m.medicine_id
WHERE pi.purchase_id=$id
");
?>

<!DOCTYPE html>
<html>
<head>
    <title>Purchase Invoice #<?php echo $id; ?></title>
    <style>
        body { font-family: Arial; }
        .invoice-box { max-width: 800px; margin: auto; padding: 20px; border: 1px solid #eee; }
        table { width: 100%; border-collapse: collapse; }
        table th, table td { border: 1px solid #ddd; padding: 8px; }
        table th { background: #f2f2f2; }
        .total-row { font-weight: bold; }
        @media print { .no-print { display: none; } }
    </style>
</head>
<body>
<div class="invoice-box">
<h2>Purchase Invoice #<?php echo $id; ?></h2>
<p><b>Supplier:</b> <?php echo $purchase_data['supplier_name']; ?></p>
<p><b>Date:</b> <?php echo $purchase_data['date']; ?></p>
<p><b>Tax:</b> <?php echo $purchase_data['tax']; ?></p>
<p><b>Discount:</b> <?php echo $purchase_data['discount']; ?></p>

<table>
<tr>
<th>Medicine</th>
<th>Qty</th>
<th>Price</th>
<th>Subtotal</th>
</tr>

<?php 
$grand_total = 0;
while($row = mysqli_fetch_assoc($items)){
    $subtotal = $row['quantity'] * $row['price'];
    $grand_total += $subtotal;
?>
<tr>
<td><?php echo $row['medicine_name']; ?></td>
<td><?php echo $row['quantity']; ?></td>
<td><?php echo number_format($row['price'],2); ?></td>
<td><?php echo number_format($subtotal,2); ?></td>
</tr>
<?php } ?>

<tr class="total-row">
<td colspan="3" style="text-align:right">Subtotal</td>
<td><?php echo number_format($grand_total,2); ?></td>
</tr>
<tr class="total-row">
<td colspan="3" style="text-align:right">Tax</td>
<td><?php echo number_format($purchase_data['tax'],2); ?></td>
</tr>
<tr class="total-row">
<td colspan="3" style="text-align:right">Discount</td>
<td><?php echo number_format($purchase_data['discount'],2); ?></td>
</tr>
<tr class="total-row">
<td colspan="3" style="text-align:right">Total</td>
<td><?php echo number_format($purchase_data['total_amount'],2); ?></td>
</tr>
</table>

<br>
<button class="no-print" onclick="window.print()">Print Invoice</button>
</div>
</body>
</html>