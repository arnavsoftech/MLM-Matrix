<div class="page-header">

    <h5>Article</h5>

</div>

<?php echo form_open_multipart(admin_url('dashboard/announcement/' . $p->id), array('class' => 'form-horizontal')); ?>

<div class="row">

    <div class="col-sm-12">

        <div class="form-group row">

            <label class="col-sm-2 control-label"> Title</label>



            <div class="col-sm-8">

                <input type="text" name="form[title]" value="<?php echo set_value('form[title]', $p->title); ?>" class="form-control input-sm" placeholder="Title">

            </div>

        </div>

        <div class="form-group row">

            <label class="col-sm-2 control-label">Description</label>



            <div class="col-sm-10">

                <textarea class="ckeditor" name="form[description]"><?php echo set_value('form[description]', $p->description); ?></textarea>

            </div>

        </div>

        <div class="form-group row">

            <label class="col-sm-2 control-label">Featured Image</label>

            <div class="col-sm-8">

                <input type="file" name="image">

                <?php if ($p->image != '') { ?>

                    <div style="text-align:center; padding:5px; border:1px solid #ddd;"><img src="<?php echo base_url(upload_dir($p->image)); ?>" alt="current" class="img-fluid" /><br />Current File<br />

                    </div>

                    <label class="checkbox-inline">

                        <input type="hidden" name="hid_img" value="<?php echo $p->image; ?>" />

                        <input type="checkbox" name="del_img" value="1" />Delete this image

                    </label>

                <?php } ?>

            </div>

        </div>







    </div>

</div>





<div class="form-group row">

    <div class="col-sm-10 offset-sm-2">

        <button type="submit" name="submit" value="Submit" class="btn btn-primary btn-sm"><i class="fa fa-save"></i> Save

        </button>

        <a href="<?php echo admin_url('dashboard/announce'); ?>" class="btn btn-secondary btn-sm"><i class="fa fa-remove"></i> Cancel</a>

    </div>

</div>

</form>