<h5>Change Password</h5>
<hr />

<div class="row">
    <div class="col-md-6">
        <div class="box">
            <div class="box-p">
                <form method="POST" action="<?= site_url('dashboard/change-password') ?>">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group row">
                                <label for="old-password" class="col-sm-3 col-form-label">Old Password:</label>
                                <div class="col-sm-9">
                                    <input type="text" class="form-control" placeholder="Old Password" name="oldpass">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group row">
                                <label for="new-password" class="col-sm-3 col-form-label">New Password:</label>
                                <div class="col-sm-9">
                                    <input type="text" class="form-control" placeholder="New Password" name="new_pass">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group row">
                                <label for="verify-password" class="col-sm-3 col-form-label">Confirm Password
                                    :</label>
                                <div class="col-sm-9">
                                    <input type="text" class="form-control" placeholder="Confirm Password" name="cnfpassword">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <label class="col-sm-3"></label>
                        <div class="col-sm-8">
                            <button type="submit" class="btn btn-primary">Submit</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<!-- change-password end -->