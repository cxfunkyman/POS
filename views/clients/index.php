<?php include_once 'views/templates/header.php'; ?>

<div class="card">
    <div class="card-body">
        <div class="d-flex align-items-center">
            <div></div>
            <div class="dropdown ms-auto">
                <a class="dropdown-toggle dropdown-toggle-nocaret" href="#" data-bs-toggle="dropdown"><i class='bx bx-dots-horizontal-rounded font-22 text-option'></i>
                </a>
                <ul class="dropdown-menu">
                    <li><a class="dropdown-item" href="<?php echo BASE_URL . 'clients/inactiveClient'; ?>"><i class="fas fa-trash text-danger" style="color: rgb(255, 0, 0)"></i> Inactive Client</a>
                    </li>
                </ul>
            </div>
        </div>
        <nav>
            <div class="nav nav-tabs" id="nav-tab" role="tablist">
                <button class="nav-link active" id="nav-clients-tab" data-bs-toggle="tab" data-bs-target="#nav-clients" type="button" role="tab" aria-controls="nav-clients" aria-selected="true">Clients</button>
                <button class="nav-link" id="nav-new-tab" data-bs-toggle="tab" data-bs-target="#nav-new" type="button" role="tab" aria-controls="nav-new" aria-selected="false">New</button>
            </div>
        </nav>
        <div class="tab-content" id="nav-tabContent">
            <div class="tab-pane fade show active mt-3" id="nav-clients" role="tabpanel" aria-labelledby="nav-clients-tab" tabindex="0">
                <h5 class="card-title text-center"><i class="fas fa-users"></i> Clients List</h5>
                <hr>
                <div class="table-responsive">
                    <table class="table table-bordered table-striped table-hover align-middle nowrap" id="tblClients" style="width: 100%;">
                        <thead>
                            <tr>
                                <th>Identity</th>
                                <th>Identity Number</th>
                                <th>Names</th>
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
                <form id="clientForm" autocomplete="off">
                    <input type='hidden' id='idClient' name='idClient'>
                    <div class="row mb-3">
                            <div class="col-md-2 mb-3">
                                <label for="clientID">Identity<span class="text-danger"> *</span></label>
                                <select id="clientID" class="form-control" name="clientID">
                                    <option value="">ID Type</option>
                                    <option value="Driver License">Driver License</option>
                                    <option value="Maladie">Maladie</option>
                                    <option value="Passport">Passport</option>
                                </select>
                                <span id="errorClientID" class="text-danger"></span>
                            </div>
                            <div class="col-md-4 mb-3">
                                <label for="clientIDNumb">Identity Number<span class="text-danger"> *</span></label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="fas fa-list"></i></span>
                                    <input class="form-control" type="number" name="clientIDNumb" id="clientIDNumb" placeholder="Indentity Number">
                                </div>
                                <span id="errorClientIDNumb" class="text-danger"></span>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="clientName">Names<span class="text-danger"> *</span></label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="fas fa-list"></i></span>
                                    <input class="form-control" type="text" name="clientName" id="clientName" placeholder="Client Name">
                                </div>
                                <span id="errorClientName" class="text-danger"></span>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="clientPhone">Phone Number<span class="text-danger"> *</span></label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="fas fa-list"></i></span>
                                    <input class="form-control" type="number" name="clientPhone" id="clientPhone" placeholder="Phone Number">
                                </div>
                                <span id="errorClientPhone" class="text-danger"></span>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="clientEmail">Email</label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="fas fa-list"></i></span>
                                    <input class="form-control" type="text" name="clientEmail" id="clientEmail" placeholder="Client Email">
                                </div>
                                <span id="errorClientEmail" class="text-danger"></span>
                            </div>
                            <div class="col-md-12 mb-3">
                                <div class="form-group">
                                    <label for="clientAddress">Address<span class="text-danger"> *</span></label>
                                    <textarea id="clientAddress" class="form-control" name="clientAddress" rows="3" placeholder="Address"></textarea>
                                </div>
                                <span id="errorClientAddress" class="text-danger"></span>
                            </div>
                    </div>
                    <div class="text-end">
                        <button class="btn btn-danger" type="button" id="btnClientNew">New</button>
                        <button class="btn btn-primary" type="submit" id="btnClientRegister">Register</button>
                    </div>

                </form>
            </div>
        </div>
    </div>
</div>


<?php include_once 'views/templates/footer.php'; ?>