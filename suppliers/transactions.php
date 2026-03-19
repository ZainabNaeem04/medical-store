<?php
include "../config.php";

$supplier_id = $_GET['id'];

// Fetch all transactions (automatic only) for this supplier
$result = mysqli_query($conn,"
SELECT * FROM supplier_transactions 
WHERE supplier_id=$supplier_id 
ORDER BY transaction_date DESC
");
?>

<h2>Supplier Transactions</h2>

<table border="1">
<tr>
<th>ID</th>
<th>Amount</th>
<th>Date</th>
<th>Description</th>
</tr>

<?php while($row = mysqli_fetch_assoc($result)){ ?>
<tr>
<td><?php echo $row['id']; ?></td>
<td><?php echo number_format($row['amount'],2); ?></td>
<td><?php echo $row['transaction_date']; ?></td>
<td><?php echo $row['description']; ?></td>
</tr>
<?php } ?>

</table>