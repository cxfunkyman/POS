<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $data['title']; ?></title>
    <link rel="stylesheet" href="<?php echo BASE_URL . 'assets/css/invoices.css'; ?>">
</head>

<body>
    <table id="tblInvoiceData">
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
                    <span class="invoiceReport">Top Products</span>
                    <p>Date: <?php echo date('Y-m-d H:i:s');; ?></p>
                </div>
            </td>
        </tr>
    </table>
    <h5 class="title">Minimum Stock Products Details</h5>
    <table id="productContainer">
        <thead>
            <tr>
                <th>Code</th>
                <th>Description</th>
                <th>Stock</th>
                <th>Purchase Price</th>
                <th>Sale Price</th>
                <th>Category</th>
            </tr>
        </thead>
        <tbody>
            <?php

            foreach ($data['products'] as $product) { ?>
                <tr class="summaryTbl">
                    <td><?php echo $product['code']; ?></td>
                    <td><?php echo $product['description']; ?></td>
                    <td><?php echo $product['quantity']; ?></td>
                    <td><?php echo CURRENCY . number_format($product['purchase_price'], 2); ?></td>
                    <td><?php echo CURRENCY . number_format($product['sale_price'], 2); ?></td>
                    <td><?php echo $product['category']; ?></td>
                </tr>
            <?php } ?>
        </tbody>
    </table>
    <div class="message">
        <?php echo $data['companies']['message']; ?>
    </div>
</body>

</html>