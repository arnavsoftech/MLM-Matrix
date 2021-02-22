<div class="page-header">
	<h2>State List</h2>
</div>
<div class="pull-right">
	<a class="btn btn-sm btn-primary" href="<?php echo site_url($this -> config -> item('admin_folder').'city/add_state'); ?>"><i class="glyphicon glyphicon-plus-sign"></i> Add New State</a>
</div>

<table class="table table-striped">
    <thead>
		<tr>
			<th>State ID</th>
			<th>State Name</th>  
            <th>Sequence</th>          
			<th></th>
		</tr>
	</thead>
	<tbody>
		<?php echo (count($states) < 1)?'<tr><td style="text-align:center;" colspan="3">No State Found</td></tr>':''?>
	
		<?php foreach($states as $row): ?>
        	<tr>
            	<td><?php echo $row['id']; ?></td>
            	<td><?php echo $row['state_name']; ?></td>
                <td><?php echo $row['sequence']; ?></td>
                <td>
					<div class="btn-group pull-right">
                    	<a href="<?php echo site_url($this -> config -> item('admin_folder').'city/add_state/'.$row['id']); ?>" class="btn btn-sm btn-default"><i class="glyphicon glyphicon-pencil"></i> Edit</a>
                        <a href="<?php echo  site_url($this -> config -> item('admin_folder').'city/delete_state/'.$row['id']);?>" class="btn btn-sm btn-danger delete"><i class="glyphicon glyphicon-trash"></i> Delete</a>
                    </div>
				<?php
                	
				?></td>
        	</tr>
        <?php endforeach; ?>
	</tbody>
</table>
