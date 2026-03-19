<?php
include "../config.php";

$id = $_GET['id'];

mysqli_query($conn,"DELETE FROM customers WHERE customer_id=$id");

header("Location:view_customer.php");
?>