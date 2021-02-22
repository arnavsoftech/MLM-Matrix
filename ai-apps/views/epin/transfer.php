<div class="page-header">
	<h3>Transfer Epin Report  </h3>
</div>

<div class="row form-search">
	
	<div class="col-sm-6">
		
	</div>
</form>
<div class="col-sm-6">
	<a id="pageload" href="<?= admin_url('epin/add'); ?>" class="btn btn-sm btn-primary pull-right"><i class="fa fa-plus-circle"></i> Generate Epin</a>
</div>
</div>



<table class="table table-bordered table-striped data-table">
	<thead>
		<tr>
			
			<th>ID</th>
			<th>Name</th>
			<th>PIN</th>
			<th>Action</th>
			
		</tr>
	</thead>
	<tbody>
		
		<?php  $k = $pin= array();
		foreach($mem_list as $m){
			
			    $s = json_decode($m->transfer,true);
				if(is_array($s) and count($s))
				{   
		            foreach ($s as $p) {

		                $k[]=$p['from'];
		                
		            }
	        	}

	    }
	    
	    if(is_array($k) and count($k)>0){
	    $mm = array_unique($k);	
	    foreach ($mm as $m) {
	    		
	   		$u = $this->User_model->getUserById($m);
			?>
			<tr>
				<td><?php echo  id2userid($u -> id); ?></td>
				<td><?php echo  $u -> first_name.' '. $u->last_name;?></td>
				<td><?php echo $this->User_model->total_pin($u->id); ?></td>
				<td><a class="btn btn-success" href="<?=admin_url('epin/transfer_pin/'.$m)?>">View Details</a></td>
				</tr>
				<?php 
				}}
			
			?>
		</tbody>
	</table>
	<div class="pagination">
		<?php //echo $paginate; ?>
	</div>
