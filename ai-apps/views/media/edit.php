<div class="page-header">
    <h4>Edit Image</h4>
</div>
<div class="row">
    <div class="col-sm-7">
        <div class="box box-p">
            <?php echo form_open(admin_url('media/edit/' . $media -> id), array('class' => 'form-horizontal')); ?>

             <div class="form-group row">

                    <label class="col-sm-2">Type:</label>

                    <div class="col-sm-8">

                        <?php 
                            // echo form_dropdown('frm[type_img]', array(1 => 'Banner', 2 => 'Meeting',3 => 'Our Achievers',4=>'Training Programme'),$media->type_img,set_value('frm[type_img]'), 'class="form-control" required');
                             echo form_dropdown('frm[type_img]', $categories, $media->type_img, 'class="form-control form-category input-sm" required');  
                        ?>

                    </div>

                </div>


            <div class="form-group row">
                <label class="col-sm-2 control-label">Title</label>
                <div class="col-sm-8">
                    <input type="text" name="frm[img_title]" value="<?php echo set_value('frm[img_title]', $media -> img_title); ?>"

                           class="form-control input-sm"/>

                </div>

            </div>

            <div class="form-group row">

                <label class="col-sm-2 control-label">Image Thumbnail</label>
                <div class="col-sm-8">

                    <img src="<?php echo base_url(upload_dir($media -> file_name)); ?>" width="200" class="img-thumbnail img-fluid" style="max-height: 300px;"/>

                </div>

            </div>

            <div class="form-group row">
                <label class="col-sm-2 control-label">Width</label>
                <div class="col-sm-3">
                    <input type="text" name="frm[image_width]" value="<?php echo set_value('frm[image_width]', $media -> image_width); ?>" class="form-control input-sm" />

                </div>
                <label class="col-sm-2 control-label">Height</label>
                <div class="col-sm-3">
                    <input type="text" name="frm[image_height]" value="<?php echo set_value('frm[image_height]', $media -> image_height); ?>" class="form-control input-sm" />

                </div>

            </div>

            <div class="form-group row">

                <div class="col-sm-4 offset-sm-2">
                    <button type="submit" name="submit" value="Submit" class="btn btn-primary"><i class="fa fa-save"></i> Save
                    </button>

                    <a href="<?php echo admin_url('media'); ?>" class="btn btn-secondary"><i class="fa fa-close"></i> Cancel</a>
                </div>
            </div>
            <?php echo form_close(); ?>
        </div>
    </div>
</div>

