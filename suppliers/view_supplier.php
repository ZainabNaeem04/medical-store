<?php
include "../config.php";

$result = mysqli_query($conn,"SELECT * FROM suppliers");
?>

<h2>Suppliers</h2>

<a href="add_supplier.php">Add Supplier</a><br><br>

<table border="1">

<tr>
<th>ID</th>
<th>Name</th>
<th>Contact</th>
<th>Address</th>
<th>Action</th>
</tr>

<?php while($row = mysqli_fetch_assoc($result)){ ?>

<tr>

<td><?php echo $row['supplier_id']; ?></td>
<td><?php echo $row['name']; ?></td>
<td><?php echo $row['contact']; ?></td>
<td><?php echo $row['address']; ?></td>

<td>
<a href="edit_supplier.php?id=<?php echo $row['supplier_id']; ?>">Edit</a> |
<a href="delete_supplier.php?id=<?php echo $row['supplier_id']; ?>">Delete</a> |
<a href="transactions.php?id=<?php echo $row['supplier_id']; ?>">Transactions</a>
</td>

</tr>

<?php } ?>

</table>