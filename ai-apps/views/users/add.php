<div class="page-header">
    <h6>User Form</h6>
</div>
<div class="box">
    <div class="box-p">
        <?php echo form_open_multipart(admin_url('dashboard/add-user/' . $u -> id), array('class' => 'form-horizontal')); ?>
        <div class="form-group row">
            <label class="col-sm-2 control-label">First name</label>
            <div class="col-sm-3">

                <input type="text" name="form[first_name]" value="<?= set_value('form[first_name]', $u -> first_name); ?>"
                       class="form-control input-sm" placeholder="First name" />
            </div>
            <label class="col-sm-1 control-label">Last name</label>
            <div class="col-sm-3">
                <input type="text" name="form[last_name]" value="<?= set_value('form[last_name]', $u -> last_name); ?>"
                       class="form-control input-sm" placeholder="Last name"/>
            </div>
        </div>
        <?php
        $class = "";
        if ($u -> id) {
            $class = "disabled";
        }
        ?>
        <div class="form-group row">
            <label class="col-sm-2 control-label">Email Id</label>
            <div class="col-sm-3">
                <input type="text" name="form[email_id]" value="<?= set_value('form[email_id]', $u -> email_id); ?>"
                       class="form-control input-sm" placeholder="Email Id" />
            </div>
            <label class="col-sm-1 control-label">Password</label>
            <div class="col-sm-3">
                <input type="text" name="passwd" value="<?= set_value('passwd'); ?>"
                       class="form-control input-sm" />
                <small class="help-block text-muted">Leave it blank if you don't want to change password.</small>
            </div>
        </div>

        <div class="form-group row">
            <label class="col-sm-2 control-label">Photo</label>
            <div class="col-sm-6">
                <input type="file" name="image" />
                <?php
                if ($u -> image <> '') {
                    ?><br />
                    <img src="<?= base_url(upload_dir($u -> image)); ?>" class="img-thumbnail img-responsive" style="height: 100px; " /><br />
                    <label class="checkbox checkbox-inline">
                        <input type="checkbox" name="del_img" value="<?= $u -> image; ?>" /> Delete Image</label>
                    <?php
                }
                ?>
            </div>
        </div>

        <div class="form-group row">
            <label class="col-sm-2 control-label">Role</label>

            <div class="col-sm-3">
                <?php
                $st = array(
                    'A' => 'Administrative',
                    'M' => 'Manager',
                    'E' => 'Editor',
                    'S' => 'Subscriber'
                );
                echo form_dropdown('form[role]', $st, set_value('form[role]', $u -> role), 'class="form-control input-sm"');
                ?>
            </div>
            <label class="col-sm-1 control-label">Status</label>

            <div class="col-sm-3">
                <?php
                $st = array(
                    1 => 'Active',
                    0 => 'Draft'
                );
                echo form_dropdown('form[status]', $st, set_value('form[status]', $u -> status), 'class="form-control input-sm"');
                ?>
            </div>
        </div>
        <div class="form-group row">
            <div class="col-sm-8 offset-sm-2">
                <button type="submit" name="submit" value="Save" class="btn  btn-primary"><i class="fa fa-save"></i> Save</button>
                <a href="<?= admin_url('dashboard/users'); ?>" class="btn  btn-secondary"><i class="fa fa-close"></i> Cancel</a>
            </div>
        </div>
        <?php echo form_close(); ?>
    </div>
</div>
