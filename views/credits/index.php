<?php include_once 'views/templates/header.php'; ?>

<div class="card">
    <div class="card-body">
        <div class="d-flex align-items-center">
            <div></div>
            <div class="dropdown ms-auto">
                <a class="dropdown-toggle dropdown-toggle-nocaret" href="#" data-bs-toggle="dropdown"><i class='bx bx-dots-horizontal-rounded font-22 text-option'></i>
                </a>
                <ul class="dropdown-menu">
                    <li><a class="dropdown-item" href="#" id="newModalDeposit"><i class="fas fa-dollar-sign" style="color: rgb(0, 155, 0)"></i> Deposits</a>
                    </li>
                </ul>
            </div>
        </div>
        <nav>
            <div class="nav nav-tabs" id="nav-tab" role="tablist">
                <button class="nav-link active" id="nav-credits-tab" data-bs-toggle="tab" data-bs-target="#nav-credits" type="button" role="tab" aria-controls="nav-credits" aria-selected="true">Credits</button>
                <button class="nav-link" id="nav-deposits-tab" data-bs-toggle="tab" data-bs-target="#nav-deposits" type="button" role="tab" aria-controls="nav-deposits" aria-selected="false">Deposits</button>
            </div>
        </nav>
        <div class="tab-content" id="nav-tabContent">
            <div class="tab-pane fade show active mt-3" id="nav-credits" role="tabpanel" aria-labelledby="nav-credits-tab" tabindex="0">
                <h5 class="card-title text-center"><i class="fas fa-credit-card"></i> Credits List</h5>
                <hr>
                <div class="table-responsive">
                    <table class="table table-bordered table-striped table-hover align-middle nowrap" id="tblCredits" style="width: 100%;">
                        <thead>
                            <tr>
                                <th>Amount</th>
                                <th>Date</th>
                                <th>Client</th>
                                <th>Remaining</th>
                                <th>Deposit</th>
                                <th>Sale Nº</th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody>
                        </tbody>
                    </table>

                </div>
            </div>
            <div class="tab-pane fade p-3" id="nav-deposits" role="tabpanel" aria-labelledby="nav-deposits-tab" tabindex="0">

            </div>
        </div>
    </div>
</div>
<div id="modalDeposit" class="modal fade" data-bs-backdrop="static" data-bs-keyboard="false" role="dialog" aria-labelledby="my-modal-title" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Add Deposit</h5>
                <button class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                </button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-12">
                        <label>Search Client</label>
                        <div class="input-group mb-2">
                            <input type="hidden" id="idCredits">
                            <span class="input-group-text"><i class="fas fa-search"></i></span>
                            <input class="form-control" type="text" id="searchClientCredits" name="searchClientCredits" placeholder="Search Client" autocomplete="off">
                        </div>
                    </div>
                    <div class="col-md-12">
                        <label>Client</label>
                        <div class="input-group mb-2">
                            <span class="input-group-text"><i class="fas fa-home-user"></i></span>
                            <input class="form-control" type="text" id="clientName" placeholder="Client Name" disabled>
                        </div>
                    </div>
                    <div class="col-md-12">
                        <label>Phone Number</label>
                        <div class="input-group mb-2">
                            <span class="input-group-text"><i class="fas fa-phone"></i></span>
                            <input class="form-control" type="number" id="phoneClient" placeholder="Phone Number" disabled>
                        </div>
                    </div>
                    <div class="col-md-12 mb-2">
                        <label>Address</label>
                        <div class="input-group mb-2">
                            <span class="input-group-text"><i class="fas fa-home"></i></span>
                            <input class="form-control" type="text" id="addressClient" placeholder="Client Address" disabled>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <Label>Abonate</label>
                        <div class="input-group">
                            <span class="input-group-text"><i class="fas fa-dollar-sign"></i></span>
                            <input class="form-control" type="text" id="clientAbonate" placeholder="Abonated" disabled>
                        </div>
                    </div>
                    <div class="col-md-6 mb-2">
                        <label>Remaining</label>
                        <div class="input-group">
                            <span class="input-group-text"><i class="fas fa-dollar-sign"></i></span>
                            <input class="form-control" type="text" id="clientRemaining" placeholder="Remaining" disabled>
                        </div>
                    </div>
                    <div class="col-md-6 mb-2">
                        <div class="form-group">
                            <label for="salesDates">Sale Date</label>
                            <input id="salesDates" class="form-control" type="text" placeholder="Sale Date" disabled>
                        </div>
                    </div>
                    <div class="col-md-6 mb-2">
                        <div class="form-group">
                            <label for="totalAmount">Total Amount</label>
                            <input id="totalAmount" class="form-control" type="text" placeholder="Total Amount" disabled>
                        </div>
                    </div>
                    <div class="col-md-6 mb-3">
                        <div class="form-group">
                            <label for="clientDeposit">Deposit</label>
                            <input id="clientDeposit" class="form-control" type="number" step="0.01" min="0.01" placeholder="Deposit">
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-4 mb-2">
                    <div class="d-grid">
                    <button class="btn btn-primary" id="btnAddDeposit">Add Deposit</button>
                </div>
                    </div>
                    <div class="col-md-4 mb-2">
                    <div class="d-grid">
                    <button class="btn btn-warning" id="btnAddClean">Clear Fields</button>
                </div>
                    </div>
                    <div class="col-md-4 mb-2">
                    <div class="d-grid">
                    <button class="btn btn-danger" id="btnAddCancel">Cancel</button>
                </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php include_once 'views/templates/footer.php'; ?>