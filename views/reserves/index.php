<?php include_once 'views/templates/header.php'; ?>

<div class="card">
    <div class="card-body">
        <nav>
            <div class="nav nav-tabs" id="nav-tab" role="tablist">
                <button class="nav-link active" id="nav-reserves-tab" data-bs-toggle="tab" data-bs-target="#nav-reserves" type="button" role="tab" aria-controls="nav-reserves" aria-selected="true">Reserves</button>
                <button class="nav-link" id="nav-record-tab" data-bs-toggle="tab" data-bs-target="#nav-record" type="button" role="tab" aria-controls="nav-record" aria-selected="false">Record</button>
            </div>
        </nav>
        <div class="tab-content" id="nav-tabContent">
            <div class="tab-pane fade show active p-3" id="nav-reserves" role="tabpanel" aria-labelledby="nav-reserves-tab" tabindex="0">
                <!--first tab-->
                <h5 class="card-title text-center"><i class="fa-solid fa-hand-holding-dollar"></i> Reserves</h5>
                <hr>
                <div id='calendar'></div>
            </div>
            <div class="tab-pane fade p-3" id="nav-record" role="tabpanel" aria-labelledby="nav-record-tab" tabindex="0">
                <!--second tab-->
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
            </div>
        </div>

    </div>
</div>

<div id="modalReserve" class="modal fade" data-bs-backdrop="static" data-bs-keyboard="false" role="dialog" aria-labelledby="my-modal-title" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Reserve Produts</h5>
                <button class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                </button>
            </div>
            <div class="modal-body">
                <div class="row mb-2">
                    <div class="col-md-12">
                        <div class="btn-group btn-group-toggle mb-2" data-toggle="buttons">
                            <label class="btn btn-primary">
                                <input type="radio" checked id="radioBarcode" name="searchProduct"> <i class="fas fa-barcode"></i> Barcode
                            </label>
                            <label class="btn btn-info">
                                <input type="radio" id="radioName" name="searchProduct"> <i class="fas fa-list"></i> Name
                            </label>
                        </div>
                    </div>
                    <div class="col-md-12">
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
                    </div>
                    <div class="col-md-12">
                        <div class="table-responsive">
                            <table class="table table-bordered table-striped table-hover align-middle" id="tblReserves" style="width: 100%;">
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
                    </div>
                </div>
                <hr>
                <div class="row justify-content-between">
                    <div class="col-md-12">
                        <label>Search Client</label>
                        <div class="input-group mb-2">
                            <input type="hidden" id="idClient">
                            <span class="input-group-text"><i class="fas fa-search"></i></span>
                            <input class="form-control" type="text" id="searchClient" name="searchClient" placeholder="Search Client" autocomplete="off">
                        </div>
                    </div>
                    <div class="col-md-4">
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
                        <label>Address</label>
                        <div class="input-group mb-2">
                            <span class="input-group-text"><i class="fas fa-home"></i></span>
                            <input class="form-control" type="text" id="addressClient" placeholder="Client Address" disabled>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <label>Seller</label>
                        <div class="input-group mb-2">
                            <span class="input-group-text"><i class="fas fa-user"></i></span>
                            <input class="form-control" type="text" id="nameSeller" value="<?php echo $_SESSION['user_name']; ?>" placeholder="Seller" disabled>
                        </div>
                        <label>Total Amount</label>
                        <div class="input-group mb-2">
                            <span class="input-group-text"><i class="fas fa-dollar-sign"></i></span>
                            <input class="form-control" type="text" id="totalAmount" placeholder="Total Amount" disabled>
                        </div>
                        <label>Reserve Date</label>
                        <div class="input-group mb-2">
                            <span class="input-group-text"><i class="fas fa-calendar-alt"></i></span>
                            <input class="form-control" type="date" id="reserveDate" min="<?php echo date('Y-m-d'); ?>">
                        </div>
                    </div>
                    <div class="col-md-4">
                        <label>Withdraw Date</label>
                        <div class="input-group mb-2">
                            <span class="input-group-text"><i class="fas fa-calendar"></i></span>
                            <input class="form-control" type="date" id="withdrawDate">
                        </div>
                        <label>Deposit</label>
                        <div class="input-group mb-2">
                            <span class="input-group-text"><i class="fas fa-dollar-sign"></i></span>
                            <input class="form-control" type="number" step="0.01" min="0.01" id="depositAmount" placeholder="Deposit">
                        </div>
                        <label>Date Color</label>
                        <div class="input-group mb-2">
                            <span class="input-group-text"><i class="fa fa-fill-drip"></i></span>
                            <input class="form-control" type="color" value="#7ac2ca" id="dateColor">
                        </div><br>
                    </div>
                    <div class="row justify-content-between">
                        <div class="col-md-4 mb-2">
                            <div class="d-grid">
                                <button class="btn btn-outline-primary" id="btnComplete">Add Deposit</button>
                            </div>
                        </div>
                        <div class="col-md-4 mb-2">
                            <div class="d-grid">
                                <button class="btn btn-outline-warning" id="btnAddClean">Clear Fields</button>
                            </div>
                        </div>
                        <div class="col-md-4 mb-2">
                            <div class="d-grid">
                                <button class="btn btn-outline-danger" id="btnAddCancel">Cancel</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php include_once 'views/templates/footer.php'; ?>