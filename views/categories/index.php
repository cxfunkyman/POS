<?php include_once 'views/templates/header.php'; ?>

<div class="card">
    <div class="card-body">
    <div class="d-flex align-items-center">
            <div></div>
            <div class="dropdown ms-auto">
                <a class="dropdown-toggle dropdown-toggle-nocaret" href="#" data-bs-toggle="dropdown"><i class='bx bx-dots-horizontal-rounded font-22 text-option'></i>
                </a>
                <ul class="dropdown-menu">
                    <li><a class="dropdown-item" href="<?php echo BASE_URL . 'categories/inactiveCategory'; ?>"><i class="fas fa-trash text-danger" style="color: rgb(255, 0, 0)"></i> Inactive Category</a>
                    </li>
                </ul>
            </div>
        </div>
        <nav>
            <div class="nav nav-tabs" id="nav-tab" role="tablist">
                <button class="nav-link active" id="nav-categories-tab" data-bs-toggle="tab" data-bs-target="#nav-categories" type="button" role="tab" aria-controls="nav-categories" aria-selected="true">Categories</button>
                <button class="nav-link" id="nav-new-tab" data-bs-toggle="tab" data-bs-target="#nav-new" type="button" role="tab" aria-controls="nav-new" aria-selected="false">New</button>
            </div>
        </nav>
        <div class="tab-content" id="nav-tabContent">
            <div class="tab-pane fade show active mt-3" id="nav-categories" role="tabpanel" aria-labelledby="nav-categories-tab" tabindex="0">
                <h5 class="card-title text-center"><i class="fas fa-tag"></i> Categories List</h5>
                <hr>
                <div class="table-responsive">
                    <table class="table table-bordered table-striped table-hover nowrap" id="tblCategories" style="width: 100%;">
                        <thead>
                            <tr>
                                <th>Category Name</th>
                                <th>Dates</th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody>
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="tab-pane fade p-3" id="nav-new" role="tabpanel" aria-labelledby="nav-new-tab" tabindex="0">
                <form id="categoryForm" autocomplete="off">
                    <input type='hidden' id='idCategory' name='idCategory'>
                    <div class="row mb-3">
                        <div class="col-md-12">
                            <label for="categoryName">Category Name</label>
                            <div class="input-group">
                                <span class="input-group-text"><i class="fas fa-list"></i></span>
                                <input class="form-control" type="text" name="categoryName" id="categoryName" placeholder="Category Name">
                            </div>
                            <span id="errorCategoryName" class="text-danger"></span>
                        </div>
                    </div>
                    <div class="text-end">
                        <button class="btn btn-danger" type="button" id="btnCNew">New</button>
                        <button class="btn btn-primary" type="submit" id="btnCRegister">Register</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>



<?php include_once 'views/templates/footer.php'; ?>