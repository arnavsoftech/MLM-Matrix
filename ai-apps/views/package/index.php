<div class="page-header">
    <h3>Package Details </h3>
</div>






    <div class="row form-search">

        <div class="col-sm-6">

        </div>

        <div class="col-sm-6">

            <a href="<?= admin_url('package/add'); ?>" class="btn btn-sm btn-primary pull-right"><i class="fa fa-plus-circle"></i> Add Package</a>

        </div>

    </div>



<div class="widget1">

    

    <div class="widget-content">

        <table class="table table-bordered table-striped data-table">
            <thead>
                <tr>
                    <th>Sl No</th>
                    <th>Package Name</th>
                    
                    <th>Package Amt</th>
                    <th> Point </th>
                   
                    <th>Type</th>
                    <th>Status</th>
                        <th></th>


                </tr>
            </thead>
            <tbody>
                <?php
                $sl = 1;
                foreach ($pack as $m) {

                    ?>
                    <tr>
                        <td><?= $sl++; ?></td>
                        <td><?= $m->package; ?></td>
                       
                        <td><?php echo $m->mrp; ?></td>
                        <td><?php echo  $m->point;?></td>
                       
                         <td><?php echo  $this->Package_model->package_info($m->pack_type);?></td>
                        <td><?php if ($m -> status == 1) { ?>

                                    <a href="<?= admin_url('package/deactivate/' . $m -> id, TRUE); ?>"                                   class="btn btn-sm btn-success  label label-success">Active</a>

                                <?php } else { ?>

                                    <a href="<?= admin_url('package/activate/' . $m -> id, TRUE); ?>"                                   class="btn btn-sm btn-danger label label-danger">Deactive</a>

                                <?php } ?></td>
                        <td>

                            <div class="pull-right btn-group">
                              
                                <a href="<?php echo admin_url('package/add/' . $m->id); ?>" class="btn btn-secondary btn-sm"><i class="fa fa-pencil"></i> </a>
                                <a href="<?php echo admin_url('package/delete/' . $m->id); ?>" class="btn btn-danger btn-sm delete"><i class="fa fa-trash"></i> </a>
                            </div>

                        </td>

                    </tr>

                <?php

            }

            ?>

            </tbody>

        </table>

    </div>

</div>