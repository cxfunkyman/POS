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
                        <button id="btnInvAdjust" class="btn btn-info ms-1" type="button"><i class="fas fa-cog"></i></button>
                    </div>
                </div>
                <hr>
                <div class="table-responsive">
                    <table class="table table-bordered table-striped table-hover align-middle nowrap" id="tblInventory" style="width: 100%;">
                        <thead>
                            <tr>
                                <th>Product</th>
                                <th>Stock</th>
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
                    <input class="form-control" type="number" id="searchBarcodeInput" name="searchBarcodeInput" placeholder="Search by Code and press ENTER" autocomplete="off">
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

<div id="modalInvAdjust" class="modal fade" data-bs-backdrop="static" data-bs-keyboard="false" role="dialog" aria-labelledby="my-modal-title" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Inventory Adjustment</h5>
            </div>
            <div class="modal-body">
                <div class="alert border-0 border-start border-5 border-primary alert-dismissible fade show py-2">
                    <input type="hidden" id="idAjustProduct">
                    <div class="d-flex align-items-center">
                        <div class="font-35 text-primary"><i class='bx bx-info-circle'></i>
                        </div>
                        <div class="ms-3">
                            <h6 class="mb-0 text-primary">TO DECREASE INSERT NEGATIVE NUMBERS</h6>
                            <hr>
                            <h6 class="mb-0 text-primary">TO INCREASE INSERT POSITIVE NUMBERS</h6>
                        </div>
                    </div>
                </div>

                <div class="btn-group btn-group-toggle mb-3" data-toggle="buttons">
                    <label class="btn btn-primary">
                        <input type="radio" checked id="radioBarcodeFit" name="searchProductFit"> <i class="fas fa-barcode"></i> Barcode
                    </label>
                    <label class="btn btn-info">
                        <input type="radio" id="radioNameFit" name="searchProductFit"> <i class="fas fa-list"></i> Name
                    </label>
                </div>
                <!-- the next input is for search products with code/barcode-->
                <div class="input-group mb-2" id="barcodeContainerFit">
                    <span class="input-group-text"><i class="fas fa-search"></i></span>
                    <input class="form-control" type="number" id="searchBarcodeFit" name="searchBarcodeFit" placeholder="Search by Code and press ENTER" autocomplete="off">
                </div>

                <!-- the next input is for search products with names-->
                <div class="input-group d-none mb-2" id="nameContainerFit">
                    <span class="input-group-text"><i class="fas fa-search"></i></span>
                    <input class="form-control" type="text" id="searchNameFit" name="searchNameFit" placeholder="Search by Name" autocomplete="off">
                </div>
                <span class="text-danger fw-bold mb-2" id="errorSearch"></span>

                <div class="row">
                    <div class="col-md-8 mb-2">
                        <Label>Product Name</label>
                        <div class="input-group">
                            <span class="input-group-text"><i class="fas fa-list-alt"></i></span>
                            <input class="form-control" type="text" id="productNameFit" name="productNameFit" placeholder="Product Name" disabled>
                        </div>
                    </div>
                    <div class="col-md-4 mb-2">
                        <label>Stock</label>
                        <div class="input-group">
                            <span class="input-group-text"><i class="fas fa-boxes-stacked"></i></span>
                            <input class="form-control" type="number" id="productStockFit" name="productStockFit" placeholder="Stock" disabled>
                        </div>
                    </div>
                </div>

                <label for="adjustQty">ADJUSTMENT - / +</label>
                <div class="row">
                    <div class="col-md-6 mb-2">
                        <div class="form-group">
                            <input id="adjustQty" class="form-control" type="number" placeholder="Quantity">
                        </div>
                    </div>
                    <div class="col-md-3 mb-2">
                        <div class="d-grid">
                            <button class="btn btn-danger" type="button" id="btnCancelProcess">Cancel</button>
                        </div>
                    </div>
                    <div class="col-md-3 mb-2">
                        <div class="d-grid">
                            <button class="btn btn-primary" type="button" id="btnProcess">Process</button>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
</div>


<?php include_once 'views/templates/footer.php'; ?>