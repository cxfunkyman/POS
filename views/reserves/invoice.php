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
                    <span class="invoiceReport">Invoice Quote</span>
                    <p>N°: <strong><?php echo $data['quotes']['id']; ?></strong></p>
                    <p>Date: <?php echo $data['quotes']['dates']; ?></p>
                    <p>Time: <?php echo $data['quotes']['time_day']; ?></p>
                </div>
            </td>
        </tr>
    </table>
    <h5 class="title">Client information</h5>
    <table id="supplierContainer">
        <tr>
            <td>
                <strong><?php echo $data['quotes']['identification'] ?>: </strong>
                <p><?php echo $data['quotes']['num_identity'] ?></p>
            </td>
            <td>
                <strong>Name: </strong>
                <p><?php echo $data['quotes']['name'] ?></p>
            </td>
        </tr>
        <tr>
            <td>
                <strong>Phone: </strong>
                <p><?php echo $data['quotes']['phone_number'] ?></p>
            </td>
            <td>
                <strong>Address: </strong>
                <p><?php echo $data['quotes']['address'] ?></p>
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
            $products = json_decode($data['quotes']['products'], true);
            //TAX INCLUDE
            $discount = $data['quotes']['discount_amount'];
            $subTotal = $data['quotes']['subtotal'];
            $tps = $data['quotes']['quote_tps'];
            $tvq = $data['quotes']['quote_tvq'];
            $total = $data['quotes']['total'];

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
                <td class="totalNumberTitle" colspan="3">Discount</td>
                <td class="totalNumberResult">$ <?php echo number_format($discount, 2); ?></td>
            </tr>
            <tr class="totalTbl">
                <td class="totalNumberTitle" colspan="3">SubTotal</td>
                <td class="totalNumberResult">$ <?php echo number_format($subTotal, 2); ?></td>
            </tr>
            <tr class="totalTbl">
                <td class="totalNumberTitle" colspan="3">TPS</td>
                <td class="totalNumberResult">$ <?php echo number_format($tps, 2); ?></td>
            </tr>
            <tr class="totalTbl">
                <td class="totalNumberTitle" colspan="3">TVQ</td>
                <td class="totalNumberResult">$ <?php echo number_format($tvq, 2); ?></td>
            </tr>
            <tr class="totalTbl">
                <td class="totalNumberTitle" colspan="3">Total</td>
                <td class="totalNumberResult">$ <?php echo number_format($total, 2); ?></td>
            </tr>
        </tbody>
    </table>
    <div class="message">
        <h4>Validity Period: <?php echo $data['quotes']['validity']; ?></h4>
        <h4>Payment Method: <?php echo $data['quotes']['pay_method']; ?></h4>
        <br>
        <?php echo $data['companies']['message']; ?>
    </div>
</body>

</html>