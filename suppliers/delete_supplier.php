<?php
include "../config.php";

$id = $_GET['id'];

mysqli_query($conn,"DELETE FROM suppliers WHERE supplier_id=$id");

header("Location:view_supplier.php");
?>