<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

include "../config.php";

if(!isset($_GET['id'])){
echo "No ID received!";
exit();
}

$id = $_GET['id'];

$result = mysqli_query($conn,"SELECT * FROM suppliers WHERE supplier_id=$id");

$row = mysqli_fetch_assoc($result);

if(!$row){
echo "Supplier not found!";
exit();
}

if(isset($_POST['update'])){

$name = $_POST['name'];
$contact = $_POST['contact'];
$address = $_POST['address'];

mysqli_query($conn,"UPDATE suppliers SET
name='$name',
contact='$contact',
address='$address'
WHERE supplier_id=$id");

header("Location:view_supplier.php");
exit();
}
?>

<h2>Edit Supplier</h2>

<form method="post">

Name:
<input type="text" name="name" value="<?php echo $row['name']; ?>"><br>

Contact:
<input type="text" name="contact" value="<?php echo $row['contact']; ?>"><br>

Address:
<textarea name="address"><?php echo $row['address']; ?></textarea><br><br>

<button name="update">Update</button>

</form>