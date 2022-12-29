<?php include_once 'views/templates/header.php'; ?>

<div class="card">
    <div class="card-body">
        <h5 class="card-title text-center">Company Data</h5>
        <hr>
        <form class="p-4" id="companyForm" autocomplete="off">
            <input type="hidden" id="idCompany" name="idCompany" class="form-control" value="<?php echo $data['company']['id']; ?>">
            <div class="row">
                <div class="col-lg-4 col-sm-6 mb-2">
                    <label>Identification <span class="text-danger">*</span></label>
                    <div class="input-group">
                        <span class="input-group-text"><i class="fas fa-id-card"></i></span>
                        <input type="text" id="taxID" name="taxID" class="form-control" value="<?php echo $data['company']['taxID']; ?>" placeholder="Identification ID">
                    </div>
                    <span id="errortaxID" class="text-danger"></span>
                </div>
                <div class="col-lg-4 col-sm-6 mb-2">
                    <label>Name <span class="text-danger">*</span></label>
                    <div class="input-group">
                        <span class="input-group-text"><i class="fas fa-list"></i></span>
                        <input type="text" id="configName" name="configName" class="form-control" value="<?php echo $data['company']['name']; ?>" placeholder="Name">
                    </div>
                    <span id="errorConfigName" class="text-danger"></span>
                </div>
                <div class="col-lg-4 col-sm-6 mb-2">
                    <label>Phone Number <span class="text-danger">*</span></label>
                    <div class="input-group">
                        <span class="input-group-text"><i class="fas fa-phone"></i></span>
                        <input type="number" id="configPhone" name="configPhone" class="form-control" value="<?php echo $data['company']['phone_number']; ?>" placeholder="Phone Number">
                    </div>
                    <span id="errorConfigPhone" class="text-danger"></span>
                </div>
                <div class="col-lg-4 col-sm-6 mb-2">
                    <label>Email <span class="text-danger">*</span></label>
                    <div class="input-group">
                        <span class="input-group-text"><i class="fas fa-envelope"></i></span>
                        <input type="email" id="configEmail" name="configEmail" class="form-control" value="<?php echo $data['company']['email']; ?>" placeholder="Email">
                    </div>
                    <span id="errorConfigEmail" class="text-danger"></span>
                </div>
                <div class="col-lg-8 col-sm-6 mb-2">
                    <label>Address <span class="text-danger">*</span></label>
                    <div class="input-group">
                        <span class="input-group-text"><i class="fas fa-home"></i></span>
                        <input type="text" id="configAddress" name="configAddress" class="form-control" value="<?php echo $data['company']['address']; ?>" placeholder="Address">
                    </div>
                    <span id="errorConfigAddress" class="text-danger"></span>
                </div>
                <div class="col-lg-3 col-sm-6 mb-2">
                    <label>Tax (Optional)</label>
                    <div class="input-group">
                        <span class="input-group-text"><i class="fa-solid fa-percent"></i></span>
                        <input type="number" id="configTax" name="configTax" class="form-control" value="<?php echo $data['company']['tax']; ?>" placeholder="Tax">
                    </div>
                </div>
                <!-- Editor made with ckeditor from https://ckeditor.com/-->
                <div class="col-lg-9 col-sm-6 mb-2">
                    <div class="form-group">
                        <label for="configMessage">Message (Optional)</label>
                        <textarea id="configMessage" class="form-control" name="configMessage" rows="3" placeholder="Desired message"><?php echo $data['company']['message']; ?></textarea>
                    </div>
                </div>
                <div class="col-md-6 mb-3">
                    <div class="form-group">
                        <label for="logoCompany">Logo (only PNG 319X53)</label>
                        <input id="logoCompany" class="form-control" type="file" name="logoCompany">
                    </div>
                    <br>
                    <div id="containerPreview">
                        <img class="img-thumbnail" src="<?php echo BASE_URL . 'assets/images/logo-img.png' ?>" alt="">
                    </div>
                </div>
            </div>
            <div class="text-end">
                <button class="btn btn-primary" type="submit" id="btnUpdate">Update</button>
            </div>
        </form>
    </div>
</div>

<?php include_once 'views/templates/footer.php'; ?>