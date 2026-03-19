<?php
include "../config.php";

$expiry_days = isset($_GET['days']) ? (int)$_GET['days'] : 30;
$expiry_limit = date("Y-m-d", strtotime("+$expiry_days days"));
$today = date("Y-m-d");

$expiring_meds = mysqli_query($conn,"
SELECT * FROM medicines
WHERE expiry_date BETWEEN '$today' AND '$expiry_limit'
ORDER BY expiry_date ASC
");
?>

<h2>Expiry Report (Next <?php echo $expiry_days; ?> Days)</h2>

<head>
<style>
@media print {
    .no-print {
        display: none;
    }
    .form, .form * {
        display: none;
}
}
</style>
</head>

<form method="get" class="form">
Show medicines expiring in next <input type="number" name="days" value="<?php echo $expiry_days; ?>" min="1"> days
<button class="no-print" type="submit">Filter</button>
</form>

<table border="1">
<tr>
<th>Medicine</th>
<th>Quantity</th>
<th>Expiry Date</th>
</tr>

<?php while($row = mysqli_fetch_assoc($expiring_meds)){ ?>
<tr>
<td><?php echo $row['name']; ?></td>
<td><?php echo $row['quantity']; ?></td>
<td><?php echo $row['expiry_date']; ?></td>
</tr>
<?php } ?>
</table>
<br>
    <button class="no-print" onclick="window.print()">Save as PDF</button>
</div>

</body>
</html>


