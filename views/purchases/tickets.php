<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $data['title']; ?></title>
    <link rel="stylesheet" href="<?php echo BASE_URL . 'assets/css/tickets.css'; ?>">
</head>

<body>
    <img src="<?php echo BASE_URL . 'assets/images/logo-img.png'; ?>" alt="">
    <div class="companyData">
        <p><?php echo $data['companies']['name'] ?></p>
        <p>Phone: <?php echo $data['companies']['phone_number'] ?></p>
        <p>Address: <?php echo $data['companies']['address'] ?></p>
        <p>Ticket: <strong><?php echo $data['purchases']['serie'] ?></strong></p>
    </div>
    <h5 class="title">Supplier information</h5>
    <div class="data-info">
        <p><strong>Tax ID: </strong><?php echo $data['purchases']['taxID'] ?></p>
        <p><strong>Name: </strong><?php echo $data['purchases']['name'] ?></p>
        <p><strong>Phone Number: </strong><?php echo $data['purchases']['phone_number'] ?></p>
    </div>
    <h5 class="title">Purchase Details</h5>
    <table>
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
            $products = json_decode($data['purchases']['products'], true);
            //TAX INCLUDE
            $subTotal = $data['purchases']['subtotal'];
            $tps = $data['purchases']['purchase_tps'];
            $tvq = $data['purchases']['purchase_tvq'];
            $total = $data['purchases']['total'];

            foreach ($products as $product) { ?>
                <tr>
                    <td><?php echo $product['quantity']; ?></td>
                    <td><?php echo $product['name']; ?></td>
                    <td><?php echo number_format($product['purchase_price'], 2); ?></td>
                    <td><?php echo number_format($product['quantity'] * ($product['purchase_price']), 2); ?></td>
                </tr>
            <?php } ?>
            <tr>
                <td class="totalNumber1" colspan="3">SubTotal</td>
                <td class="totalNumber2"><?php echo number_format($subTotal, 2); ?></td>
            </tr>
            <tr>
                <td class="totalNumber1" colspan="3">TPS</td>
                <td class="totalNumber2"><?php echo number_format($tps, 2); ?></td>
            </tr>
            <tr>
                <td class="totalNumber1" colspan="3">TVQ</td>
                <td class="totalNumber2"><?php echo number_format($tvq, 2); ?></td>
            </tr>
            <tr>
                <td class="totalNumber1" colspan="3">Total</td>
                <td class="totalNumber2"><?php echo number_format($total, 2); ?></td>
            </tr>
        </tbody>
    </table>
    <div class="message">
        <?php echo $data['companies']['message']; ?>
    </div>
    <?php if ($data['purchases']['status'] == 0) { ?>
        <h3 class="orderCancel">-ORDER CANCELLED-</h3>
    <?php }
    ?>
</body>

</html>