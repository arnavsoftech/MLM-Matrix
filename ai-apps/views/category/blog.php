<div class="page-header">

    <a class="btn pull-right btn-sm btn-primary" href="<?php echo admin_url('categories/add_blog'); ?>"><i					class="fa fa-plus-circle"></i> Add Blog Category</a>

    <h2>Blog Categories </h2>

</div>

<div class="box">

    <div class="box-p">

        <table class="table table-bordered table-striped">

            <thead>

                <tr>

                    <th>#ID</th>

                    <th>Name</th>

                   

                    <th>Status</th>

                    <th></th>

                </tr>

            </thead>

            <tbody>

                <?php

                if (is_array($categories) && count($categories) > 0) {

                    foreach ($categories as $cat) {

                        $ob = new AI_Category($cat -> id);

                        ?>

                        <tr>

                            <td><?= $cat -> id; ?></td>

                            <td><?= $cat -> name; ?></td>

                           
                            <td>

                                <?php if ($cat -> status == 1) { ?>

                                    <a href="<?= admin_url('categories/deactivate_blog/' . $cat -> id, TRUE); ?>"                                   class="label label-success">Active</a>

                                <?php } else { ?>

                                    <a href="<?= admin_url('categories/activate_blog/' . $cat -> id, TRUE); ?>"                                   class="label label-danger">Deactive</a>

                                <?php } ?>

                            </td>

                            <td>

                                <div class="btn-group pull-right">

                                    <a href="<?= admin_url('categories/add_blog/' . $cat -> id); ?>" title="Edit"                                   class="btn btn-xs btn-info"><i class="fa fa-pencil"></i> </a>

                                    <a href="<?= admin_url('categories/delete_blog/' . $cat -> id); ?>" title="Delete"                                   class="btn btn-xs btn-danger delete"><i class="fa fa-trash"></i> </a>

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

</div>

<div class="pagination pagination-small">

    <?= $this -> page_links; ?>

</div>