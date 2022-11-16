<?php include_once 'views/templates/header.php'; ?>

<div class="card">
    <div class="card-body">
        <nav>
            <div class="nav nav-tabs" id="nav-tab" role="tablist">
                <button class="nav-link active" id="nav-quotes-tab" data-bs-toggle="tab" data-bs-target="#nav-quotes" type="button" role="tab" aria-controls="nav-quotes" aria-selected="true">Quotes</button>
                <button class="nav-link" id="nav-record-tab" data-bs-toggle="tab" data-bs-target="#nav-record" type="button" role="tab" aria-controls="nav-record" aria-selected="false">Record</button>
            </div>
        </nav>
        <div class="tab-content" id="nav-tabContent">
            <div class="tab-pane fade show active p-3" id="nav-quotes" role="tabpanel" aria-labelledby="nav-quotes-tab" tabindex="0">
                <h5 class="card-title text-center"><i class="fa-solid fa-file-invoice-dollar"></i> New Quote</h5>
                <hr>
                <div class="row mb-2">
                    <div class="col-md-6">
                        <div class="btn-group btn-group-toggle mb-2" data-toggle="buttons">
                            <label class="btn btn-primary">
                                <input type="radio" checked id="radioBarcode" name="searchProduct"> <i class="fas fa-barcode"></i> Barcode
                            </label>
                            <label class="btn btn-info">
                                <input type="radio" id="radioName" name="searchProduct"> <i class="fas fa-list"></i> Name
                            </label>
                        </div>
                    </div>

                </div>
                <!-- the next input is for search quotes with code/barcode-->
                <div class="input-group mb-2" id="barcodeContainer">
                    <span class="input-group-text"><i class="fas fa-search"></i></span>
                    <input class="form-control" type="number" id="searchBarcodeInput" name="searchBarcodeInput" placeholder="Search by Code" autocomplete="off">
                </div>

                <!-- the next input is for search quotes with names-->
                <div class="input-group d-none mb-2" id="nameContainer">
                    <span class="input-group-text"><i class="fas fa-search"></i></span>
                    <input class="form-control" type="text" id="searchNameInput" name="searchNameInput" placeholder="Search by Name" autocomplete="off">
                </div>
                <span class="text-danger fw-bold mb-2" id="errorSearch"></span>

                <!-- table to display the products -->
                <div class="table-responsive">
                    <table class="table table-bordered table-striped table-hover align-middle" id="tblQuotes" style="width: 100%;">
                        <thead>
                            <tr>
                                <th>Product</th>
                                <th>Price</th>
                                <th>Quantity</th>
                                <th>Subtotal</th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody>
                        </tbody>
                    </table>
                </div>

                <hr>

                <div class="row justify-content-between">
                    <div class="col-md-4">
                        <label>Search Client</label>
                        <div class="input-group mb-2">
                            <input type="hidden" id="idClient">
                            <span class="input-group-text"><i class="fas fa-search"></i></span>
                            <input class="form-control" type="text" id="searchClient" name="searchClient" placeholder="Search Client" autocomplete="off">
                        </div>
                        <label>Client</label>
                        <div class="input-group mb-2">
                            <span class="input-group-text"><i class="fa-solid fa-cart-flatbed-suitcase"></i></span>
                            <input class="form-control" type="text" id="nameClient" placeholder="Client" disabled>
                        </div>
                        <label>Phone Number</label>
                        <div class="input-group mb-2">
                            <span class="input-group-text"><i class="fas fa-phone"></i></span>
                            <input class="form-control" type="number" id="phoneClient" placeholder="Phone Number" disabled>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <label>Address</label>
                        <ul class="list-group mb-2">
                            <li class="list-group-item" id="addressClient"><i class="fas fa-home"></i></li>
                        </ul>
                        <label>Seller</label>
                        <div class="input-group mb-2">
                            <span class="input-group-text"><i class="fas fa-user"></i></span>
                            <input class="form-control" type="text" id="nameSeller" value="<?php echo $_SESSION['user_name']; ?>" placeholder="Seller" disabled>
                        </div>
                        <label>Discount</label>
                        <div class="input-group mb-2">
                            <span class="input-group-text"><i class="fas fa-dollar-sign"></i></span>
                            <input class="form-control" type="text" id="discount" placeholder="discount">
                        </div>
                    </div>
                    <div class="col-md-4">
                        <label>Total Amount</label>
                        <div class="input-group mb-2">
                            <span class="input-group-text"><i class="fas fa-dollar-sign"></i></span>
                            <input class="form-control" type="text" id="totalAmount" placeholder="Total Amount" disabled>
                        </div>
                        <div class="form-group mb-2">
                            <label for="payMethod">Payment Method</label>
                            <select id="payMethod" class="form-control">
                                <option value="">Payment</option>
                                <option value="CASH">Cash</option>
                                <option value="CREDIT">Credit</option>
                            </select>
                        </div>
                        <div class="form-group mb-3">
                            <label for="quoteValidate">Offer Validity</label>
                            <select id="quoteValidate" class="form-control">
                                <option value="">Validity</option>
                                <option value="5 DAYS">5 DAYS</option>
                                <option value="10 DAYS">10 DAYS</option>
                                <option value="15 DAYS">15 DAYS</option>
                                <option value="20 DAYS">20 DAYS</option>
                                <option value="30 DAYS">30 DAYS</option>
                            </select>
                        </div>
                        <div class="d-grid">
                            <button class="btn btn-primary" type="button" id="btnComplete">Complete</button>
                        </div>
                    </div>
                </div>
            </div>
            <div class="tab-pane fade p-3" id="nav-record" role="tabpanel" aria-labelledby="nav-record-tab" tabindex="0">

                <div class="d-flex justify-content-center mb-3">
                    <div class="form-group">
                        <label for="fromInput">From</label>
                        <input id="fromInput" class="form-control" type="date">
                    </div>
                    &nbsp;&nbsp;
                    <div class="form-group">
                        <label for="toInput">To</label>
                        <input id="toInput" class="form-control" type="date">
                    </div>
                </div>
                <div class="table-responsive">
                    <table class="table table-bordered table-striped table-hover align-middle nowrap" id="tblRecords" style="width: 100%;">
                        <thead>
                            <tr>
                                <th>Date</th>
                                <th>Time</th>
                                <th>Total</th>
                                <th>Client</th>
                                <th>Validity</th>
                                <th>Payment Method</th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody>
                        </tbody>
                    </table>

                </div>
            </div>
        </div>
    </div>
</div>
<?php include_once 'views/templates/footer.php'; ?>