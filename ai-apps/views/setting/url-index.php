<?php
/**
 * Created by PhpStorm.
 * User: Kamal Kumar
 * Date: 11/27/2014
 * Time: 8:55 AM
 */
?>
<div class="col-sm-12">
    <div class="page-header">
        <h3>URL Manager <a href="<?php echo admin_url('settings/edit-url'); ?>" class="btn btn-sm btn-primary pull-right">Add URL</a> </h3>
    </div>
</div>
<div class="col-sm-12">
    <table class="table table-striped">
        <thead>
        <tr>
            <th>Sl No</th>
            <th>Page URL</th>
            <th>Page Title</th>
            <th></th>
        </tr>
        </thead>
        <tbody>
            <?php
            $sl = 1;
            foreach($urls as $row): ?>
            <tr>
                <td><?php echo ++$offset; ?></td>
                <td><?php echo $row['url']; ?></td>
                <td><?php echo $row['seo_title']; ?></td>
                <td>
                    <div class="pull-right btn-group">
                        <a href="<?php echo admin_url('settings/edit-url/'.$row['id']); ?>" class="btn btn-sm btn-default" title="Edit"><i class="fa fa-pencil"></i> </a>
                        <a href="<?php echo admin_url('settings/delete-url/'.$row['id']); ?>" class="btn btn-sm btn-danger delete" title="Delete"><i class="fa fa-trash"></i> </a>
                    </div>
                </td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>
<div class="col-sm-12 text-center">
    <?php echo $paginate; ?>
</div>
