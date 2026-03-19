<?php
include "../config.php";

$result = mysqli_query($conn,"SELECT * FROM customers");
?>

<h2>Customers</h2>

<a href="add_customer.php">Add Customer</a><br><br>

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

<td><?php echo $row['customer_id']; ?></td>
<td><?php echo $row['name']; ?></td>
<td><?php echo $row['contact']; ?></td>
<td><?php echo $row['address']; ?></td>

<td>
<a href="edit_customer.php?id=<?php echo $row['customer_id']; ?>">Edit</a> |
<a href="delete_customer.php?id=<?php echo $row['customer_id']; ?>">Delete</a> |
<a href="purchases.php?id=<?php echo $row['customer_id']; ?>">Purchases</a>
</td>

</tr>

<?php } ?>

</table>