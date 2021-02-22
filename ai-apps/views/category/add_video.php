<div class="page-header">

    <h2>Video Gallery Form</h2>

</div>

<?php echo form_open_multipart(admin_url('categories/add_video/' . $cat -> id), array('class' => 'form-horizontal')); ?>

<div class="row">

    <div class="col-sm-12">

        <div class="tab-pane active" id="description_tab">

            <div class="form-group row">

                <label class="col-sm-2 control-label">Title</label>

                <div class="col-sm-8">

                    <input type="text" name="cat[title]" value="<?= set_value('cat[title]', $cat -> title); ?>" class="form-control" />

                </div>

               

            </div>

             <div class="form-group row">

                    <label class="col-sm-2">Select Category:</label>

                    <div class="col-sm-8">

                        <?php 
                            //echo form_dropdown('type_img', array(1 => 'Banner', 2 => 'Meeting',3 => 'Our Achievers',4=>'Training Programme'), set_value('types_img'), 'class="form-control" required');
                           echo form_dropdown('cat[parent_id]', $categories, set_value('cat[parent_id]',$cat->parent_id), 'class="form-control form-category input-sm" required'); 
                        ?>

                    </div>

                </div> 


            <div class="form-group row">

                <label class="col-sm-2 control-label">Youtube Video Code</label>

                <div class="col-sm-8">

                   <input type="text" name="cat[short_code]" value="<?= set_value('cat[short_code]', $cat -> short_code); ?>" class="form-control" required />


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

                    echo form_dropdown('cat[status]', $st, $cat -> status, 'class="form-control input-sm"');

                    ?>

                </div>

               
            </div>

           

            <div class="form-group row">

                <label class="col-sm-2 control-label">&nbsp;</label>

                <div class="col-sm-8">

                    <button type="submit" class="btn btn-primary"><i class="fa fa-save"></i> Save</button> <a href="<?php echo admin_url('categories/video'); ?>" class="btn btn-secondary">Cancel</a>

                </div>

            </div>

        </div>

    </div>

</div>



</form>

