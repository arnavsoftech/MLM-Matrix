<div class="page-header">

    <div class="float-right">

        <a class="btn btn-sm btn-primary" href="<?php echo admin_url('posts/add-post'); ?>"><i class="fa fa-plus-circle"></i> Add offer</a>

    </div>

    <h5>Offer</h5>

</div>

<div class="box box-p">

    <table class="table data-table table-striped table-search1" id="post-index">

        <thead>

            <tr>

                <th>#ID</th>

                <th>Title</th>

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

                    <td><?= $row -> post_title; ?></td>



                    <td>

                        <?php

                        if ($row -> status == 1) {

                            ?>

                            <a href="<?= admin_url('posts/deactivate/' . $row -> id, true); ?>" class="badge badge-success tip" title="Deactive now">Active</a>

                            <?php

                        } else {

                            ?>

                            <a href="<?= admin_url('posts/activate/' . $row -> id, true); ?>" class="badge badge-danger tip" title="Activate now">Deactive</a>

                            <?php

                        }

                        ?>

                    </td>

                    <td>

                        <div class="btn-group pull-right">



                            <a class="btn btn-xs btn-secondary" href="<?php echo admin_url('posts/add-post/' . $row -> id); ?>"><i class="fa fa-pencil"></i></a>

                            <a class="btn btn-xs btn-danger" onclick="return confirm('Are Your Sure to delete?');;" href="<?php echo admin_url('posts/delete/' . $row -> id); ?>" ><i class="fa fa-trash"></i></a>

                        </div>

                    </td>

                </tr>

                <?php

            }

            ?>

        </tbody>

    </table>

</div>

<div class="text-center">

    <?php echo $this -> page_links; ?>

</div>

