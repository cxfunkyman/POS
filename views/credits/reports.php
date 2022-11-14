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
    <table id="tblReportsData">
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
                    <span class="invoiceReport">Credit Report</span>
                    <p>Credit N°: <strong><?php echo $data['credits']['id']; ?></strong></p>
                    <p>Sale N°: <strong><?php echo $data['credits']['serie']; ?></strong></p>
                    <p>Date: <?php echo $data['credits']['dates']; ?></p>
                    <p>Time: <?php echo $data['credits']['time_date']; ?></p>
                </div>
            </td>
        </tr>
    </table>
    <h5 class="title">Client information</h5>
    <table id="supplierContainer">
        <tr>
            <td>
                <strong><?php echo $data['credits']['identification'] ?>: </strong>
                <p><?php echo $data['credits']['num_identity'] ?></p>
            </td>
            <td>
                <strong>Name: </strong>
                <p><?php echo $data['credits']['name'] ?></p>
            </td>
        </tr>
        <tr>
            <td>
                <strong>Phone: </strong>
                <p><?php echo $data['credits']['phone_number'] ?></p>
            </td>
            <td>
                <strong>Address: </strong>
                <p><?php echo $data['credits']['address'] ?></p>
            </td>
        </tr>
    </table>
    <h5 class="title">Sale Details</h5>
    <table id="productContainer">
        <thead>
            <tr>
                <th>Quantity</th>
                <th>Description</th>
                <th>Price</th>
                <th>SubTotal</th>
            </tr>
        </thead>
        <tbody>
            <?php
            $products = json_decode($data['credits']['products'], true);

            foreach ($products as $product) { ?>
                <tr class="summaryTbl">
                    <td><?php echo $product['quantity']; ?></td>
                    <td><?php echo $product['name']; ?></td>
                    <td><?php echo number_format($product['sale_price'], 2); ?></td>
                    <td><?php echo number_format($product['quantity'] * ($product['sale_price']), 2); ?></td>
                </tr>
            <?php } ?>
            <br>
            <tr class="totalTbl">
                <td class="totalNumberTitle" colspan="3">Total Amount</td>
                <td class="totalNumberResult">$ <?php echo number_format($data['credits']['amount'], 2); ?></td>
            </tr>
        </tbody>
    </table>
    <h5 class="title">Deposit Details</h5>
    <table id="productContainer">
        <thead>
            <tr>
                <th>Date</th>
                <th>Deposit</th>
            </tr>
        </thead>
        <tbody>
            <?php
            $deposits = 0;
            foreach ($data['abonate'] as $abonate) {
                $deposits += $abonate['deposits'];
            ?>
                <tr class="summaryTbl">
                    <td><?php echo $abonate['dates']; ?></td>
                    <td><?php echo number_format($abonate['deposits'], 2); ?></td>
                </tr>
            <?php } ?>
            <br>
            <tr class="totalTbl">
                <td class="totalNumberTitleAbonate">Total Deposits </td>
                <td class="totalNumberResultAbonate">$ <?php echo number_format($deposits, 2); ?></td>
            </tr>
            <tr class="totalTbl">
                <td class="totalNumberTitleAbonate">Total Remaining </td>
                <td class="totalNumberResultAbonate">$ <?php echo number_format($data['credits']['amount'] - $deposits, 2); ?></td>
            </tr>
        </tbody>
    </table>
    <div class="message">
        <?php echo $data['companies']['message']; ?>

        <?php if ($data['credits']['status'] == 0) { ?>
            <h1 class="orderCancel">-COMPLETE-</h1>
        <?php } else { ?>
            <h1 class="orderCancel">-PENDING-</h1>
        <?php } ?>
    </div>
</body>

</html>