<div class="page-header">
	<h2>Franchisee Order</h2>
</div>
<div class="row">
    <div class="col-sm-4">
        </div>
         <div class="col-sm-4">
        </div>

 <div class="col-sm-4" >
    <a href="<?=admin_url('franchisee/add/');?>" class="btn btn-primary" style="float: right;">Add New Order</a>
        </div>
    </div>
<div class="table-responsive">
<table class="table table-bordered table-striped data-table">
	<thead>
	<tr>
		<th>ID</th>
		<th>Product Name</th>
		<th>Quantity</th>
        <th>UserID</th>
		
		 <th>Action</th>
	</tr>
	</thead>
	<tbody>
	<?php $i=1;
	if (is_array ($franchisee) && count ($franchisee) > 0) {
		foreach ($franchisee as $fr) {
            $ob = $this->db->select('ptitle')->get_where('products',array('id'=>$fr->product_id))->row();
            $us = $this->db->select('userid,first_name,last_name')->get_where('franch',array('id'=>$fr->user_id))->row();
			?>
			<tr>
				<td><?= $i++; ?></td>
                <td><?= @$ob->ptitle; ?>
                	
                </td>
                <td><?= $fr->qty; ?></td>
				<td><?= $us->userid.'('.$us->first_name.' '.$us->last_name.')'; ?></td>
			    <td>
					<div class="btn-group pull-right">
						<a href="<?= admin_url ('franchisee/add/' . $fr->id); ?>" title="Edit"
						   class="btn btn-xs btn-info"><i class="fa fa-pencil"></i> </a>
						<a href="<?= admin_url ('franchisee/delete/' . $fr->id); ?>" title="Delete"
						   class="btn btn-xs btn-danger delete"><i class="fa fa-trash"></i> </a>
					</div>
				</td>
			</tr>
		<?php
		}
	}
	?>
	</tbody>
</table>
</div>
