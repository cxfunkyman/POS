<?php include_once 'views/templates/header.php'; ?>

<div class="card">
    <div class="card-body">
        <div class="alert alert-<?php echo (!empty($data['cashRegister'])) == 1 ? 'success' : 'danger'; ?> border-0 bg-<?php echo (!empty($data['cashRegister'])) == 1 ? 'success' : 'danger'; ?> alert-dismissible fade show py-2">
            <div class="d-flex align-items-center">
                <div class="font-35 text-white"><i class="fa-solid fa-<?php echo (!empty($data['cashRegister'])) == 1 ? 'lock-open' : 'lock'; ?>"></i>
                </div>
                <div class="ms-3">
                    <h6 class="mb-0 text-dark">Cash Register <?php echo (!empty($data['cashRegister'])) == 1 ? 'Open' : 'Close'; ?></h6>
                    <div class="text-dark">A simple success alert—check it out!</div>
                </div>
            </div>
        </div>
        <div class="d-flex align-items-center">
            <div>
                <h5 class="card-title text-center"><i class="fa-solid fa-cash-register"></i> Cash Register History Record</h5>
            </div>

            <div class="dropdown ms-auto">
                <a class="dropdown-toggle dropdown-toggle-nocaret" href="#" data-bs-toggle="dropdown"><i class='bx bx-dots-horizontal-rounded font-22 text-option'></i>
                </a>
                <ul class="dropdown-menu">
                    <li><a class="dropdown-item" href="#" data-bs-toggle="modal" data-bs-target="#modalRegister"><i class="fas fa-cash-register text-success" style="color: rgb(255, 0, 0)"></i> Open Cash Register</a>
                    </li>
                </ul>
            </div>
        </div>
        <hr>
        <nav>
            <div class="nav nav-tabs" id="nav-tab" role="tablist">
                <button class="nav-link active" id="nav-opening-tab" data-bs-toggle="tab" data-bs-target="#nav-opening" type="button" role="tab" aria-controls="nav-opening" aria-selected="true">Opening and Closing</button>
                <button class="nav-link" id="nav-newExpense-tab" data-bs-toggle="tab" data-bs-target="#nav-newExpense" type="button" role="tab" aria-controls="nav-newExpense" aria-selected="false">New Expense</button>
                <button class="nav-link" id="nav-expenseHistory-tab" data-bs-toggle="tab" data-bs-target="#nav-expenseHistory" type="button" role="tab" aria-controls="nav-expenseHistory" aria-selected="false">Expense History</button>
                <button class="nav-link" id="nav-cashMovements-tab" data-bs-toggle="tab" data-bs-target="#nav-cashMovements" type="button" role="tab" aria-controls="nav-cashMovements" aria-selected="false">Cash Movements</button>
            </div>
        </nav>
        <div class="tab-content" id="nav-tabContent">
            <div class="tab-pane fade show active mt-3" id="nav-opening" role="tabpanel" aria-labelledby="nav-opening-tab" tabindex="0">
                <div class="table-responsive">
                    <table class="table table-bordered table-striped table-hover align-middle nowrap" id="tblOpenClose" style="width: 100%;">
                        <thead>
                            <tr>
                                <th>Initial Amount</th>
                                <th>Opening Date</th>
                                <th>Closing Date</th>
                                <th>Final Amount</th>
                                <th>Total Sale</th>
                                <th>User</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td></td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>

            <div class="tab-pane fade p-3" id="nav-newExpense" role="tabpanel" aria-labelledby="nav-newExpense-tab" tabindex="0">

                <form id="expenseForm">
                <input type='hidden' id='actualPhoto' name='actualPhoto'>
                    <div class="row">
                        <div class="col-md-4">
                            <label for="description">Expense Amount <span class="text-danger">*</span></label>
                            <div class="input-group">
                                <span class="input-group-text"><i class="fas fa-dollar-sign"></i></span>
                                <input class="form-control" type="number" id="expenseAmount" name="expenseAmount" placeholder="Expense Amount">
                            </div>
                        </div>
                        <div class="col-md-8">
                            <label for="description">Description</label>
                            <div class="form-group">
                                <textarea id="description" class="form-control" name="description" rows="3" placeholder="Description"></textarea>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <label for="expensePhoto">Photo (Optional)</label>
                            <div class="form-group">
                                <input id="expensePhoto" class="form-control" type="file" name="expensePhoto">
                            </div>
                            <br>
                            <div id="containerPreview">
                            </div>
                        </div>
                    </div>
                    <div class="float-end">
                        <button class="btn btn-primary" type="submit" id="btnRegisterExpense">Register</button>
                    </div>
                </form>
            </div>

            <div class="tab-pane fade p-3" id="nav-expenseHistory" role="tabpanel" aria-labelledby="nav-expenseHistory-tab" tabindex="0">
                <div class="table-responsive">
                    <table class="table table-bordered table-striped table-hover align-middle nowrap" id="tblExpenseHistory" style="width: 100%;">
                        <thead>
                            <tr>
                                <th>Amount</th>
                                <th>Description</th>
                                <th>Photo</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td></td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>

            <div class="tab-pane fade p-3" id="nav-cashMovements" role="tabpanel" aria-labelledby="nav-cashMovements-tab" tabindex="0">

            </div>
        </div>
    </div>
</div>

<div id="modalRegister" class="modal fade" data-bs-backdrop="static" data-bs-keyboard="false" role="dialog" aria-labelledby="my-modal-title" aria-hidden="true">
    <div class="modal-dialog modal-sm" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Open Cash Register</h5>
            </div>
            <div class="modal-body">
                <label>Initial Amount</label>
                <div class="input-group mb-3">
                    <span class="input-group-text"><i class="fas fa-dollar-sign"></i></span>
                    <input class="form-control" type="text" id="initialAmount" placeholder="Initial Amount">
                </div>
                <div class="row justify-content-between">
                    <div class="col-md-8">
                        <button class="btn btn-primary" id="btnOpenRegister" type="button">Open Register</button>
                    </div>
                    <div class="col-md-4">
                        <button class="btn btn-danger" id="btnCancel" type="button">Cancel</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>



<?php include_once 'views/templates/footer.php'; ?>