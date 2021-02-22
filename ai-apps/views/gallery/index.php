<div class="page-header">
    <div class="row">
        <div class="col-sm-6">
            <h4>Gallery </h4>
        </div>
        <div class="col-sm-6">

            <a href="<?php echo admin_url('gallery/create'); ?>" class="btn btn-sm btn-primary pull-right"><i class="fa fa-plus-circle"></i> Create New Gallery</a>

        </div>
    </div>
</div>
<div class="box box-p">
    <table class="table table-striped">

        <thead>

        <th>ID</th>

        <th>Gallery Title</th>

        <th>Shortcodes</th>

        <th>&nbsp;</th>

        </thead>

        <tbody>

            <?php
            if ((count($gallery_list) > 0) && is_array($gallery_list)) {

                foreach ($gallery_list as $row):
                    ?>

                    <tr>

                        <td><?php echo $row -> id; ?></td>

                        <td><a href="<?php echo admin_url('gallery/view/' . $row -> id); ?>"><?php echo $row -> gallery_name; ?></a></td>

                        <td><?php echo '[GALLERY-' . $row -> id . ']'; ?></td>

                        <td>

                            <div class="btn-group pull-right">

                                <a href="<?php echo admin_url('gallery/multiple/' . $row -> id); ?>" class="btn btn-secondary btn-sm"><i class="fa fa-plus-circle"></i></a>

                                <a href="<?php echo admin_url('gallery/create/' . $row -> id); ?>" class="btn btn-info btn-sm"><i class="fa fa-pencil"></i></a>

                                <a href="<?php echo admin_url('gallery/delete/' . $row -> id); ?>" class="btn btn-sm btn-danger delete"><i class="fa fa-trash"></i></a>

                            </div>

                        </td>

                    </tr>

                    <?php
                endforeach;
            }
            ?>

        </tbody>

    </table>
</div>

