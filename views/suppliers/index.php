<?php include_once 'views/templates/header.php'; ?>

<div class="card">
    <div class="card-body">
        <div class="d-flex align-items-center">
            <div></div>
            <div class="dropdown ms-auto">
                <a class="dropdown-toggle dropdown-toggle-nocaret" href="#" data-bs-toggle="dropdown"><i class='bx bx-dots-horizontal-rounded font-22 text-option'></i>
                </a>
                <ul class="dropdown-menu">
                    <li><a class="dropdown-item" href="<?php echo BASE_URL . 'suppliers/inactiveSupplier'; ?>"><i class="fas fa-trash text-danger" style="color: rgb(255, 0, 0)"></i> Inactive Supplier</a>
                    </li>
                </ul>
            </div>
        </div>
        <nav>
            <div class="nav nav-tabs" id="nav-tab" role="tablist">
                <button class="nav-link active" id="nav-suppliers-tab" data-bs-toggle="tab" data-bs-target="#nav-suppliers" type="button" role="tab" aria-controls="nav-suppliers" aria-selected="true">Suppliers</button>
                <button class="nav-link" id="nav-new-tab" data-bs-toggle="tab" data-bs-target="#nav-new" type="button" role="tab" aria-controls="nav-new" aria-selected="false">New</button>
            </div>
        </nav>
        <div class="tab-content" id="nav-tabContent">
            <div class="tab-pane fade show active mt-3" id="nav-suppliers" role="tabpanel" aria-labelledby="nav-suppliers-tab" tabindex="0">
                <h5 class="card-title text-center"><i class="fas fa-users"></i> Suppliers List</h5>
                <hr>
                <div class="table-responsive">
                    <table class="table table-bordered table-striped table-hover align-middle nowrap" id="tblSuppliers" style="width: 100%;">
                        <thead>
                            <tr>
                                <th>Identification</th>
                                <th>Name</th>
                                <th>Phone Number</th>
                                <th>Email</th>
                                <th>Address</th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody>
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="tab-pane fade p-3" id="nav-new" role="tabpanel" aria-labelledby="nav-new-tab" tabindex="0">
                <form id="supplierForm" autocomplete="off">
                    <input type='hidden' id='idSupplier' name='idSupplier'>
                    <div class="row mb-3">
                        <div class="col-md-4 mb-3">
                            <label for="supplierTaxID">Identification<span class="text-danger"> *</span></label>
                            <div class="input-group">
                                <span class="input-group-text"><i class="fas fa-list"></i></span>
                                <input class="form-control" type="number" name="supplierTaxID" id="supplierTaxID" placeholder="Indentity Number">
                            </div>
                            <span id="errorSupplierTaxID" class="text-danger"></span>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="supplierName">Names<span class="text-danger"> *</span></label>
                            <div class="input-group">
                                <span class="input-group-text"><i class="fas fa-list"></i></span>
                                <input class="form-control" type="text" name="supplierName" id="supplierName" placeholder="Supplier Name">
                            </div>
                            <span id="errorSupplierName" class="text-danger"></span>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="supplierPhone">Phone Number<span class="text-danger"> *</span></label>
                            <div class="input-group">
                                <span class="input-group-text"><i class="fas fa-list"></i></span>
                                <input class="form-control" type="number" name="supplierPhone" id="supplierPhone" placeholder="Phone Number">
                            </div>
                            <span id="errorSupplierPhone" class="text-danger"></span>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="supplierEmail">Email<span class="text-danger"> *</span></label>
                            <div class="input-group">
                                <span class="input-group-text"><i class="fas fa-list"></i></span>
                                <input class="form-control" type="text" name="supplierEmail" id="supplierEmail" placeholder="Email">
                            </div>
                            <span id="errorSupplierEmail" class="text-danger"></span>
                        </div>
                        <div class="col-md-12 mb-3">
                            <div class="form-group">
                                <label for="supplierAddress">Address<span class="text-danger"> *</span></label>
                                <textarea id="supplierAddress" class="form-control" name="supplierAddress" rows="3" placeholder="Address"></textarea>
                            </div>
                            <span id="errorSupplierAddress" class="text-danger"></span>
                        </div>
                    </div>
                    <div class="text-end">
                        <button class="btn btn-danger" type="button" id="btnSNew">New</button>
                        <button class="btn btn-primary" type="submit" id="btnSRegister">Register</button>
                    </div>

                </form>
            </div>
        </div>
    </div>
</div>



<?php include_once 'views/templates/footer.php'; ?>