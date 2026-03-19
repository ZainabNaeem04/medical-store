<?php
include "../config.php";

$id = $_GET['medicine_id'];

$result = mysqli_query($conn,"SELECT * FROM medicines WHERE medicine_id=$id");
$row = mysqli_fetch_assoc($result);

if(isset($_POST['update'])){

$name = $_POST['name'];
$category = $_POST['category'];
$batch_number = $_POST['batch_number'];
$price = $_POST['price'];
$quantity = $_POST['quantity'];
$expiry = $_POST['expiry'];

mysqli_query($conn,"UPDATE medicines SET
name='$name',
category='$category',
batch_number='$batch_number',
price='$price',
quantity='$quantity',
expiry_date='$expiry'
WHERE medicine_id=$id");

header("Location:view_medicine.php");
}
?>

<h2>Edit Medicine</h2>

<form method="post">

Name: <input type="text" name="name" value="<?php echo $row['name']; ?>"><br>
Category: <input type="text" name="category" value="<?php echo $row['category']; ?>"><br>
Batch Number: <input type="text" name="batch_number" value="<?php echo $row['batch_number']; ?>"><br>
Price: <input type="number" step="0.01" name="price" value="<?php echo $row['price']; ?>"><br>
Quantity: <input type="number" name="quantity" value="<?php echo $row['quantity']; ?>"><br>
Expiry: <input type="date" name="expiry" value="<?php echo $row['expiry_date']; ?>"><br><br>

<button name="update">Update</button>

</form>