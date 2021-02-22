<style>
    #cust1 {
        display: none;
    }
</style>
<h4>Product Form</h4>
<hr>

<?php echo form_open_multipart(admin_url('products/add/' . $p->id), array('class' => 'form-horizontal')); ?>
<div class="row">
    <div class="col-sm-9">
        <div class="box box-p">
            <div class="tab-content">
                <div role="tabpanel" class="tab-pane active" id="home">
                    <div class="form-group row mt-2"><label class="col-sm-2 control-label">Product Title</label>

                        <div class="col-sm-10"><input type="text" name="frm[ptitle]" value="<?= set_value('frm[ptitle]', $p->ptitle); ?>" class="form-control input-sm" /></div>
                    </div>
                    <div class="form-group row mt-2"><label class="col-sm-2 control-label">Slug</label>

                        <div class="col-sm-6"><input type="text" name="frm[slug]" value="<?= set_value('frm[slug]', $p->slug); ?>" class="form-control input-sm" /></div>
                    </div>


                    <div class="form-group row mt-2"><label class="col-sm-2 control-label">Description</label>

                        <div class="col-sm-10"><textarea rows="8" cols="" class="form-control input-sm redactor" name="frm[description]"><?= set_value('frm[description]', $p->description); ?></textarea>
                        </div>
                    </div>
                    <div class="form-group row mt-2">

                        <label class="col-sm-2 control-label">MRP</label>

                        <div class="col-sm-2">
                            <input type="text" name="frm[price]" value="<?= set_value('frm[price]', $p->price); ?>" class="form-control input-sm" />
                        </div>
                        <label class="col-sm-2 control-label">Disc. Price</label>

                        <div class="col-sm-2"><input type="text" name="frm[dp]" value="<?= set_value('frm[dp]', $p->dp); ?>" class="form-control input-sm" /></div>

                    </div>

                    <div class="form-group row mt-2">


                        <label class="col-sm-2 control-label">BVP</label>

                        <div class="col-sm-2">
                            <input type="text" name="frm[bvp]" value="<?= set_value('frm[bvp]', $p->bvp); ?>" class="form-control input-sm" />
                        </div>
                        <label class="col-sm-2 control-label">Available</label>

                        <div class="col-sm-2"><label class="checkbox-inline"> <input type="checkbox" name="frm[available]" value="1" <?php if ($p->available == 1) echo 'checked'; ?> />
                                Yes </label></div>
                    </div>
                    <div class="form-group row mt-2">
                        <?php
                        $arr = array();
                        for ($i = 5; $i <= 30; $i++) {
                            $arr[] = $i;
                        }
                        ?>
                        <label class="col-sm-2 control-label">CGST%</label>

                        <div class="col-sm-2">
                            <?php echo form_dropdown('frm[cgst]', $arr, $p->cgst, array('class' => "form-control input-sm")); ?>

                        </div>
                        <label class="col-sm-2 control-label">SGST%</label>

                        <div class="col-sm-2">
                            <?php echo form_dropdown('frm[sgst]', $arr, $p->sgst, array('class' => "form-control input-sm")); ?>
                        </div>

                    </div>
                    <div class="col-sm-12 row">
                        <label class="col-sm-2 control-label">Cover Image</label>
                        <div class="col-sm-3">
                            <input type="file" name="cover_image" id="file_name">
                            <?php
                            if ($p->image != '') {
                            ?>
                                <img src="<?= base_url(upload_dir($p->image)); ?>" class="img-fluid">
                            <?php
                            }
                            ?>
                        </div>

                    </div>

                </div>


                <div class="form-group row mt-2"><label class="col-sm-2 control-label">Status</label>

                    <div class="col-sm-3"> <?php $st = array(1 => 'Active', 0 => 'Deactive');
                                            echo form_dropdown('frm[status]', $st, $p->status, 'class="form-control input-sm"'); ?> </div>
                </div>
            </div>
            <div class="form-group row">
                <label class="col-sm-2 control-label">&nbsp;</label>
                <div class="col-sm-10">
                    <input type="submit" name="submit" value="Save Details" class="btn btn-sm btn-primary" />
                    <a href="<?php echo admin_url('products'); ?>" class="btn btn-sm btn-danger">Cancel</a>
                </div>
            </div>
        </div>
    </div>
    <div class="col-sm-3">
        <div class="box">
            <div class="pcate">
                <div class="box-header">
                    <b>Categories</b>
                </div>
                <div class="box-p" style="max-height: 400px; overflow: auto;">
                    <?php
                    echo form_dropdown('frm[category]', $category, $p->category, 'class="form-control input-sm"');
                    ?>
                </div>
            </div>
        </div>
        <div class="box">
            <div class="box-header">
                <b>Options</b>
            </div>
            <div class="box-p">
                <div class="form-group row mt-2">
                    <label class="col-sm-6 ">Featured</label>
                    <div class="col-sm-6"> <?php $ft = array(0 => 'No', 1 => 'Yes');
                                            echo form_dropdown('frm[featured]', $ft, $p->featured, 'class="form-control input-sm" style="color:#000"'); ?> </div>
                </div>

            </div>
        </div>
    </div>
</div>
<?php echo form_close(); ?>