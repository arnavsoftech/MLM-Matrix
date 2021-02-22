<div class="page-header">
    <h2>Client Testimonials <a class="btn btn-sm btn-primary pull-right"
                               href="<?php echo admin_url('posts/add-testimonials'); ?>"><i class="fa fa-plus-sign"></i>
            Add New</a></h2>
</div>
<div class="row-fluid">
    <table class="table table-striped table-search1" id="post-index">
        <thead>
        <tr>
            <th>#ID</th>
            <th>Name</th>
            <th>Company</th>
            <th>Designation</th>
            <th>Text</th>
            <th></th>
        </tr>
        </thead>
        <tbody>
        <?php
        $sl = 1;
        foreach ($post_list as $row) {
            $a = new AI_Post($row->id);
            ?>
            <tr>
                <td><?= $sl++; ?></td>
                <td><?= $a->title(); ?></td>
                <td><?= $a-> data('about') ?></td>
                <td><?= $a-> data('designation') ?></td>
                <td><?= $a -> data("excerpt"); ?></td>
                <td>
                    <div class="btn-group pull-right">

                        <a class="btn btn-sm btn-default"
                           href="<?php echo admin_url('posts/add-testimonials/' . $row->id);?>"><i class="fa fa-pencil"></i>
                            Edit</a>

                        <a class="btn btn-sm btn-danger delete"
                           href="<?php echo admin_url('posts/del-test/' . $row->id);?>"><i class="fa fa-trash"></i> Delete</a>
                    </div>
                </td>
            </tr>
        <?php
        }
        ?>
        </tbody>
    </table>
</div>
