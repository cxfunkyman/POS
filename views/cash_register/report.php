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
            <?php if ($data['actual']) { ?>
            <td class="invoicePurchase">
                <div class="invoiceContainer">
                    <span class="invoiceReport">Movements</span>
                    <p style="text-align:center"><strong>Present</strong></p>
                    <p>User: <?php echo $_SESSION['user_name']; ?></p>
                    <p>Date: <?php echo date('H:m:s m-d-Y'); ?></p>
                </div>
            </td>
        </tr>
    </table>
    <h5 class="title">Sale Details</h5>
    <table id="productContainer">
        <thead>
            <tr>
                <th>Initial Amount</th>
                <th>Income</th>
                <th>Expenses</th>
                <th>Discounts</th>
                <th>Outcome</th>
                <th>Credits</th>
                <th>Balance</th>
            </tr>
        </thead>
        <tbody>
                <tr class="summaryTbl">
                    <td><?php echo $data['movements']['initialAmountDecimal']; ?></td>
                    <td><?php echo $data['movements']['incomeDecimal']; ?></td>
                    <td><?php echo $data['movements']['expensesDecimal']; ?></td>
                    <td><?php echo $data['movements']['discountDecimal']; ?></td>
                    <td><?php echo $data['movements']['outcomeDecimal']; ?></td>
                    <td><?php echo $data['movements']['creditsDecimal']; ?></td>
                    <td><?php echo $data['movements']['balanceDecimal']; ?></td>
                </tr>
        </tbody>
    </table>
    <?php } else { ?>
        <td class="invoicePurchase">
                <div class="invoiceContainer">
                    <span class="invoiceReport">Movements</span>
                    <p style="text-align:center"><strong>Cash Register: <?php echo $data['idCRegister'] ?></strong></p>
                    <p>User: <?php echo $_SESSION['user_name']; ?></p>
                    <p>Date: <?php echo date('H:m:s m-d-Y'); ?></p>
                </div>
            </td>
        </tr>
    </table>
    <h5 class="title">Sale Details</h5>
    <table id="productContainer">
        <thead>
            <tr>
                <th>Initial Amount</th>
                <th>Income</th>
                <th>Expenses</th>
                <th>Outcome</th>
                <th>Balance</th>
            </tr>
        </thead>
        <tbody>
                <tr class="summaryTbl">
                    <td><?php echo $data['movements']['initialAmountDecimal']; ?></td>
                    <td><?php echo $data['movements']['incomeDecimal']; ?></td>
                    <td><?php echo $data['movements']['expensesDecimal']; ?></td>
                    <td><?php echo $data['movements']['outcomeDecimal']; ?></td>
                    <td><?php echo $data['movements']['balanceDecimal']; ?></td>
                </tr>
        </tbody>
    </table>
    <?php } ?>
    <div class="message">
        <?php echo $data['companies']['message']; ?>
    </div>
</body>

</html>