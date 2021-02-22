<div class="d-flex justify-content-between align-items-center">
    <h5>Edit Profile</h5>
    <a href="<?= site_url('dashboard/kyc') ?>" class="btn btn-sm btn-primary">Upload Documents</a>
</div>
<hr>
<div class="box">
    <div class="box-p">
        <form id="fr-register" enctype="multipart/form-data" class="form-horizontal" onsubmit="return validate()" method="POST" action="<?= site_url('dashboard/edit-profile/'); ?>">
            <input type="hidden" name="edit">
            <h5>Personal Details</h5>
            <hr>
            <div class="form-group row">
                <label class="col-sm-2 control-label">Name <span class="required">*</span></label>
                <div class="col-sm-3">
                    <input required class="form-control" <?= $profile->first_name ? 'readonly' : ''; ?> type="text" placeholder="" name="form[first_name]" value="<?= set_value('form[first_name]', $profile->first_name); ?>">
                </div>
                <label class="col-sm-2 control-label">Marital Status<span class="required">*</span></label>

                <div class="col-sm-3">
                    <select required class="form-control" name="form[martial_status]">
                        <option <?php if ($profile->martial_status == '1') {
                                    echo "selected";
                                }
                                ?> value="1">Married</option>
                        <option <?php if ($profile->martial_status == '2') {
                                    echo "selected";
                                }
                                ?> value="2">Unmarried</option>
                    </select>
                </div>
            </div>



            <div class="form-group row">
                <label class="col-sm-2 control-label">Gender </label>
                <div class="col-sm-3">
                    <select class="form-control" name="form[gender]">
                        <option <?php if ($profile->gender == '1') {
                                    echo "selected";
                                }
                                ?> value="1">Male</option>
                        <option <?php if ($profile->gender == '2') {
                                    echo "selected";
                                }
                                ?> value="2">Female</option>
                    </select>
                </div>
                <label class="col-sm-2 control-label">Date of Birth</label>
                <div class="col-sm-3">
                    <input class="form-control" type="date" placeholder="DOb" name="form[dob]" value="<?= set_value('form[dob', $profile->dob); ?>">
                </div>
            </div>



            <div class="form-group row">
                <label class="col-sm-2 control-label">Image<span class="required">*</span></label>
                <div class="col-sm-3">
                    <input type="file" name="image">
                    <?php
                    if ($profile->id && $profile->image != '') : ?>
                        <img class="img-responsive img-thumbnail" style="width: 80px;" src="<?php echo base_url(upload_dir($profile->image)); ?>" alt="current" />
                        <br />
                        <label class="checkbox checkbox-inline">
                            <input type="hidden" name="hid_image" value="<?php echo $profile->image; ?>" />
                            <input type="checkbox" name="del_image" value="1" />Delete this image
                        </label>
                    <?php endif; ?>
                </div>
                <label class="col-sm-2 control-label">Mobile <span class="required">*</span></label>
                <div class="col-sm-3">
                    <input readonly required class="form-control" id="intError1" maxlength="10" type="text" placeholder="Mobile" name="form[mobile]" value="<?php echo $profile->mobile; ?>">
                </div>
            </div>
            <h5>Contact Details</h5>
            <hr>
            <div class="form-group row">
                <label class="col-sm-2 control-label">City <span class="required">*</span></label>
                <div class="col-sm-3">
                    <input required class="form-control" type="text" value="<?= set_value('form[city_name]', $profile->city_name); ?>" name="form[city_name]">
                </div>
                <label class="col-sm-2 control-label">State <span class="required">*</span></label>
                <div class="col-sm-3">
                    <?php
                    $arr[''] = "Select state";
                    foreach ($st as $c) {
                        $arr[$c->id] = $c->state_name;
                    }
                    echo form_dropdown('form[state]', $arr, $profile->state, 'class="form-control" required');
                    ?>
                </div>

            </div>
            <div class="form-group row">
                <label class="col-sm-2 control-label">Address <span class="required">*</span></label>
                <div class="col-sm-8">
                    <input required class="form-control" type="text" value="<?= set_value('form[address]', $profile->address); ?>" name="form[address]">
                </div>
            </div>
            <div class="form-group row">
                <label class="col-sm-2 control-label">Pin Code <span class="required">*</span></label>
                <div class="col-sm-3">
                    <input required class="form-control" id="intError3" maxlength="6" type="text" placeholder="Pincode" name="form[pin_code]" value="<?= set_value('form[pin_code]', $profile->pin_code); ?>">
                </div>

                <label class="col-sm-2 control-label">Email Id </label>
                <div class="col-sm-3">
                    <input class="form-control" type="email" placeholder="" name="form[email_id]" value="<?php echo $profile->email_id; ?>">
                </div>
            </div>
            <h5>Nominee Details</h5>
            <hr>
            <div class="form-group row">
                <label class="col-sm-2 control-label">Nominee name <span class="required">*</span></label>
                <div class="col-sm-3">
                    <input required class="form-control" type="text" placeholder="Nominee name" name="form[nominee]" value="<?= set_value('form[nominee]', $profile->nominee); ?>">
                </div>

                <label class="col-sm-2 control-label">Relation <span class="required">*</span></label>
                <div class="col-sm-3">
                    <input required class="form-control" type="text" placeholder="Relation" name="form[relation]" value="<?= set_value('form[relation]', $profile->relation); ?>">
                </div>
            </div>
            <h5>Bank Details</h5>
            <hr>
            <?php
            $bank            = new stdClass();
            $bank->bank_name = '';
            $bank->branch    = '';
            $bank->ifsc      = '';
            $bank->ac_number = '';
            $bank->ac_name   = '';
            $cls             = '';

            if ($profile->bank_info != '' and !is_null($profile->bank_info)) {
                $bank = json_decode($profile->bank_info);
            }
           
            ?>
            <div class="form-group row">
                <label class="col-sm-2 control-label">Bank Name <span class="required">*</span></label>
                <div class="col-sm-3">
                    <input required class="form-control" <?= $bank->bank_name==''?'':'disabled';?> type="text" value="<?= set_value('bank[bank_name]', $bank->bank_name); ?>" name="bank[bank_name]">
                </div>
                <label class="col-sm-2 control-label">A/c Holder <span class="required">*</span></label>
                <div class="col-sm-3">
                    <input required class="form-control" <?= $bank->ac_name==''?'':'disabled';?> type="text" value="<?= set_value('bank[ac_name]', $bank->ac_name); ?>" name="bank[ac_name]">
                </div>
            </div>
            <div class="form-group row">
                <label class="col-sm-2 control-label">A/c Number <span class="required">*</span></label>
                <div class="col-sm-3">
                    <input required class="form-control" <?= $bank->ac_number==''?'':'disabled';?> type="text" value="<?= set_value('bank[ac_number]', $bank->ac_number); ?>" name="bank[ac_number]">
                    <small class="text-muted">Please enter the account number carfully</small>
                </div>
                <label class="col-sm-2 control-label">Bank Branch <span class="required">*</span></label>
                <div class="col-sm-3">
                    <input required class="form-control" <?= $bank->branch==''?'':'disabled';?> type="text" value="<?= set_value('bank[branch]', $bank->branch); ?>" name="bank[branch]">
                </div>
            </div>
            <div class="form-group row">
                <label class="col-sm-2 control-label">IFSC Code <span class="required">*</span></label>
                <div class="col-sm-3">
                    <input required class="form-control" <?= $bank->ifsc==''?'':'disabled';?> type="text" value="<?= set_value('bank[ifsc]', $bank->ifsc); ?>" name="bank[ifsc]">
                </div>
                <label class="col-sm-2 control-label">PAN Number <span class="required">*</span></label>
                <div class="col-sm-3">
                    <input required class="form-control" <?= $profile->pan_no==''?'':'disabled';?> type="text" value="<?= set_value('form[pan_no]', $profile->pan_no); ?>" name="form[pan_no]">
                </div>
            </div>

            <div class="form-group row">
                <label class="col-sm-2"></label>
                <div class="col-sm-8">
                    <button class="btn btn-success" type="submit" name="submit" value="submit">
                        <i class="fa fa-send"></i> SAVE
                    </button>
                    <a class="btn btn-dark" href="<?= site_url('dashboard'); ?>">Cancel</a>
                </div>
            </div>
        </form>
    </div>
</div>