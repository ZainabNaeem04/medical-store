<?php
include "../config.php";

$id=$_GET['medicine_id'];

mysqli_query($conn,"DELETE FROM medicines WHERE medicine_id=$id");

header("Location:view_medicine.php");
?>