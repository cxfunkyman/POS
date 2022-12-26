<?php include_once 'views/templates/header.php'; ?>

<div class="card">
    <div class="card-body">
        <div class="d-flex align-items-center">
            <div></div>
            <div class="dropdown ms-auto">
                <a class="dropdown-toggle dropdown-toggle-nocaret" href="#" data-bs-toggle="dropdown"><i class='bx bx-dots-horizontal-rounded font-22 text-option'></i>
                </a>
                <ul class="dropdown-menu">
                    <li><a class="dropdown-item" href="<?php echo BASE_URL . 'products/inactiveProduct'; ?>"><i class="fas fa-trash text-warning" style="color: rgb(255, 0, 0)"></i> Inactive Product</a>
                    </li>
                    <hr class="dropdown-divider">
                    <li><a class="dropdown-item" href="<?php echo BASE_URL . 'products/activeProductPDF' ?>" target="_blank"><i class="fas fa-file-pdf text-danger"></i> Active PDF</a>
                    </li>
                    <li><a class="dropdown-item" href="<?php echo BASE_URL . 'products/activeProductExcel' ?>"><i class="fas fa-file-excel text-success"></i> Active Excel</a>
                    </li>
                    <hr class="dropdown-divider">
                    <li><a class="dropdown-item" href="<?php echo BASE_URL . 'products/generateBarcode' ?>" target="_blank"><i class="fas fa-barcode text-primary"></i> Barcode All</a>
                    </li>
                </ul>
            </div>
        </div>
        <nav>
            <div class="nav nav-tabs" id="nav-tab" role="tablist">
                <button class="nav-link active" id="nav-products-tab" data-bs-toggle="tab" data-bs-target="#nav-products" type="button" role="tab" aria-controls="nav-products" aria-selected="true">Products</button>
                <button class="nav-link" id="nav-new-tab" data-bs-toggle="tab" data-bs-target="#nav-new" type="button" role="tab" aria-controls="nav-new" aria-selected="false">New</button>
            </div>
        </nav>
        <div class="tab-content" id="nav-tabContent">
            <div class="tab-pane fade show active mt-3" id="nav-products" role="tabpanel" aria-labelledby="nav-products-tab" tabindex="0">
                <h5 class="card-title text-center"><i class="fas fa-list"></i> Products List</h5>
                <hr>
                <div class="table-responsive">
                    <table class="table table-bordered table-striped table-hover nowrap" id="tblProducts" style="width: 100%;">
                        <thead>
                            <tr>
                                <th>Code</th>
                                <th>Product Name</th>
                                <th>Purchase Price</th>
                                <th>Sale Price</th>
                                <th>Quantity</th>
                                <th>Measure</th>
                                <th>Category</th>
                                <th>Photo</th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody>
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="tab-pane fade p-3" id="nav-new" role="tabpanel" aria-labelledby="nav-new-tab" tabindex="0">
                <form id="productForm" autocomplete="off">
                    <input type='hidden' id='idProduct' name='idProduct'>
                    <input type='hidden' id='actualPhoto' name='actualPhoto'>
                    <div class="row mb-3">
                        <div class="col-md-3 mb-3">
                            <label for="p_Code">Code</label>
                            <div class="input-group">
                                <span class="input-group-text"><i class="fas fa-barcode"></i></span>
                                <input class="form-control" type="text" name="p_Code" id="p_Code" placeholder="Code">
                            </div>
                            <span id="errorP_Code" class="text-danger"></span>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="p_Description">Product Name</label>
                            <div class="input-group">
                                <span class="input-group-text"><i class="fas fa-list"></i></span>
                                <input class="form-control" type="text" name="p_Description" id="p_Description" placeholder="Product Name">
                            </div>
                            <span id="errorP_Description" class="text-danger"></span>
                        </div>
                        <div class="col-md-3 mb-3">
                            <label for="p_Price">Purchase Price</label>
                            <div class="input-group">
                                <span class="input-group-text"><i class="fas fa-dollar-sign"></i></span>
                                <input class="form-control" type="number" step="0.01" min="0.01" name="p_Price" id="p_Price" placeholder="Purchase Price">
                            </div>
                            <span id="errorP_Price" class="text-danger"></span>
                        </div>
                        <div class="col-md-3 mb-3">
                            <label for="s_Price">Sales Price</label>
                            <div class="input-group">
                                <span class="input-group-text"><i class="fa-solid fa-hand-holding-dollar"></i></span>
                                <input class="form-control" type="number" step="0.01" min="0.01" name="s_Price" id="s_Price" placeholder="Sales Price">
                            </div>
                            <span id="errorS_Price" class="text-danger"></span>
                        </div>
                        <div class="col-md-4 mb-3">
                            <div class="form-group">
                                <label for="p_Measure">Measure</label>
                                <select class="form-control" name="p_Measure" id="p_Measure">
                                    <option value="">Select</option>
                                    <?php foreach ($data['measure'] as $measure) { ?>
                                        <option value="<?php echo $measure['id']; ?>"><?php echo $measure['measure']; ?></option>
                                    <?php } ?>
                                </select>
                            </div>
                            <span id="errorP_Measure" class="text-danger"></span>
                        </div>
                        <div class="col-md-5 mb-3">
                            <div class="form-group">
                                <label for="p_Category">Category</label>
                                <select class="form-control" name="p_Category" id="p_Category">
                                    <option value="">Select</option>
                                    <?php foreach ($data['category'] as $category) { ?>
                                        <option value="<?php echo $category['id']; ?>"><?php echo $category['category']; ?></option>
                                    <?php } ?>
                                </select>
                            </div>
                            <span id="errorP_Category" class="text-danger"></span>
                        </div>
                        <div class="col-md-6 mb-3">
                            <div class="form-group">
                                <label for="p_Photo">Photo (Optional)</label>
                                <input id="p_Photo" class="form-control" type="file" name="p_Photo">
                            </div>
                            <br>
                            <div id="containerPreview">
                            </div>
                        </div>
                    </div>
                    <div class="text-end">
                        <button class="btn btn-danger" type="button" id="btnPNew">New</button>
                        <button class="btn btn-primary" type="submit" id="btnPRegister">Register</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<?php include_once 'views/templates/footer.php'; ?>