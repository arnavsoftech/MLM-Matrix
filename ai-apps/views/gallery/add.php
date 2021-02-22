<div class="page-header">

	<h4>Gallery Form</h4>

</div>
<div class="row">
    <div class="col-sm-5">
        <div class="box box-p">
            <?php echo form_open(admin_url('gallery/create/'.$gallery -> id), array('class' => 'form-horizontal')); ?>

    	<div class="form-group">    
            <label for="name">Gallery Name</label>
				<input type="text" name="gal[gallery_name]" value="<?php echo set_value('gal[gallery_name]', $gallery -> gallery_name); ?>" class="form-control input-sm" />
        </div>

        <div class="form-group">
        	<label>Description</label>
            <textarea name="gal[description]" rows="4" cols="" class="form-control input-sm"><?php echo set_value('description', $gallery -> description); ?></textarea>

       	</div>

       	<div class="form-group row">
       		<label for="layout" class="col-sm-12">Sequence</label>
           <div class="col-sm-4">
                <input type="text" name="gal[sequence]" value="<?php echo set_value('gal[sequence]', $gallery -> sequence); ?>" class="form-control input-sm" />        
           </div>

      	</div>

      	<div class="form-group">

            <button type="submit" name="submit" value="Create" class="btn btn-primary"><i class="fa fa-save"></i> Save</button>

                <a href="<?php echo admin_url('gallery'); ?>" class="btn btn-secondary"><i class="fa fa-close"></i> Cancel</a>

		</div>

    <?php echo form_close(); ?>
        </div>
    </div>
</div>

