<div class="page-header">
    <h5>Support Reply</h5>
</div>
<?php echo form_open_multipart(admin_url('supports/reply/' . $m->id), array('class' => 'form-horizontal ajax-form')); ?>
<div class="row">
    <div class="col-sm-12">
        <div class="tab-pane active" id="description_tab">
            <div class="form-group row">
                <label class="col-sm-2 control-label">Subject</label>
                <div class="col-sm-8">
                    <input type="text" name="form[subject]" value="<?= set_value('form[subject]', $m->subject); ?>" class="form-control" />
                </div>
            </div>
            <div class="form-group row">
                <label class="col-sm-2 control-label">Description</label>
                <div class="col-sm-8">
                    <textarea name="form[description]" rows="4" cols="" class="form-control ckeditor"><?= set_value('form[description]', $m->description); ?></textarea>
                </div>
            </div>            
            <div class="form-group row">
                <label class="col-sm-2 control-label">&nbsp;</label>
                <div class="col-sm-8">
                    <button type="submit" class="btn btn-primary"><i class="fa fa-save"></i> Save</button> 
                    <a href="<?php echo admin_url('courses/video_manager'); ?>" class="btn btn-secondary"><i class="fa fa-close"></i> Cancel</a>
                </div>
            </div>
        </div>
    </div>
</div>
<?= form_close(); ?>
<script>
    $(document).ready(function(){
        
    });
</script>


