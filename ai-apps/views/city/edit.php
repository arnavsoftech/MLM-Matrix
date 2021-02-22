<div class="page-header">
	<h2>Occupation Form</h2>
</div>
<?php
	$v_error = validation_errors();
	if($v_error != ''){
		?>
        <div class="alert alert-danger">
        	<?php echo $v_error; ?>
        </div>
        <?php	
	}
?>
<?php echo form_open_multipart($this -> config -> item('admin_folder').'city/edit/'.$city -> id, array('class' => 'form-horizontal')); ?>
<div class="tabbable">

	<ul class="nav nav-tabs">
		<li class="active"><a href="#description_tab" data-toggle="tab">City</a></li>
		<!--<li><a href="#attributes_tab" data-toggle="tab">Menu Settings</a></li>-->
		<!--<li><a href="#seo_tab" data-toggle="tab">SEO</a></li>-->
	</ul>
    <div>&nbsp;</div>
	<div class="tab-content">
		<div class="tab-pane active" id="description_tab">
        <div class="form-group">
        	<label class="col-sm-2">City name</label>
            <div class="col-sm-4">
            <input type="text" name="cityname" value="<?php  echo set_value('cityname', $city -> city_name); ?>" class="form-control input-sm" />
            </div>
        </div>
         <div class="form-group">
        	<label class="col-sm-2">Sequence</label>
            <div class="col-sm-4">
            <input type="text" name="citysequence" value="<?php  echo set_value('citysequence', $city -> city_sequence); ?>" class="form-control input-sm" />
            </div>
        </div>
			
		</div>
		
	</div>

</div>

<div class="form-actions">
	<input type="hidden" name="submit" value="Saved" />	
	<button type="submit" class="btn btn-primary btn-sm">Save</button>
</div>
</form>

<script type="text/javascript">
$('form').submit(function() {
	$('.btn').attr('disabled', true).addClass('disabled');
});
</script>