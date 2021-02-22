<div class="page-header">
	<h3>Package List </h3>
</div>


	
		<div class="col-sm-12">
			<a id="pageload" href="<?= admin_url('products/create_package'); ?>" class="btn btn-sm btn-primary pull-right"><i class="fa fa-plus-circle"></i> Create Package</a>
            <!-- Modal -->
		</div>
	</div>

<table class="table table-bordered table-striped">
	<tbody>
    	<tr>

            <th>Plan</th>
            <th>Price</th>
            <th>Photo</th>
           
            <th></th>
        </tr>
        <?php
			foreach($pack as $p){
				?>
                <tr>

                    <td><?= $p -> name; ?></td>
                    <td>
	                  <?= $p -> price; ?> 
                    </td>
                   <td>
                    <img class="img-responsive" width="100" src="<?= base_url(upload_dir($p -> image)) ?>">

                     </td>

                   
                    <td>
                        
                        <a class="btn btn-success btn-sm" href="<?= admin_url('products/add_item/'.$p -> id);?>"> <i class="fa fa-plus"></i> Add Items </a>
                    	<div class="pull-right btn-group">
                        	<a href="<?php echo admin_url('products/create_package/'.$p -> id); ?>" class="btn btn-warning btn-sm"><i class="fa fa-pencil"></i> </a>
                        	
                          <!--   <a href="<?php echo admin_url('products/delete/'.$p -> id); ?>" class="btn btn-danger btn-sm delete"><i class="fa fa-trash"></i> </a> -->
                        </div>
                    </td>
                </tr>
                <?php
			}
		?>
    </tbody>
</table>

