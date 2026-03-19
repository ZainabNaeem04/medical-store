<?php
include "../config.php";

$stock = mysqli_query($conn,"SELECT * FROM medicines ORDER BY name ASC");
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

<h2>Stock Report</h2>

<table border="1">
<tr>
<th>Medicine</th>
<th>Category</th>
<th>Batch Number</th>
<th>Price</th>
<th>Quantity</th>
<th>Expiry Date</th>
</tr>

<?php while($row = mysqli_fetch_assoc($stock)){ 
    $expired = strtotime($row['expiry_date']) < strtotime(date("Y-m-d"));
?>
<tr>
<td><?php echo $row['name']; ?></td>
<td><?php echo $row['category']; ?></td>
<td><?php echo $row['batch_number']; ?></td>
<td><?php echo number_format($row['price'],2); ?></td>
<td><?php echo $row['quantity']; ?></td>
<td <?php if($expired) echo "style='color:red'"; ?>>
    <?php echo $row['expiry_date']; ?>
    <?php if($expired) echo " (Expired)"; ?>
</td>
</tr>
<?php } ?>
</table>
<br>
    <button class="no-print" onclick="window.print()">Save as PDF</button>
</div>
