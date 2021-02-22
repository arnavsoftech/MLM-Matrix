<div class="page-header">
	<h2>Billing Center Form</h2>
</div>
<?php echo form_open_multipart($this -> config -> item('admin_folder').'/billing/add_center/'.$id, array('class' => 'form-horizontal')); ?>
<div class="tabbable">

	<ul class="nav nav-tabs">
		<li class="active"><a href="#description_tab" data-toggle="tab">Billing Center</a></li>
		<!--<li><a href="#attributes_tab" data-toggle="tab">Menu Settings</a></li>-->
		<!--<li><a href="#seo_tab" data-toggle="tab">SEO</a></li>-->
	</ul>
	<div>&nbsp;</div>
	<div class="tab-content">
		<div class="tab-pane active" id="description_tab">
            <div class="form-group">
                <label class="col-sm-2">Enter Center Name</label>
                <div class="col-sm-3">
                <input type="text" name="form[center]" value="<?php  echo set_value('form[center]', $city -> center); ?>" class="form-control input-sm" />
                </div>
            </div>
              <div class="form-group">

        <label class="col-sm-2 control-label">Status</label>

        <div class="col-sm-3">

            <?php

            $st = array(

                1 => 'Active',

                0 => 'Deactive'

            );

            echo form_dropdown('form[status]', $st, $city -> status, 'class="form-control input-sm"');

            ?>

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

