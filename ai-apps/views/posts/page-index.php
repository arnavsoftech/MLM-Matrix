<div class="page-header">

    <h4>Manage Pages <a href="<?= admin_url('posts/add-page'); ?>" class="btn btn-sm btn-primary pull-right"><i class="fa fa-plus-circle"></i> Add Pages</a> </h4>

</div>

<?php echo form_open('post/bulksave'); ?>

<div class="box box-p">

    <div class="clearfix">

        <table class="table table-bordered table-striped table-search">

            <thead>

                <tr>

                    <th>#ID</th>

                    <th>Page Title</th>

                    

                    <th>Status</th>

                    <th></th>

                </tr>

            </thead>

            <tbody>

                <?php

                $sl = 1;

                foreach ($post_list as $p) {

                    //$p = new AI_Post($row -> id);

                    ?>

                    <tr>

                        <td><?= $p -> id; ?></td>

                        <td><a href="#" target="_blank"><?= $p -> post_title; ?></a></td>

                        

                        <td><?php

                        if ($p -> status == 1) {

                            ?>

                            <a href="<?= admin_url('posts/deactivate/' . $p -> id, true); ?>" class="badge badge-success">Published</a>

                            <?php

                        } else {

                            ?>

                            <a href="<?= admin_url('posts/activate/' . $p -> id, true); ?>" class="badge badge-danger">Draft</a>

                            <?php

                        }

                        ?>

                    </td>

                    <td>

                        <div class="btn-group pull-right">



                            <a class="btn btn-sm btn-secondary" href="<?= admin_url('posts/add-page/' . $p -> id); ?>"><i class="fa fa-pencil"></i></a>



                            <a class="btn btn-sm btn-danger delete" href="<?= admin_url('posts/delete/' . $p -> id); ?>"><i class="fa fa-trash"></i></a>

                        </div>

                    </td>

                </tr>

                <?php

            }

            ?>

        </tbody>

    </table>

</div>

</div>

</form>

<div class="pagination">

    <?= $this -> page_links; ?>

</div>

