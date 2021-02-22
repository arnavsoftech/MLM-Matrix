<div class="page-header">
    <h4>Change Password</h4>
</div>

<div class="row" id="add-template">
    <div class="col-sm-7 m-auto">
        <form action="<?= admin_url("dashboard/changepass"); ?>" class="form-horizontal well" method="post">
            <div class="box box-p">
                <p><i>Fill the details to change password.</i></p>
                <div class="form-group row">
                    <label class="col-sm-3 control-label">Old Password</label>
                    <div class="col-sm-8">
                        <input type="password" class="form-control" name="old_pass" placeholder="Old Password" />
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-sm-3 control-label">New Password</label>
                    <div class="col-sm-8">
                        <input type="password" class="form-control" name="new_pass" placeholder="New Password" />
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-sm-3 control-label">Retype Password</label>
                    <div class="col-sm-8">
                        <input type="password" class="form-control" name="cnf_pass" placeholder="Confirm Password" />
                    </div>
                </div>

                <div class="form-group row">
                    <div class="col-sm-8 offset-sm-3">
                        <button type="submit" value="submit" name="submit" class="btn btn-primary">
                            <i class="fa fa-save"></i> Save
                        </button>
                        <a  href="<?= admin_url(); ?>" class="btn btn-dark"><i class="fa fa-close"></i> Cancel</a>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>










