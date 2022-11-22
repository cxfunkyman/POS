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
            <?php
            $dates_reserves = $data['reserves']['dates_reserves'];
            $dates_withdraw = $data['reserves']['dates_withdraw'];
            ?>
            <td class="invoicePurchase1">
                <div class="invoiceContainer">
                    <span class="invoiceReport">Invoice Reserve</span>
                    <p>N°: <strong><?php echo $data['reserves']['id']; ?></strong></p>
                    <p>Reserve: <?php echo $dates_reserves; ?></p>
                    <p>Withdraw: <?php echo $dates_withdraw; ?></p>
                </div>
            </td>
        </tr>
    </table>
    <h5 class="title">Client information</h5>
    <table id="supplierContainer">
        <tr>
            <td>
                <strong><?php echo $data['reserves']['identification'] ?>: </strong>
                <p><?php echo $data['reserves']['num_identity'] ?></p>
            </td>
            <td>
                <strong>Name: </strong>
                <p><?php echo $data['reserves']['name'] ?></p>
            </td>
        </tr>
        <tr>
            <td>
                <strong>Phone: </strong>
                <p><?php echo $data['reserves']['phone_number'] ?></p>
            </td>
            <td>
                <strong>Address: </strong>
                <p><?php echo $data['reserves']['address'] ?></p>
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
            $products = json_decode($data['reserves']['products'], true);

            $total = $data['reserves']['total'];
            $payment = $data['reserves']['payment'];
            $remaining = $data['reserves']['remaining'];

            foreach ($products as $product) { ?>
                <tr class="summaryTbl">
                    <td><?php echo $product['quantity']; ?></td>
                    <td><?php echo $product['name']; ?></td>
                    <td><?php echo number_format($product['sale_price'], 2); ?></td>
                    <td><?php echo number_format($product['quantity'] * ($product['sale_price']), 2); ?></td>
                </tr>
            <?php } ?>
            <br>
            <tr>
                <td class="totalNumberTitle" colspan="3">Payment</td>
                <td class="totalNumberResult">$ <?php echo number_format($payment, 2); ?></td>
            </tr>
            <tr>
                <td class="totalNumberTitle" colspan="3">Remaining</td>
                <td class="totalNumberResult">$ <?php echo number_format($remaining, 2); ?></td>
            </tr>
            <tr>
                <td class="totalNumberTitle" colspan="3">Total</td>
                <td class="totalNumberResult">$ <?php echo number_format($total, 2); ?></td>
            </tr>
        </tbody>
    </table>
    <div class="message">
        <?php echo $data['companies']['message']; ?>
    </div>
    <?php if ($data['reserves']['status'] == 0) { ?>
        <h2 class="orderCancel">-PRODUCTS DELIVERED-</h2>
    <?php } else if ($data['reserves']['status'] == 1) { ?>
        <h2 class="orderCancel">-PRODUCTS TO COLLECT-</h2>
    <?php } else { ?>
        <h2 class="orderCancel">-ORDER CANCELLED-</h2>
    <?php } ?>
</body>

</html>