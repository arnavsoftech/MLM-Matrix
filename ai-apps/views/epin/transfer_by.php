<div class="page-header">
	<h3>Epin Details   </h3>
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
			<th>SL.</th>
			<th>Transfer To</th>
			<th>PIN</th>
			
			<th>Transfer Date</th>
			<th>Status</th>
			<th>Action</th>
		</tr>
	</thead>
	<tbody>
		
		<?php  $i=1;
		foreach($mem_list as $m){
			
			 $s = json_decode($m->transfer,true);
                                            $show = false;
                                            $bal = 0;
                                            $created = 0;
                                            if(is_array($s) and count($s)){ 
                                                foreach ($s as $p) {

                                                    if($p['from']==$user_id){
                                                     $show=true;
                                                     $bal=$p['to'];
                                                     $created=$p['created'];

                                                    }
                                                }
                                            }
                                            if($show){
$u = $this->User_model->getUserById($bal);

			?>
			<tr>
				<td><?=$i++;?></td>
				<td><?php echo  id2userid($u->id); ?> (<?php echo  $u -> first_name.' '. $u->last_name;?>)</td>
				<td><?php echo $m -> pin; ?></td>
				
				<td><?php echo $created; ?></td>
				<td>
					<?php
					if($m -> pin_status == 1){
						?>
						<span class="label text-success">Active</span>
						<?php
					}else{
						?>
						<span class="label text-danger">Deactive</span>
							<?php
						}
						?>
					</td>
					<td>
						<?php
						if($m -> pin_status ==0 ){
							?>
							<div class="pull-right btn-group">
								<a href="<?php echo admin_url('epin/delete/'.$m -> id); ?>" class="btn btn-danger btn-sm delete"><i class="fa fa-trash"></i> </a>
							</div>
							<?php
						}
						?>
					</td>
				</tr>
				<?php
			} }
			?>
		</tbody>
	</table>
	<div class="pagination">
		<?php //echo $paginate; ?>
	</div>
