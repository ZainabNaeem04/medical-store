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

$month = date("Y-m");

$monthly_sales = mysqli_query($conn,"
SELECT sale_id, customer_name, date, total_amount
FROM sales
WHERE date LIKE '$month%'
ORDER BY date DESC
");

$total_monthly = 0;
?>

<head>
<style>
@media print {
    .no-print {
        display: none;
    }
}
</style>
</head>

<h2>Monthly Sales Report (<?php echo date("F Y"); ?>)</h2>

<table border="1">
<tr>
<th>Sale ID</th>
<th>Customer</th>
<th>Date</th>
<th>Total Amount</th>
</tr>

<?php while($row = mysqli_fetch_assoc($monthly_sales)){
    $total_monthly += $row['total_amount'];
?>
<tr>
<td><?php echo $row['sale_id']; ?></td>
<td><?php echo $row['customer_name']; ?></td>
<td><?php echo $row['date']; ?></td>
<td><?php echo number_format($row['total_amount'],2); ?></td>
</tr>
<?php } ?>
<tr>
<td colspan="3" style="text-align:right"><b>Total</b></td>
<td><?php echo number_format($total_monthly,2); ?></td>
</tr>
</table>
<br>
    <button class="no-print" onclick="window.print()">Save as PDF</button>
</div>