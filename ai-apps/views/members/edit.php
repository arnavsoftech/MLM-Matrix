<h4>Edit Profile : <?= $m->username; ?></h4>
<hr />
<div class="row">
    <div class="col-sm-8">
        <div class="box">
            <div class="box-p">
                <p><em>Edit the details carefully !!</em></p>
                <div class="row">
                    <div class="col-sm-12">
                        <?php echo form_open(admin_url('members/edit/' . $m->id), array('class' => 'form-horizontal')); ?>
                        <div class="form-group row">
                            <label class="col-sm-2">First name</label>
                            <div class="col-sm-4">
                                <input type="text" name="frm[first_name]" value="<?php echo $m->first_name; ?>" class="form-control input-sm" />
                            </div>
                            <label class="col-sm-2">Last name</label>
                            <div class="col-sm-4">
                                <input type="text" name="frm[last_name]" value="<?php echo $m->last_name; ?>" class="form-control input-sm" />
                            </div>
                        </div>

                        <div class="form-group row">
                            <label class="col-sm-2">Mobile no</label>
                            <div class="col-sm-4">
                                <input type="text" name="frm[mobile]" value="<?php echo $m->mobile; ?>" class="form-control input-sm">
                            </div>
                            <label class="col-sm-2">Password</label>
                            <div class="col-sm-4">
                                <input type="text" name="frm[passwd]" value="<?php echo $m->passwd; ?>" class="form-control input-sm">
                            </div>
                        </div>

                        <div class="form-group row">
                            <label class="col-sm-2">State</label>
                            <div class="col-sm-4">
                                <select name="frm[state]" class="form-control">
                                    <?php
                                    $pack = $this->db->get_where('ai_states')->result();
                                    if (is_array($pack) and count($pack) > 0) {
                                        foreach ($pack as $k) {
                                            ?>
                                            <option value="<?= $k->id; ?>" <?= $m->state == $k->id ? 'selected' : '' ?>><?= $k->state_name; ?></option>
                                    <?php
                                        }
                                    }
                                    ?>
                                </select>
                                </select>
                            </div>
                            <label class="col-sm-2">Login Status</label>
                            <div class="col-sm-3">
                                <label class="radio radio-inline"><input type="radio" name="frm[status]" value="1" <?php if ($m->status == 1) echo 'checked'; ?> /> Active</label>
                                <label class="radio radio-inline"><input type="radio" name="frm[status]" value="0" <?php if ($m->status == 0) echo 'checked'; ?> /> Deactive</label>

                            </div>

                        </div>
                        <div class="form-group row">
                            <label class="col-sm-2">Franchise</label>
                            <div class="col-sm-4">
                                <select name="frm[franchise]" class="form-control">
                                    <option value="1" <?= ($m->franchise == 1) ? 'selected' : ''; ?>>Yes</option>
                                    <option value="0" <?= ($m->franchise == 0) ? 'selected' : ''; ?>>No</option>
                                </select>
                            </div>
                            <label class="col-sm-2">KYC Updated</label>
                            <div class="col-sm-3">
                                <label class="radio radio-inline"><input type="radio" name="frm[kyc_status]" value="1" <?php if ($m->kyc_status == 1) echo 'checked'; ?> /> Yes</label>
                                <label class="radio radio-inline"><input type="radio" name="frm[kyc_status]" value="0" <?php if ($m->kyc_status == 0) echo 'checked'; ?> /> No</label>

                            </div>
                        </div>
                        
                            
                        <div class="form-group row">
                            <label class="col-sm-2">&nbsp;</label>
                            <div class="col-sm-9">
                                <input type="submit" name="submit" value="Save Details" class="btn btn-primary" />
                                <a href="<?= admin_url('members'); ?>" class="btn btn-dark">Cancel</a>
                            </div>
                        </div>
                        <?php echo form_close(); ?>

                    </div>

                </div>

            </div>

        </div>
    </div>
</div>