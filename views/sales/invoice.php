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
                    <span class="invoiceReport">Invoice</span>
                    <p>N°: <strong><?php echo $data['sales']['serie']; ?></strong></p>
                    <p>Date: <?php echo $data['sales']['dates']; ?></p>
                    <p>Time: <?php echo $data['sales']['time_day']; ?></p>
                </div>
            </td>
        </tr>
    </table>
    <h5 class="title">Client information</h5>
    <table id="supplierContainer">
        <tr>
            <td>
                <strong><?php echo $data['sales']['identification'] ?>: </strong>
                <p><?php echo $data['sales']['num_identity'] ?></p>
            </td>
            <td>
                <strong>Name: </strong>
                <p><?php echo $data['sales']['name'] ?></p>
            </td>
        </tr>
        <tr>
            <td>
                <strong>Phone: </strong>
                <p><?php echo $data['sales']['phone_number'] ?></p>
            </td>
            <td>
                <strong>Address: </strong>
                <p><?php echo $data['sales']['address'] ?></p>
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
            $products = json_decode($data['sales']['products'], true);
            //TAX INCLUDE            
            $discount = $data['sales']['discount_amount'];
            $subTotal = $data['sales']['subtotal'];
            $tps = $data['sales']['sale_tps'];
            $tvq = $data['sales']['sale_tvq'];
            $total = $data['sales']['total'];

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
        <h3><?php echo $data['sales']['pay_method']; ?></h3>
        <?php echo $data['companies']['message']; ?>
    </div>
    <?php if ($data['sales']['status'] == 0) { ?>
        <h1 class="orderCancel">-SALE CANCELLED-</h1>
    <?php }
    ?>
</body>

</html>