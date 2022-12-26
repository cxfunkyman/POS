<?php include_once 'views/templates/header.php'; ?>

<div class="card">
    <div class="card-body">
    <div class="d-flex align-items-center">
            <div></div>
            <div class="dropdown ms-auto">
                <a class="dropdown-toggle dropdown-toggle-nocaret" href="#" data-bs-toggle="dropdown"><i class='bx bx-dots-horizontal-rounded font-22 text-option'></i>
                </a>
                <ul class="dropdown-menu">
                    <li><a class="dropdown-item" href="<?php echo BASE_URL . 'products'; ?>"><i class="fas fa-boxes-stacked text-primary" style="color: rgb(255, 0, 0)"></i> Active Product</a>
                    </li>
                    <hr class="dropdown-divider">
                    <li><a class="dropdown-item" href="<?php echo BASE_URL . 'products/inactiveProductPDF' ?>" target="_blank"><i class="fas fa-file-pdf text-danger"></i> Inactive PDF</a>
                    </li>
                    <li><a class="dropdown-item" href="<?php echo BASE_URL . 'products/inactiveProductExcel' ?>"><i class="fas fa-file-excel text-success"></i> Inactive Excel</a>
                    </li>
                </ul>
            </div>
        </div>
        <h5 class="card-title text-center">Inactive Categories</h5>
        <hr>
        <div class="table-responsive">
            <table class="table table-bordered table-striped table-hover nowrap" id="tblInactiveProducts" style="width: 100%;">
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
</div>



<?php include_once 'views/templates/footer.php'; ?>