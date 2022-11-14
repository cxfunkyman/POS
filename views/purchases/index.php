<?php include_once 'views/templates/header.php'; ?>

<div class="card">
    <div class="card-body">
        <nav>
            <div class="nav nav-tabs" id="nav-tab" role="tablist">
                <button class="nav-link active" id="nav-purchases-tab" data-bs-toggle="tab" data-bs-target="#nav-purchases" type="button" role="tab" aria-controls="nav-purchases" aria-selected="true">Purchases</button>
                <button class="nav-link" id="nav-record-tab" data-bs-toggle="tab" data-bs-target="#nav-record" type="button" role="tab" aria-controls="nav-record" aria-selected="false">Record</button>
            </div>
        </nav>
        <div class="tab-content" id="nav-tabContent">
            <div class="tab-pane fade show active p-3" id="nav-purchases" role="tabpanel" aria-labelledby="nav-purchases-tab" tabindex="0">
                <h5 class="card-title text-center"><i class="fas fa-truck"></i> New Purchase</h5>
                <hr>
                <div class="btn-group btn-group-toggle mb-2" data-toggle="buttons">
                    <label class="btn btn-primary">
                        <input type="radio" checked id="radioBarcode" name="searchProduct"> <i class="fas fa-barcode"></i> Barcode
                    </label>
                    <label class="btn btn-info">
                        <input type="radio" id="radioName" name="searchProduct"> <i class="fas fa-list"></i> Name
                    </label>
                </div>
                <!-- the next input is for search purchases with code/barcode-->
                <div class="input-group mb-2" id="barcodeContainer">
                    <span class="input-group-text"><i class="fas fa-search"></i></span>
                    <input class="form-control" type="number" id="searchBarcodeInput" name="searchBarcodeInput" placeholder="Search by Code" autocomplete="off">
                </div>

                <!-- the next input is for search purchases with names-->
                <div class="input-group d-none mb-2" id="nameContainer">
                    <span class="input-group-text"><i class="fas fa-search"></i></span>
                    <input class="form-control" type="text" id="searchNameInput" name="searchNameInput" placeholder="Search by Name" autocomplete="off">
                </div>
                <span class="text-danger fw-bold mb-2" id="errorSearch"></span>

                <!-- table to display the products -->
                <div class="table-responsive">
                    <table class="table table-bordered table-striped table-hover align-middle" id="tblPurchase" style="width: 100%;">
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
                        <label>Search Supplier</label>
                        <div class="input-group mb-2">
                            <input type="hidden" id="idSupplier">
                            <span class="input-group-text"><i class="fas fa-search"></i></span>
                            <input class="form-control" type="text" id="searchSupplier" name="searchSupplier" placeholder="Search Supplier" autocomplete="off">
                        </div>
                        <label>Supplier</label>
                        <div class="input-group mb-2">
                            <span class="input-group-text"><i class="fa-solid fa-cart-flatbed-suitcase"></i></span>
                            <input class="form-control" type="text" id="nameSupplier" placeholder="Supplier" disabled>
                        </div>
                        <label>Phone Number</label>
                        <div class="input-group mb-2">
                            <span class="input-group-text"><i class="fas fa-phone"></i></span>
                            <input class="form-control" type="number" id="phoneSupplier" placeholder="Phone Number" disabled>
                        </div>
                        <label>Address</label>
                        <ul class="list-group mb-2">
                            <li class="list-group-item" id="addressSupplier"><i class="fas fa-home"></i></li>
                        </ul>
                    </div>
                    <div class="col-md-4">
                        <label>Buyer</label>
                        <div class="input-group mb-2">
                            <span class="input-group-text"><i class="fas fa-user"></i></span>
                            <input class="form-control" type="text" id="nameBuyer" value="<?php echo $_SESSION['user_name']; ?>" placeholder="Client" disabled>
                        </div>
                        <label>Total Amount</label>
                        <div class="input-group mb-2">
                            <span class="input-group-text"><i class="fas fa-dollar-sign"></i></span>
                            <input class="form-control" type="text" id="totalAmount" placeholder="Total Amount" disabled>
                        </div>
                        <label>Purchase Number</label>
                        <div class="input-group mb-3">
                            <span class="input-group-text"><i class="fas fa-spinner"></i></span>
                            <input class="form-control" type="text" id="purchaseNumber" value="" placeholder="Purchase Number">
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
                                <th>Supplier</th>
                                <th>Purchase N°</th>
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