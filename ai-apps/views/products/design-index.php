<div class="page-header">
	<h2>Manage Stock </h2>
</div>
<div class="row">
	
	<div class="col-sm-12">
    	<table class="table table-bordered table-striped data-table">
		    <thead>
		    <tr>
			    <th> #</th>
			    <th>Product Name</th>
			    <th>SKU</th>
			    <th>Quantity</th><th>Action</th>
		    </tr>
		    </thead>
        	<tbody>
	        <?php
	        if(is_array($designs) && count($designs) > 0){
		        foreach($designs as $p){
			        ?>
	                <tr>
		                <td><?= $p -> id; ?></td>
		                <td><?= $p -> ptitle; ?></td>
		                  <td><?= $p -> sku; ?></td>
		                <td><?= $p -> qty; ?>
			                <td><a class="btn btn-sm btn-primary" href="<?=admin_url('products/add/'.$p->id);?>">Update Stock</a></td>
		                </td>
	                </tr>
	                <?php
		        }
	        }
	        ?>
            </tbody>
        </table>

    </div>
</div>
