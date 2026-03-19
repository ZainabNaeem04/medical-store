<?php
include "../config.php";

$customer_id = $_GET['id'];

$result = mysqli_query($conn,"SELECT * FROM customer_purchases WHERE customer_id=$customer_id ORDER BY purchase_date DESC");
?>

<h2>Customer Purchases</h2>

<table border="1">
<tr>
<th>Sale ID</th>
<th>Medicine</th>
<th>Quantity</th>
<th>Total</th>
<th>Date</th>
</tr>

<?php while($row = mysqli_fetch_assoc($result)){ ?>
<tr>
<td><?php echo $row['id']; ?></td>
<td><?php echo $row['medicine_name']; ?></td>
<td><?php echo $row['quantity']; ?></td>
<td><?php echo number_format($row['total_amount'],2); ?></td>
<td><?php echo $row['purchase_date']; ?></td>
</tr>
<?php } ?>

</table>