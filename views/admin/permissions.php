<?php include_once 'views/templates/header.php'; ?>

<div class="error-404 d-flex align-items-center justify-content-center">
    <div class="container">
        <div class="card py-5">
            <div class="row g-0">
                <div class="col col-xl-5">
                    <div class="card-body p-4">
                        <h1 class="display-1"><span class="text-primary">4</span><span class="text-danger">0</span><span class="text-success">3</span></h1>
                        <h2 class="font-weight-bold display-4">Access Denied</h2>
                        <p>You don't have acces or enough privilages
                            <br>to access this page, contact your supervisors.
                            <br>Dont'worry and return to the previous page.
                        </p>
                        <div class="mt-5">
                            <a href="<?php echo BASE_URL . 'admin' ?>" class="btn btn-primary btn-lg px-md-5 radius-30">Back</a>
                        </div>
                    </div>
                </div>
                <div class="col-xl-7 text-center">
                <img src="<?php echo BASE_URL; ?>assets/images/login-images/403forbiddenerror.jpg" class="img-fluid" alt="" width="696">
                    <!-- <img src="https://cdn.searchenginejournal.com/wp-content/uploads/2019/03/shutterstock_1338315902.png" class="img-fluid" alt=""> -->
                </div>
            </div>
            <!--end row-->
        </div>
    </div>
</div>

<?php include_once 'views/templates/footer.php'; ?>