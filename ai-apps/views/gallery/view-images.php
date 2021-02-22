<div class="page-header">
    <a href="<?php echo admin_url('gallery/multiple/' . $id); ?>" class="pull-right btn btn-primary btn-sm"><i class="fa fa-plus-circle"></i> Upload New</a>
    <h4>Gallery :: <?php echo $gallery_name; ?> </h4>

</div>

<div class="btn-group pull-right">



</div>

<div class="box box-p">

    <table class="table table-striped">

        <thead>

            <tr>

                <th>Image</th>

                <th>Title</th>

                <th>URL</th>

                <th>&nbsp;</th>

            </tr>

        </thead>

        <tbody>

            <?php foreach ($image_list as $row): ?>

                <tr>

                    <td><img src="<?php echo base_url(upload_dir($row -> image)); ?>" width="100" class="thumbnail" /></td>

                    <td><?php echo $row -> title; ?></td>

                    <td><?php echo base_url(upload_dir($row -> image)); ?> </td>

                    <td><div class="pull-right btn-group">

                            <a href="<?php echo admin_url('gallery/edit-image/' . $row -> id); ?>" class="btn btn-secondary btn-sm"><i class="fa fa-pencil"></i></a>

                            <a href="<?php echo admin_url('gallery/delete-image/' . $id . '/' . $row -> id); ?>" class="btn btn-danger btn-sm delete"><i class="fa fa-trash"></i></a></div></td>

                </tr>

            <?php endforeach; ?>

        </tbody>

    </table>

</div>

