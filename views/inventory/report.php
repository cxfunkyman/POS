<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>INVENTORY REPORT</title>
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

    <h5 class="title">Inventory Details</h5>
    <table id="productContainer">
        <thead>
            <tr>
                <th>Product</th>
                <th>Movement</th>
                <th>Action</th>
                <th>Quantity</th>
                <th>Date</th>
                <th>Time</th>
                <th>Product Code</th>
                <th>User</th>
            </tr>
        </thead>
        <tbody>
            <?php
            foreach ($data['inventory'] as $inventory) { ?>
                <tr class="summaryTbl">
                    <td><?php echo $inventory['product']; ?></td>
                    <td><?php echo $inventory['movement']; ?></td>
                    <td><?php echo $inventory['action']; ?></td>
                    <td><?php echo $inventory['quantity']; ?></td>
                    <td><?php echo $inventory['dates']; ?></td>
                    <td><?php echo $inventory['time_day']; ?></td>
                    <td><?php echo $inventory['code']; ?></td>
                    <td><?php echo $inventory['name']; ?></td>
                </tr>
            <?php } ?>
        </tbody>
    </table>
    <div class="message">
        <?php echo $data['companies']['message']; ?>
    </div>
</body>

</html>