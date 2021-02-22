<div class="page-header">

    <a class="btn pull-right btn-sm btn-primary" href="<?php echo admin_url('categories/add_video'); ?>"><i					class="fa fa-plus-circle"></i> Add Video Category</a>

    <h2>Manage Video </h2>

</div>

<div class="box box-p">

    <table class="table data-table table-striped table-search1" id="post-index">

        <thead>

            <tr>

                <th>#ID</th>

                <th>Title</th>
                <th>Category</th>
                <th>Status</th>

                <th></th>

            </tr>

        </thead>

        <tbody>

            <?php

            $sl = 1;

            foreach ($post_list as $row) {

                ?>

                <tr>

                    <td>#<?= $sl++; ?></td>

                    <td><?= $row -> title; ?></td>

                     <td><?=$this->Category_model->name($row -> parent_id); ?></td>

                    <td>

                        <?php

                        if ($row -> status == 1) {

                            ?>

                            <a href="<?= admin_url('categories/video_deactivate/' . $row -> id, true); ?>" class="badge badge-success tip" title="Deactive now">Active</a>

                            <?php

                        } else {

                            ?>

                            <a href="<?= admin_url('categories/video_activate/' . $row -> id, true); ?>" class="badge badge-danger tip" title="Activate now">Deactive</a>

                            <?php

                        }

                        ?>

                    </td>

                    <td>

                        <div class="btn-group pull-right">



                            <a class="btn btn-xs btn-secondary" href="<?php echo admin_url('categories/add_video/' . $row -> id); ?>"><i class="fa fa-pencil"></i></a>

                            <a class="btn btn-xs btn-danger" onclick="return confirm('Are Your Sure to delete?');;" href="<?php echo admin_url('categories/video_delete/' . $row -> id); ?>" ><i class="fa fa-trash"></i></a>

                        </div>

                    </td>

                </tr>

                <?php

            }

            ?>

        </tbody>

    </table>

</div>

