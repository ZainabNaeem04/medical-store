<?php
include "../config.php";

$id = $_GET['id'];

$sale = mysqli_query($conn,"
SELECT s.*, c.name AS customer_name
FROM sales s
JOIN customers c ON s.customer_name = c.customer_id
WHERE s.sale_id = $id
");
$sale_data = mysqli_fetch_assoc($sale);

$items = mysqli_query($conn,"
SELECT si.*, m.name AS medicine_name
FROM sale_items si
JOIN medicines m ON si.medicine_id = m.medicine_id
WHERE si.sale_id = $id
");
?>

<!DOCTYPE html>
<html>
<head>
    <title>Invoice #<?php echo $id; ?></title>
    <style>
        body { font-family: Arial, sans-serif; }
        .invoice-box { max-width: 800px; margin: auto; padding: 30px; border: 1px solid #eee; }
        table { width: 100%; line-height: inherit; text-align: left; border-collapse: collapse; }
        table td, table th { border: 1px solid #ddd; padding: 8px; }
        table th { background: #f2f2f2; }
        h2, h3 { margin: 0; }
        .total-row { font-weight: bold; }

        /* Hide elements with class "no-print" when printing */
        @media print {
            .no-print {
                display: none;
            }
        }
    </style>
</head>
<body>

<div class="invoice-box">
    <h2>Invoice #<?php echo $id; ?></h2>
    <p><b>Customer:</b> <?php echo $sale_data['customer_name']; ?></p>
    <p><b>Date:</b> <?php echo $sale_data['date']; ?></p>
    <p><b>Tax:</b> <?php echo $sale_data['tax']; ?></p>
    <p><b>Discount:</b> <?php echo $sale_data['discount']; ?></p>

    <table>
        <tr>
            <th>Medicine</th>
            <th>Qty</th>
            <th>Price</th>
            <th>Subtotal</th>
        </tr>

        <?php 
        $grand_total = 0;
        while($row = mysqli_fetch_assoc($items)){ 
            $subtotal = $row['quantity'] * $row['price'];
            $grand_total += $subtotal;
        ?>
        <tr>
            <td><?php echo $row['medicine_name']; ?></td>
            <td><?php echo $row['quantity']; ?></td>
            <td><?php echo number_format($row['price'],2); ?></td>
            <td><?php echo number_format($subtotal,2); ?></td>
        </tr>
        <?php } ?>

        <tr class="total-row">
            <td colspan="3" style="text-align:right">Subtotal</td>
            <td><?php echo number_format($grand_total,2); ?></td>
        </tr>
        <tr class="total-row">
            <td colspan="3" style="text-align:right">Tax</td>
            <td><?php echo number_format($sale_data['tax'],2); ?></td>
        </tr>
        <tr class="total-row">
            <td colspan="3" style="text-align:right">Discount</td>
            <td><?php echo number_format($sale_data['discount'],2); ?></td>
        </tr>
        <tr class="total-row">
            <td colspan="3" style="text-align:right">Total</td>
            <td><?php echo number_format($sale_data['total_amount'],2); ?></td>
        </tr>
    </table>

    <br>
    <button class="no-print" onclick="window.print()">Print Invoice</button>
</div>

</body>
</html>