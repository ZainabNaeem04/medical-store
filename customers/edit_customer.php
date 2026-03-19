<?php
include "../config.php";

$id = $_GET['id'];

$result = mysqli_query($conn,"SELECT * FROM customers WHERE customer_id=$id");
$row = mysqli_fetch_assoc($result);

if(isset($_POST['update'])){

$name = $_POST['name'];
$contact = $_POST['contact'];
$address = $_POST['address'];

mysqli_query($conn,"UPDATE customers SET
name='$name',
contact='$contact',
address='$address'
WHERE customer_id=$id");

header("Location:view_customer.php");
}
?>

<h2>Edit Customer</h2>

<form method="post">

Name: <input type="text" name="name" value="<?php echo $row['name']; ?>"><br>
Contact: <input type="text" name="contact" value="<?php echo $row['contact']; ?>"><br>
Address: <textarea name="address"><?php echo $row['address']; ?></textarea><br><br>

<button name="update">Update</button>

</form>