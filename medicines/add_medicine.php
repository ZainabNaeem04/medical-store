<?php
include "../config.php";

if(isset($_POST['submit'])){

$name = $_POST['name'];
$category = $_POST['category'];
$batch_number = $_POST['batch_number'];
$price = $_POST['price'];
$quantity = $_POST['quantity'];
$expiry = $_POST['expiry'];

mysqli_query($conn,"INSERT INTO medicines(name,category,batch_number,price,quantity,expiry_date)
VALUES('$name','$category','$batch_number','$price','$quantity','$expiry')");

echo "Medicine Added Successfully!";
}
?>

<h2>Add Medicine</h2>

<form method="post">

Name: <input type="text" name="name"><br>
Category: <input type="text" name="category"><br>
Batch Number: <input type="text" name="batch_number"><br>
Price: <input type="number" step="0.01" name="price"><br>
Quantity: <input type="number" name="quantity"><br>
Expiry Date: <input type="date" name="expiry"><br><br>

<button name="submit">Add Medicine</button>

</form>