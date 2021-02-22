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
        <h3>SQL MANAGER</h3>
    </div>
</div>
<div class="col-sm-12">
    <?php echo form_open(admin_url('settings/sql'), array('class' => 'form-horizontal')); ?>
	<div class="form-group">
		<label class="col-sm-2">SQL</label>
		<div class="col-sm-8">
			<textarea name="sql" rows="6" rows="" class="form-control input-sm"></textarea>
		</div>
	</div>
	<div class="form-group">
		<label class="col-sm-2">&nbsp;</label>
		<div class="col-sm-4">
			<input type="submit" value="Submit" name="submit" class="btn btn-sm btn-primary" />
		</div>
	</div>
    <?php echo form_close(); ?>
</div>
