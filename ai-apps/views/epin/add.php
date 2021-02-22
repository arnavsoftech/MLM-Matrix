<div class="page-header">
    <h2>Generate Epin</h2>
</div>
<?php //var_dump($m);
?>
<div class="row">
    <div class="col-sm-5">
        <div class="box">
            <div class="box-p">
                <?php echo form_open(admin_url('epin/add/'), array('class' => 'form-horizontal')); ?>
                <div class="form-group row">
                    <label class="col-sm-3 text-right">User id</label>
                    <div class="padrit col-sm-8">
                        <?php
                        // print_r($us);
                        $arr = array();
                        foreach ($us as $u) {
                            $arr[$u->id] = $u->username . " (" . $u->first_name . " " . $u->last_name . ")";
                        }
                        echo form_dropdown('user_id', $arr, set_value('user_id'), 'class="form-control newenqcl" required');
                        ?>
                    </div>
                </div>
                <div class="form-group row">
                    <label class="text-right col-sm-3">Package</label>
                    <div class="padrit col-sm-8">
                        <?php
                        $list = config_item('package');
                        echo form_dropdown('pintype', $list, '', 'class="form-control"');
                        ?>
                    </div>
                </div>
                <div class="form-group row">
                    <label class="text-right col-sm-3">Quantity</label>
                    <div class="padrit col-sm-8">
                        <input type="text" name="quantity" value="" class="form-control input-sm" />
                    </div>
                </div>

                <div class="form-group row">
                    <label class="col-sm-3"></label>
                    <div class="col-sm-8">
                        <input type="submit" name="submit" value="Generate" class="btn btn-primary" />
                        <a href="<?= admin_url('epin'); ?>" class="btn btn-dark">Cancel</a>
                    </div>
                </div>
                <?php echo form_close(); ?>
            </div>
        </div>
    </div>
</div>