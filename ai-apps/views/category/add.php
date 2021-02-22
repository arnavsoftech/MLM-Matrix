<div class="page-header">
    <h2>Category Form</h2>
</div>
<?php echo form_open_multipart(admin_url('categories/add/' . $cat->id), array('class' => 'form-horizontal')); ?>
<div class="row">
    <div class="col-sm-12">
        <div class="tab-pane active" id="description_tab">
            <div class="form-group row">
                <label class="col-sm-2 control-label">Name</label>
                <div class="col-sm-4">
                    <input type="text" name="cat[name]" value="<?= set_value('cat[name]', $cat->name); ?>" class="form-control" />
                </div>
                <label class="col-sm-1 control-label">Parent </label>
                <div class="col-sm-3">
                    <?php
                    echo form_dropdown('cat[parent_id]', $categories, $cat->parent_id, 'class="form-control form-category input-sm"');
                    ?>
                </div>
            </div>
            <div class="form-group row">
                <label class="col-sm-2 control-label">Slug</label>
                <div class="col-sm-4">
                    <input type="text" name="cat[slug]" value="<?= set_value('cat[slug]', $cat->slug); ?>" class="form-control" />
                </div>
                <label class="col-sm-2 control-label">Sequence</label>
                <div class="col-sm-2">
                    <input type="text" name="cat[sequence]" value="<?= set_value('cat[sequence]', $cat->sequence); ?>" class="form-control" />
                </div>
            </div>

            <div class="form-group row">
                <label class="col-sm-2 control-label">Description</label>
                <div class="col-sm-8">
                    <textarea name="cat[description]" rows="4" cols="" class="form-control"><?= set_value('cat[description]', $cat->description); ?></textarea>
                </div>
            </div>
            <div class="form-group row">
                <label class="col-sm-2 control-label">Image</label>
                <div class="col-sm-8">
                    <div class="input-append">
                        <?php echo form_upload(array('name' => 'image')); ?>
                    </div>

                    <?php if ($cat->id && $cat->image != '') : ?>

                        <div style="text-align:center; padding:5px; border:1px solid #ddd;"><img class="img-responsive img-thumbnail" src="<?php echo base_url(upload_dir($cat->image)); ?>" alt="current" /><br />Current File</div>
                        <label class="checkbox checkbox-inline">
                            <input type="hidden" name="hid_image" value="<?php echo $cat->image; ?>" />
                            <input type="checkbox" name="del_image" value="1" />Delete this image
                        </label>
                    <?php endif; ?>
                </div>
            </div>
            <div class="form-group row">
                <label class="col-sm-2 control-label">Status</label>
                <div class="col-sm-3">
                    <?php
                    $st = array(
                        1 => 'Active',
                        0 => 'Deactive'
                    );
                    echo form_dropdown('cat[status]', $st, $cat->status, 'class="form-control input-sm"');
                    ?>
                </div>
                <label class="col-sm-2 control-label">Popular Category</label>
                <div class="col-sm-3">
                    <label class="checkbox-inline"><input type="checkbox" name="cat[popular_cat]" value="1" <?php if ($cat->popular_cat == 1) echo 'checked'; ?> /> Yes </label>
                </div>
            </div>

            <div class="form-group row">
                <label class="col-sm-2 control-label">&nbsp;</label>
                <div class="col-sm-8">
                    <button type="submit" class="btn btn-primary"><i class="fa fa-save"></i> Save</button> <a href="<?php echo admin_url('categories'); ?>" class="btn btn-secondary">Cancel</a>
                </div>
            </div>
        </div>
    </div>
</div>

</form>