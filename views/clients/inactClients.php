<?php include_once 'views/templates/header.php'; ?>

<div class="card">
    <div class="card-body">
        <div class="d-flex align-items-center">
            <div></div>
            <div class="dropdown ms-auto">
                <a class="dropdown-toggle dropdown-toggle-nocaret" href="#" data-bs-toggle="dropdown"><i class='bx bx-dots-horizontal-rounded font-22 text-option'></i>
                </a>
                <ul class="dropdown-menu">
                    <li><a class="dropdown-item" href="<?php echo BASE_URL . 'clients'; ?>"><i class="fas fa-users text-primary" style="color: rgb(255, 0, 0)"></i> Client</a>
                    </li>
                </ul>
            </div>
        </div>
        <h5 class="card-title text-center">Inactive Clients</h5>
        <hr>
        <div class="table-responsive">
            <table class="table table-bordered table-striped table-hover align-middle nowrap" id="tblInactiveClient" style="width: 100%;">
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
</div>



<?php include_once 'views/templates/footer.php'; ?>