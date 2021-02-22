<?php
/**
 * Created by PhpStorm.
 * User: Kamal Kumar
 * Date: 11/27/2014
 * Time: 8:55 AM
 */
?>
<div class="col-sm-12">
    <div class="page-header">
        <h3>Add / Edit URL</h3>
    </div>
</div>
<?php
    extract($url);
?>
<div class="col-sm-12">
    <?php echo form_open(admin_url('settings/edit-url/'.$id), array('class' => 'form-horizontal')); ?>
    <div class="form-group">
        <label class="col-sm-2 control-label">URL</label>
        <div class="col-sm-10">
            <input type="text" name="url" value="<?php echo set_value('url', $url); ?>" class="form-control input-sm" required="required" />
        </div>
    </div>
    <div class="form-group">
        <label class="col-sm-2 control-label">H1 Tag</label>
        <div class="col-sm-10">
            <input type="text" name="h1_heading" value="<?php echo set_value('h1_heading', $h1_heading); ?>" class="form-control input-sm" />
        </div>
    </div>
    <div class="form-group">
        <label class="col-sm-2 control-label">Small Description</label>
        <div class="col-sm-10">
            <textarea name="small_desc" rows="3" cols="" class="form-control input-sm"><?php echo set_value('small_desc', $small_desc); ?></textarea>
        </div>
    </div>
    <div class="form-group">
        <label class="col-sm-2 control-label">SEO Title</label>
        <div class="col-sm-10">
            <input type="text" name="seo_title" value="<?php echo set_value('seo_title', $seo_title); ?>" class="form-control input-sm" />
        </div>
    </div>
    <div class="form-group">
        <label class="col-sm-2 control-label">SEO Description</label>
        <div class="col-sm-10">
            <textarea name="seo_description" rows="3" cols="" class="form-control input-sm"><?php echo set_value('seo_description', $seo_description); ?></textarea>
        </div>
    </div>
    <div class="form-group">
        <label class="col-sm-2 control-label">SEO Keywords</label>
        <div class="col-sm-10">
            <textarea name="seo_keywords" rows="3" cols="" class="form-control input-sm"><?php echo set_value('seo_keywords', $seo_keywords); ?></textarea>
        </div>
    </div>
    <div class="form-group">
        <div class="col-sm-3 col-sm-offset-2">
            <input name="submit" type="submit" class="btn btn-sm btn-primary" value="Update" />
            <a href="<?php echo admin_url('settings/seo-url'); ?>" class="btn btn-sm btn-default">Cancel</a>
        </div>
    </div>
    <?php echo form_close(); ?>
</div>
