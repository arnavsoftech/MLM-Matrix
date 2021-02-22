<div class="page-header">
	<h2>Media Manager <a href="<?php echo admin_url('media/add'); ?>" class="btn btn-sm btn-primary pull-right"><i class="fa fa-plus-sign"></i> Upload New</a></h2>
</div>
	<table class="table table-bordered table-striped">
		<thead>
		<tr>
			<th>Thumbnail</th>
			<th>Name</th>
			<th></th>
		</tr>
		</thead>
		<tbody>
		<?php
		foreach($medias as $row){
			?>
			<tr>
				<td align="center">
				<a href="<?php echo base_url().'img/products/'.$row -> file_name; ?>" target="_blank">
				<?php if($row -> is_image){ ?>
					<img src="<?php echo base_url().'img/products/'.$row -> file_name; ?>" width="50">
				<?php }else if( $row -> file_type == 'application/msword'){ ?>
					<img src="<?php echo base_url(); ?>/img/word-icon.jpg" width="50">
				<?php }else if( $row -> file_type == 'application/pdf'){ ?>
					<img src="<?php echo base_url(); ?>/img/pdf-icon.jpg" width="50">
				<?php }else if($row -> file_type == 'application/octet-st'){ ?>
                    <img src="<?php echo base_url(); ?>/img/zip-icon.jpg" width="50">
                <?php }else{
					echo $row -> file_type;
				} ?>
				</a>
				</td>
				<td><?php echo base_url().'img/products/'.$row -> file_name; ?></td>
				<td align="center">
                <div class="pull-right btn-group">
                <?php if($row -> is_image){ ?>
                <a href="<?= admin_url('media/edit/'.$row -> id); ?>" class="btn btn-sm btn-default">Edit</a>
                <?php } ?>
                 <a href="<?= admin_url('media/delete/'.$row -> id); ?>" class="btn btn-danger btn-sm delete">Delete</a>
                 </div>
                 </td>
			</tr>
			<?php
		}
		?>
		</tbody>
	</table>
<div class="pagination pagination-small">
	<?php echo $paginate; ?>
</div>
