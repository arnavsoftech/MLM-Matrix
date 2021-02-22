<div class="box">

    <div class="box-header">

        <h4 class="h5 box-title">Package Details:</h4>

    </div>

    <div class="box-p">

        <div class="row">

            <div class="col-sm-12">

                <?php echo form_open(admin_url('package/add/' . $m->id), array('class' => 'form-horizontal')); ?>

                <div class="form-group row">
                <label class="col-sm-2">Package Type</label>
                    <div class="col-sm-4">
                        <?php echo form_dropdown('frm[pack_type]',$this->Package_model->package_type(),$m->pack_type,'class="form-control"'); ?>
                    </div>
                    <label class="col-sm-2">Package name</label>
                    <div class="col-sm-4">
                        <input type="text" name="frm[package]" value="<?php echo $m->package; ?>" class="form-control input-sm" />
                    </div>
                    
                </div>



                <div class="form-group row">

                    <label class="col-sm-2">Point</label>
                    <div class="col-sm-4">
                         <input type="text" name="frm[point]" value="<?php echo $m->point; ?>" class="form-control input-sm">
                    </div>
                   <label class="col-sm-2">Capping Amount</label>
                    <div class="col-sm-4">
                        <input type="text" name="frm[cap]" value="<?php echo $m->cap; ?>" class="form-control input-sm">
                    </div>
                </div>

                <div class="form-group row">

                    <label class="col-sm-2">Package Price</label>
                    <div class="col-sm-4">
                         <input type="text" name="frm[mrp]" value="<?php echo $m->mrp; ?>" class="form-control input-sm">
                    </div>
                     <label class="col-sm-2">Package Details</label>
                    <div class="col-sm-4">
                          <?php echo form_dropdown('frm[pack_info]',$this->Package_model->package_detail(),$m->pack_info,'class="form-control"'); ?>
                    </div>
                </div>

                <div class="form-group row">

                   
                    <label class="col-sm-2">Status</label>
                    <div class="col-sm-4">
                          <label class="radio radio-inline"><input type="radio" name="frm[status]" value="1" <?php if ($m->status == 1) echo 'checked'; ?> /> Active</label>
                        <label class="radio radio-inline"><input type="radio" name="frm[status]" value="0" <?php if ($m->status == 0) echo 'checked'; ?> /> Deactive</label>
                        
                    </div>
                </div>

                

               

                <div class="form-group row">

                    <label class="col-sm-2">&nbsp;</label>

                    <div class="col-sm-4">

                        <input type="submit" name="submit" value="Save Details" class="btn btn-primary" />

                        <a href="<?= admin_url('package'); ?>" class="btn btn-dark">Cancel</a>

                    </div>

                </div>

                <?php echo form_close(); ?>

            </div>

        </div>

    </div>

</div>