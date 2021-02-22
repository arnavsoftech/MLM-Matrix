<div class="page-header">
	<h2>State Form</h2>
</div>
<?php echo form_open_multipart($this -> config -> item('admin_folder').'city/add_state/'.$id, array('class' => 'form-horizontal')); ?>
<div class="tabbable">

	<ul class="nav nav-tabs">
		<li class="active"><a href="#description_tab" data-toggle="tab">State</a></li>
		<!--<li><a href="#attributes_tab" data-toggle="tab">Menu Settings</a></li>-->
		<!--<li><a href="#seo_tab" data-toggle="tab">SEO</a></li>-->
	</ul>
	<div>&nbsp;</div>
	<div class="tab-content">
		<div class="tab-pane active" id="description_tab">
			<div class="form-group">
        	<label class="col-sm-2">State name</label>
            <div class="col-sm-4">
            <input type="text" name="state_name" value="<?php  echo set_value('state_name', $state['state_name']); ?>" class="form-control input-sm" />
            </div>
        </div>
        	<div class="form-group">
        	<label class="col-sm-2">Sequence</label>
            <div class="col-sm-4">
            <input type="text" name="sequence" value="<?php  echo set_value('sequence',$state['sequence']); ?>" class="form-control input-sm" />
            </div>
        </div>
        	<div class="form-group">
        	<label class="col-sm-2">&nbsp;</label>
            <div class="col-sm-4">
            <button type="submit" class="btn btn-primary btn-sm">Save</button>
            </div>
        </div>
		</div>
		
	</div>

</div>
</form>

<script type="text/javascript">
$('form').submit(function() {
	$('.btn').attr('disabled', true).addClass('disabled');
});
</script>