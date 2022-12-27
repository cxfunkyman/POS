<?php include_once 'views/templates/header.php'; ?>

<div class="card">
    <div class="card-body">
        <div class="d-flex align-items-center">
            <div></div>
            <div class="dropdown ms-auto">
                <a class="dropdown-toggle dropdown-toggle-nocaret" href="#" data-bs-toggle="dropdown"><i class='bx bx-dots-horizontal-rounded font-22 text-option'></i>
                </a>
                <ul class="dropdown-menu">
                    <li><a class="dropdown-item" href="<?php echo BASE_URL . 'users/inactive'; ?>"><i class="fas fa-trash text-danger" style="color: rgb(255, 0, 0)"></i> Inactive Users</a>
                    </li>
                </ul>
            </div>
        </div>
        <nav>
            <div class="nav nav-tabs" id="nav-tab" role="tablist">
                <button class="nav-link active" id="nav-users-tab" data-bs-toggle="tab" data-bs-target="#nav-users" type="button" role="tab" aria-controls="nav-users" aria-selected="true">Users</button>
                <button class="nav-link" id="nav-new-tab" data-bs-toggle="tab" data-bs-target="#nav-new" type="button" role="tab" aria-controls="nav-new" aria-selected="false">New</button>
            </div>
        </nav>
        <div class="tab-content" id="nav-tabContent">
            <div class="tab-pane fade show active mt-3" id="nav-users" role="tabpanel" aria-labelledby="nav-users-tab" tabindex="0">
                <h5 class="card-title text-center"><i class="fas fa-user"></i> Users List</h5>
                <hr>
                <div class="table-responsive">
                <table class="table table-bordered table-striped table-hover nowrap" id="tblUsers" style="width: 100%;">
                    <thead>
                        <tr>
                            <th>Name</th>
                            <th>Email</th>
                            <th>Phone Number</th>
                            <th>Address</th>
                            <th>Rol</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                    </tbody>
                </table>
                </div>
            </div>
            <div class="tab-pane fade mt-2" id="nav-new" role="tabpanel" aria-labelledby="nav-new-tab" tabindex="0">
                <form class="p-4" id="newForm" autocomplete="off">
                    <input type="hidden" id="idUser" name="idUser" class="form-control">
                    <div class="row">
                        <div class="col-lg-4 col-sm-6 mb-2">
                            <label>First Name</label>
                            <div class="input-group">
                                <span class="input-group-text"><i class="fas fa-list"></i></span>
                                <input type="text" id="fName" name="fName" class="form-control" placeholder="First Name" autocomplete="off">
                            </div>
                            <span id="errorFName" class="text-danger"></span>
                        </div>
                        <div class="col-lg-4 col-sm-6 mb-2">
                            <label>Last Name</label>
                            <div class="input-group">
                                <span class="input-group-text"><i class="fas fa-list-alt"></i></span>
                                <input type="text" id="lName" name="lName" class="form-control" placeholder="Last Name" autocomplete="off">
                            </div>
                            <span id="errorLName" class="text-danger"></span>
                        </div>
                        <div class="col-lg-4 col-sm-6 mb-2">
                            <label>Email</label>
                            <div class="input-group">
                                <span class="input-group-text"><i class="fas fa-envelope"></i></span>
                                <input type="email" id="email" name="email" class="form-control" placeholder="Email" autocomplete="off">
                            </div>
                            <span id="errorEmail" class="text-danger"></span>
                        </div>
                        <div class="col-lg-4 col-sm-6 mb-2">
                            <label>Phone Number</label>
                            <div class="input-group">
                                <span class="input-group-text"><i class="fas fa-phone"></i></span>
                                <input type="number" id="phone" name="phone" class="form-control" placeholder="Phone Number" autocomplete="off">
                            </div>
                            <span id="errorPhone" class="text-danger"></span>
                        </div>
                        <div class="col-lg-8 col-sm-6 mb-2">
                            <label>Address</label>
                            <div class="input-group">
                                <span class="input-group-text"><i class="fas fa-home"></i></span>
                                <input type="text" id="address" name="address" class="form-control" placeholder="Address" autocomplete="off">
                            </div>
                            <span id="errorAddress" class="text-danger"></span>
                        </div>
                        <div class="col-lg-4 col-sm-6 mb-2">
                            <label>Password</label>
                            <div class="input-group">
                                <span class="input-group-text"><i class="fas fa-lock"></i></span>
                                <input type="password" id="password" name="password" class="form-control" placeholder="Password" autocomplete="off">
                            </div>
                            <span id="errorPassword" class="text-danger"></span>
                        </div>
                        <div class="col-lg-4 col-sm-6 mb-2">
                            <label>Rol</label>
                            <div class="input-group">
                                <label class="input-group-text" for="rol"><i class="fas fa-id-card"></i></label>
                                <select class="form-select" id="rol" name="rol">
                                    <option value="" selected>Choose...</option>
                                    <option value="1">ADMIN</option>
                                    <option value="2">SALES-PERSON</option>
                                </select>
                            </div>
                            <span id="errorRol" class="text-danger"></span>
                        </div>
                    </div>
                    <div class="text-end">
                        <button class="btn btn-danger" type="button" id="btnNew">New</button>
                        <button class="btn btn-primary" type="submit" id="btnAction">Register</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<?php include_once 'views/templates/footer.php'; ?>