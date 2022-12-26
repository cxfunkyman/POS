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
    <?php foreach ($data['products'] as $product) { ?>
        <div style="text-align:center">
            <img src="<?php echo BASE_URL . $product['barcode'] ?>">
            <br>
            <p><?php echo $product['code'] ?></p>
            <br>
        </div>
    <?php } ?>

</body>

</html>