<?php
include "../config.php";

if(isset($_POST['submit'])){

$name = $_POST['name'];
$contact = $_POST['contact'];
$address = $_POST['address'];

mysqli_query($conn,"INSERT INTO customers(name,contact,address)
VALUES('$name','$contact','$address')");

echo "Customer Added Successfully!";
}
?>

<h2>Add Customer</h2>

<form method="post">

Name: <input type="text" name="name"><br>
Contact: <input type="text" name="contact"><br>
Address: <textarea name="address"></textarea><br><br>

<button name="submit">Add Customer</button>

</form>