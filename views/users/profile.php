<?php include_once 'views/templates/header.php'; ?>

<div class="container">
    <div class="main-body">
        <div class="row">
            <div class="col-lg-4">
                <div class="card">
                    <div class="card-body">
                        <div class="d-flex flex-column align-items-center text-center">
                            <?php if ($data['users']['profile'] == null || !file_exists($data['users']['profile'])) {
                                $profile = BASE_URL . 'assets/images/profile/guestUser.png';
                            } else {
                                $profile = BASE_URL . $data['users']['profile'];
                            }?>
                            <img src="<?php echo $profile; ?>" alt="photo" class="rounded-circle p-1 bg-primary" width="110">
                            <div class="mt-3">
                                <h4><i class="fa-regular fa-circle-user"></i> <?php echo $data['users']['first_name'] . ' ' . $data['users']['last_name'] ?></h4>
                                <h6><i class="fa-regular fa-envelope"></i> <?php echo $data['users']['email'] ?></h6>
                                <p class="text-secondary mb-1"><i class="fas fa-phone"></i> <?php echo $data['users']['phone_number'] ?></p>
                                <p class="text-muted font-size-sm"><i class="fas fa-house-user"></i> <?php echo $data['users']['address'] ?></p>
                                <hr>
                                <h6 class="text-center">Register Date</h6>
                                <p class="text-muted font-size-sm"><?php echo $data['users']['dates'] ?></p>
                                <hr>
                                <h6 class="text-center">ROL</h6>
                                <p class="text-muted font-size-sm"><?php echo ($data['users']['rol'] == 1) ? 'Administrator' : 'Sales Person'; ?></p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-8">
                <div class="card">
                    <div class="card-body">
                        <!-- Full Name -->
                        <div class="row mb-3">
                            <label class="text-center"><strong>Full Name</strong></label>
                            <div class="col-sm-12 text-secondary">
                                <input type="text" class="form-control" value="<?php echo $data['users']['first_name'] . ' ' . $data['users']['last_name'] ?>" disabled />
                            </div>
                        </div>
                        <form id="profileForm" autocomplete="off">
                            <input type='hidden' id='actualPhoto' name='actualPhoto'>
                            <!-- First Name -->
                            <div class="row mb-3">
                                <label class="text-center"><strong>First Name</strong></label>
                                <div class="col-sm-12 text-secondary">
                                    <input type="text" class="form-control" id="fNameProfile" name="fNameProfile" value="<?php echo $data['users']['first_name'] ?>" />
                                </div>
                            </div>
                            <!-- Last Name -->
                            <div class="row mb-3">
                                <label class="text-center"><strong>Last Name</strong></label>
                                <div class="col-sm-12 text-secondary">
                                    <input type="text" class="form-control" id="lNameProfile" name="lNameProfile" value="<?php echo $data['users']['last_name'] ?>" />
                                </div>
                            </div>
                            <!-- Email -->
                            <div class="row mb-3">
                                <label class="text-center"><strong>Email</strong></label>
                                <div class="col-sm-12 text-secondary">
                                    <input type="text" class="form-control" id="emailProfile" name="emailProfile" value="<?php echo $data['users']['email'] ?>" />
                                </div>
                            </div>
                            <!-- Phone -->
                            <div class="row mb-3">
                                <label class="text-center"><strong>Phone</strong></label>
                                <div class="col-sm-12 text-secondary">
                                    <input type="text" class="form-control" id="phoneProfile" name="phoneProfile" value="<?php echo $data['users']['phone_number'] ?>" />
                                </div>
                            </div>
                            <!-- Address -->
                            <div class="row mb-3">
                                <label class="text-center"><strong>Address</strong></label>
                                <div class="col-sm-12 text-secondary">
                                    <input type="text" class="form-control" id="addressProfile" name="addressProfile" value="<?php echo $data['users']['address'] ?>" />
                                </div>
                            </div>
                            <!-- Password -->
                            <div class="row mb-3">
                                <div class="col-sm-6">
                                    <label class="text-center">Current Password</label>
                                    <div class="input-group">
                                        <span class="input-group-text"><i class="fas fa-lock"></i></span>
                                        <input type="password" class="form-control" id="oldPassProfile" name="oldPassProfile" placeholder="Old Password" />
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <label class="text-center">New Password</label>
                                    <div class="input-group">
                                        <span class="input-group-text"><i class="fa-solid fa-user-lock"></i></span>
                                        <input type="password" class="form-control" id="newPassProfile" name="newPassProfile" placeholder="New Password" />
                                    </div>
                                </div>
                            </div>
                            <!-- Profile -->
                            <div class="row mb-3">
                                <label>Photo Profile (Optional)</label>
                                <div class="col-sm-12 text-secondary">
                                    <input type="file" class="form-control" id="profilePhoto" name="profilePhoto" />
                                </div>
                                <br><br>
                                <div id="containerPreview">
                                </div>
                            </div>
                            <!-- btnSaveProfile -->
                            <div class="row">
                                <div class="col-sm-3">
                                    <div class="col-sm-6 text-secondary">
                                        <input type="submit" class="btn btn-primary px-4" id="btnSaveProfile" name="btnSaveProfile" value="Save Changes" />
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
</div>

<?php include_once 'views/templates/footer.php'; ?>