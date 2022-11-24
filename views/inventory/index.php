<?php include_once 'views/templates/header.php'; ?>

<div class="card">
    <div class="card-body">
        <nav>
            <div class="nav nav-tabs" id="nav-tab" role="tablist">
                <button class="nav-link active" id="nav-inventory-tab" data-bs-toggle="tab" data-bs-target="#nav-inventory" type="button" role="tab" aria-controls="nav-clients" aria-selected="true">Inventory</button>
                <button class="nav-link" id="nav-kardex-tab" data-bs-toggle="tab" data-bs-target="#nav-kardex" type="button" role="tab" aria-controls="nav-kardex" aria-selected="false">Kardex</button>
            </div>
        </nav>
        <div class="tab-content" id="nav-tabContent">
            <div class="tab-pane fade show active mt-3" id="nav-inventory" role="tabpanel" aria-labelledby="nav-inventory-tab" tabindex="0">
                <div class="alert alert-info border-0 bg-info alert-dismissible fade show py-2">
                    <div class="d-flex align-items-center">
                        <div class="font-35 text-white"><i class='fas fa-check-circle'></i>
                        </div>
                        <div class="ms-3">
                            <h6 class="mb-0 text-black">PRODUCTS MOVEMENTS</h6>
                            <div class="text-dark">Inventory and Kardex management</div>
                        </div>
                    </div>
                </div>
                <label for="invMonth"><b>Inventory Month</b></label>
                <div class="d-flex mb-3">
                    <div class="form-group">
                        <input id="invMonth" class="form-control" type="month">
                    </div>
                    <div>
                        <button id="btnSearch" class="btn btn-primary ms-2" type="button"><i class="fas fa-search"></i></button>
                        <button id="btnReport" class="btn btn-danger ms-1" type="button"><i class="fas fa-file-pdf"></i></button>
                        <button id="btnConfig" class="btn btn-info ms-1" type="button"><i class="fas fa-cog"></i></button>
                    </div>
                </div>
                <hr>
                <div class="table-responsive">
                    <table class="table table-bordered table-striped table-hover align-middle nowrap" id="tblInventory" style="width: 100%;">
                        <thead>
                            <tr>
                                <th>Product</th>
                                <th>Movement</th>
                                <th>Action</th>
                                <th>Quantity</th>
                                <th>Date</th>
                                <th>Time</th>
                                <th>Product Code</th>
                                <th>Photo</th>
                                <th>Employee</th>
                            </tr>
                        </thead>
                        <tbody>
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="tab-pane fade p-3" id="nav-kardex" role="tabpanel" aria-labelledby="nav-kardex-tab" tabindex="0">

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
                <!-- the next input is for search products with code/barcode-->
                <div class="input-group mb-2" id="barcodeContainer">
                    <span class="input-group-text"><i class="fas fa-search"></i></span>
                    <input class="form-control" type="number" id="searchBarcodeInput" name="searchBarcodeInput" placeholder="Search by Code" autocomplete="off">
                    <span class="input-group-text"><button class="btn btn-danger" type="button"><i class="fas fa-file-pdf"></i></button></span>
                </div>

                <!-- the next input is for search products with names-->
                <div class="input-group d-none mb-2" id="nameContainer">
                    <span class="input-group-text"><i class="fas fa-search"></i></span>
                    <input class="form-control" type="text" id="searchNameInput" name="searchNameInput" placeholder="Search by Name" autocomplete="off">
                    <span class="input-group-text"><button class="btn btn-danger" type="button"><i class="fas fa-file-pdf"></i></button></span>
                </div>
                <span class="text-danger fw-bold mb-2" id="errorSearch"></span>


            </div>
        </div>
    </div>
</div>




<?php include_once 'views/templates/footer.php'; ?>