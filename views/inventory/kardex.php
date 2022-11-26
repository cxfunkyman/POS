<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>KARDEX REPORT</title>
    <link rel="stylesheet" href="<?php echo BASE_URL . 'assets/css/invoices.css'; ?>">
</head>

<body>
    <table id="tblReportData">
        <tr>
            <td class="companyLogo">
                <img src="<?php echo BASE_URL . 'assets/images/logo-img.png'; ?>" alt="">
            </td>
            <td class="invoiceData">
                <p><?php echo $data['companies']['name'] ?></p>
                <p>Tax ID: <?php echo $data['companies']['taxID'] ?></p>
                <p>Phone: <?php echo $data['companies']['phone_number'] ?></p>
                <p>Address: <?php echo $data['companies']['address'] ?></p>
            </td>
            <td class="invoicePurchase">
                <div class="invoiceContainer">
                    <span class="invoiceReport">Inventory Report</span>
                    <p>Date: <?php echo date('d-m-Y'); ?></p>
                    <p>Time: <?php echo date('H:i:s'); ?></p>
                </div>
            </td>
        </tr>
    </table>

    <h5 class="title">IN/OUT INVENTORY STOCK</h5>
    <table id="productContainer">
        <thead>
            <tr>
                <th>Code</th>
                <th>Product</th>
                <th>IN Stock</th>
                <th>OUT Stock</th>
                <th>Old Stock</th>
                <th>Actual Stock</th>
                <th>Date</th>
                <th>Time</th>
                <th>User</th>
            </tr>
        </thead>
        <tbody>
            <?php
            foreach ($data['kardex'] as $kardex) { ?>
                <tr class="summaryTbl">
                    <td><?php echo $kardex['code']; ?></td>
                    <td><?php echo $kardex['product']; ?></td>
                    <td><?php echo $kardex['in_stock']; ?></td>
                    <td><?php echo $kardex['out_stock']; ?></td>
                    <td><?php echo $kardex['old_stock']; ?></td>
                    <td><?php echo $kardex['actual_stock']; ?></td>
                    <td><?php echo $kardex['dates']; ?></td>
                    <td><?php echo $kardex['time_day']; ?></td>
                    <td><?php echo $kardex['name']; ?></td>
                </tr>
            <?php } ?>
        </tbody>
    </table>
    <div class="message">
        <?php echo $data['companies']['message']; ?>
    </div>
</body>

</html>