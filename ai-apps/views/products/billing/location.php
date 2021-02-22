<div class="page-header">
	<h2>Billing Center</h2>
	<div class="row">
		<div class="col-sm-6">
			<!--<form method="get" action="<?= current_url(); ?>">
				<div class="input-group">
					<input type="text" name="center" value="" class="form-control input-sm" />
					<div class="input-group-btn">
						<input type="submit" name="btn_search" value="Seach" class="btn btn-primary btn-sm" />
					</div>
				</div>
			</form>-->
		</div>
		<div class="col-sm-6 text-right">
			<a class="btn btn-sm btn-primary" href="<?php echo admin_url('billing/add_center'); ?>"><i class="glyphicon glyphicon-plus-sign"></i> Add New Center</a>
		</div>
	</div>
</div>

<table class="table table-striped">
    <thead>
		<tr>
			<th>SL.no</th>
			<th>Center Name</th>
        	<th>Status</th>
			<th>Actiton</th>
		</tr>
	</thead>
	<tbody>
		<?php if(!is_array($city) && count($city) == 0) echo '<tr><td style="text-align:center;" colspan="3">No Occupation Found</td></tr>'?>

		<?php if(is_array($city) && count($city) > 0) { foreach($city as $row): ?>
        	<tr>
            	<td><?php echo $row->id; ?></td>
            	<td><?php echo $row->center; ?></td>
                <td><?php if($row->status==0) echo 'Deactive'; else echo "Active"; ?></td>
                
                <td>
					<div class="btn-group pull-right">
                        <a href="<?= admin_url('billing/add_center/'.$row -> id); ?>" class="btn btn-sm btn-primary"><i class="fa fa-pencil"></i> Edit</a>
                        <a href="<?= admin_url('billing/delete_center/'.$row -> id);?>" class="btn btn-sm btn-danger delete"><i class="fa fa-trash"></i> Delete</a>
                    </div>
				<?php

				?></td>
        	</tr>
        <?php endforeach; } ?>
	</tbody>
</table>
<div class="pagination pagination-sm">
	<?php echo $paginate; ?>
</div>
