<?php
$pin_arr = array();
if($pin -> categories <> NULL){
	$pin_arr = json_decode($pin -> categories);
}
if(!is_array($pin_arr)){
	$pin_arr = array();
}
?>
<div class="col-sm-12">
    <div class="page-header">
        <h3>Add / Edit Pincode</h3>
    </div>
</div>
<div class="col-sm-12">
    <?php echo form_open(admin_url('settings/addpin/'.$pin -> id), array('class' => 'form-horizontal')); ?>
    <div class="form-group">
        <label class="col-sm-2 control-label">Pincode</label>
        <div class="col-sm-3">
            <input type="text" name="pincode" value="<?php echo set_value('pincode', $pin -> pincode); ?>" class="form-control input-sm" required="required" />
        </div>
	    <label class="col-sm-1 control-label">Status</label>
	    <div class="col-sm-3">
		    <?php
		    $st = array(
			    0 => 'Deactive',
			    1 => 'Active'
		    );
		    echo form_dropdown('status', $st, set_value('status', $pin -> status), 'class="form-control input-sm"');
		    ?>
	    </div>
    </div>
    <div class="form-group">
        <label class="col-sm-2 control-label">Categories</label>
        <div class="col-sm-10">
	        <ul class="chkcategories">
	        <?php
	        if(is_array($cats) && count($cats) > 0){
		        foreach($cats as $cp){
			        ?>
	                <li><label class="checkbox">
		                <input type="checkbox" name="cats[]" value="<?= $cp['category'] -> id; ?>" <?php if(in_array($cp['category'] -> id, $pin_arr)) echo 'checked'; ?> /> <?= $cp['category'] -> name; ?>
	                </label>
		                <?php
		                if(count($cp['children']) > 0){
			                foreach($cp['children'] as $cc){
				                ?>
				                <label class="checkbox">
					                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type="checkbox" name="cats[]" value="<?= $cc['category'] -> id; ?>"  <?php if(in_array($cc['category'] -> id, $pin_arr)) echo 'checked'; ?>/> <?= $cc['category'] -> name; ?>
				                </label>
		                        <?php
				                if(count($cc['children']) > 0){
					                foreach($cc['children'] as $ccc){
						                ?>
						                <label class="checkbox checkbox-inline">
							                <input type="checkbox" name="cats[]" value="<?= $ccc['category'] -> id; ?>" <?php if(in_array($ccc['category'] -> id, $pin_arr)) echo 'checked'; ?> /> <?= $ccc['category'] -> name; ?>
						                </label>
					                <?php

					                }
				                }
			                }
		                }
		                ?>
	                </li>
	                <?php
		        }
	        }
	        //print_r($cats);
	        ?>
		    </ul>
        </div>
    </div>
    <div class="form-group">
        <div class="col-sm-3 col-sm-offset-2">
            <input name="submit" type="submit" class="btn btn-sm btn-primary" value="Update" />
            <a href="<?php echo admin_url('settings/pincodes'); ?>" class="btn btn-sm btn-default">Cancel</a>
        </div>
    </div>
    <?php echo form_close(); ?>
</div>
