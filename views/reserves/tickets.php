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
        <p><strong><?php echo $data['reserves']['identification'] ?>: </strong><?php echo $data['reserves']['num_identity'] ?></p>
        <p><strong>Name: </strong><?php echo $data['reserves']['name'] ?></p>
        <p><strong>Phone Number: </strong><?php echo $data['reserves']['phone_number'] ?></p>
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
            $products = json_decode($data['reserves']['products'], true);

            $total = $data['reserves']['total'];
            $dates_reserves = $data['reserves']['dates_reserves'];
            $dates_withdraw = $data['reserves']['dates_withdraw'];
            $payment = $data['reserves']['payment'];
            
            foreach ($products as $product) { ?>
                <tr>
                    <td><?php echo $product['quantity']; ?></td>
                    <td><?php echo $product['name']; ?></td>
                    <td><?php echo number_format($product['sale_price'], 2); ?></td>
                    <td><?php echo number_format($product['quantity'] * ($product['sale_price']), 2); ?></td>
                </tr>
            <?php } ?>
            <tr>
                <td class="totalNumber1" colspan="3">Payment</td>
                <td class="totalNumber2">$ <?php echo number_format($payment, 2); ?></td>
            </tr>
            <tr>
                <td class="totalNumber1" colspan="3">Total</td>
                <td class="totalNumber2">$ <?php echo number_format($total, 2); ?></td>
            </tr>
            <tr>
                <td class="totalNumberLabel" colspan="2">Reserve Date</td>
                <td class="totalNumber" colspan="2"><?php echo $dates_reserves; ?></td>
            </tr>
            <tr>
                <td class="totalNumberLabel" colspan="2">Withdraw Date</td>
                <td class="totalNumber" colspan="2"><?php echo $dates_withdraw; ?></td>
            </tr>
        </tbody>
    </table>
    <div class="message">
        <?php echo $data['companies']['message']; ?>
    </div>
</body>

</html>