<?php
include "../config.php";

$result = mysqli_query($conn,"SELECT * FROM medicines");
?>

<h2>Medicine List</h2>

<a href="add_medicine.php">Add New Medicine</a><br><br>

<table border="1">

<tr>
<th>ID</th>
<th>Name</th>
<th>Category</th>
<th>Batch Number</th>
<th>Price</th>
<th>Quantity</th>
<th>Expiry</th>
<th>Status</th>
<th>Action</th>
</tr>

<?php while($row = mysqli_fetch_assoc($result)){

$status = "";

if($row['quantity'] < 10){
$status .= "Low Stock ";
}

if(strtotime($row['expiry_date']) < time()){
$status .= "Expired ";
}
else {
    $status .= "Valid ";
}

?>

<tr>

<td><?php echo $row['medicine_id']; ?></td>
<td><?php echo $row['name']; ?></td>
<td><?php echo $row['category']; ?></td>
<td><?php echo $row['batch_number']; ?></td>
<td><?php echo $row['price']; ?></td>
<td><?php echo $row['quantity']; ?></td>
<td><?php echo $row['expiry_date']; ?></td>
<td><?php echo $status; ?></td>

<td>
<a href="edit_medicine.php?medicine_id=<?php echo $row['medicine_id']; ?>">Edit</a> |
<a href="delete_medicine.php?medicine_id=<?php echo $row['medicine_id']; ?>">Delete</a>
</td>

</tr>

<?php } ?>

</table>