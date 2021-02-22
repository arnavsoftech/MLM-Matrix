<div class="page-header">
    <h2>Testimonial Form</h2>
</div>
<?php echo form_open_multipart(admin_url('posts/add-testimonials/' . $p -> id), array('class' => 'form-horizontal')); ?>
<div class="row">
    <div class="col-sm-12">
        <div class="form-group">
            <label class="col-sm-2 control-label">Name</label>

            <div class="col-sm-8">
                <input type="text" name="form[post_title]" value="<?php echo set_value('form[post_title]', $p -> post_title); ?>"
                       class="form-control input-sm" placeholder="Name">
            </div>
        </div>
        <div class="form-group">
            <label class="col-sm-2 control-label">Company name</label>
            <div class="col-sm-3">
                <input type="text" name="form[about]" value="<?php echo set_value('form[about]', $p -> about); ?>"
                       class="form-control input-sm" placeholder="Designation">
            </div>
            <label class="col-sm-2 control-label">Designation</label>
            <div class="col-sm-3">
                <input type="text" name="form[designation]" value="<?php echo set_value('form[designation]', $p -> designation); ?>"
                       class="form-control input-sm" placeholder="Designation">
            </div>
        </div>
        <div class="form-group">
            <label class="col-sm-2 control-label">Testimonial</label>

            <div class="col-sm-8">
                <textarea rows="3" name="form[excerpt]" cols="" class="form-control input-sm malyalam"
                          placeholder="Testmonial text"><?php echo set_value('form[excerpt]', $p -> excerpt); ?></textarea>
            </div>
        </div>
        <div class="form-group">
            <label class="col-sm-2 control-label">Featured Image</label>
            <div class="col-sm-8">
                <input type="file" name="image">
                <?php if($p -> image != ''){ ?>
                    <div style="text-align:center; padding:5px; border:1px solid #ddd;"><img src="<?php echo base_url(upload_dir($p -> image));?>" alt="current" class="img-responsive"/><br/>Current File<br />
                    </div>
                    <label class="checkbox-inline">
                        <input type="hidden" name="hid_img" value="<?php echo $p -> image; ?>" />
                        <input type="checkbox" name="del_img" value="1" />Delete this image
                    </label>
                <?php }?>
            </div>
        </div>
    </div>
</div>


<div class="form-group">
    <div class="col-sm-offset-2 col-sm-10">
        <button type="submit" name="submit" value="Submit" class="btn btn-primary btn-sm"><i class="fa fa-save"></i> Save
        </button>
        <a href="<?php echo admin_url('posts'); ?>" class="btn btn-default btn-sm"><i
                class="fa fa-remove"></i> Cancel</a>
    </div>
</div>
</form>  
