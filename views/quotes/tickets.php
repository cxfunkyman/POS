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
    </div>
    <h5 class="title">Client information</h5>
    <div class="data-info">
        <p><strong><?php echo $data['quotes']['identification'] ?>: </strong><?php echo $data['quotes']['num_identity'] ?></p>
        <p><strong>Name: </strong><?php echo $data['quotes']['name'] ?></p>
        <p><strong>Phone Number: </strong><?php echo $data['quotes']['phone_number'] ?></p>
    </div>
    <h5 class="title">Sale Details</h5>
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
            $products = json_decode($data['quotes']['products'], true);
            //TAX INCLUDE
            $subTotal = $data['quotes']['subtotal'];
            $discount = $data['quotes']['discount_amount'];
            $tps = $data['quotes']['quote_tps'];
            $tvq = $data['quotes']['quote_tvq'];
            $total = $data['quotes']['total'];

            foreach ($products as $product) { ?>
                <tr>
                    <td><?php echo $product['quantity']; ?></td>
                    <td><?php echo $product['name']; ?></td>
                    <td><?php echo number_format($product['sale_price'], 2); ?></td>
                    <td><?php echo number_format($product['quantity'] * ($product['sale_price']), 2); ?></td>
                </tr>
            <?php } ?>
            <tr>
                <td class="totalNumber1" colspan="3">Discount</td>
                <td class="totalNumber2">$ <?php echo number_format($discount, 2); ?></td>
            </tr>
            <tr>
                <td class="totalNumber1" colspan="3">SubTotal</td>
                <td class="totalNumber2">$ <?php echo number_format($subTotal, 2); ?></td>
            </tr>
            <tr>
                <td class="totalNumber1" colspan="3">TPS %</td>
                <td class="totalNumber2">$ <?php echo number_format($tps, 2); ?></td>
            </tr>
            <tr>
                <td class="totalNumber1" colspan="3">TVQ %</td>
                <td class="totalNumber2">$ <?php echo number_format($tvq, 2); ?></td>
            </tr>
            <tr>
                <td class="totalNumber1" colspan="3">Total</td>
                <td class="totalNumber2">$ <?php echo number_format($total, 2); ?></td>
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