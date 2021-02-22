<div class="page-header">

    <a class="btn pull-right btn-sm btn-primary" href="<?php echo admin_url('categories/add_video_cat'); ?>"><i					class="fa fa-plus-circle"></i> Add Video Category</a>

    <h2>Video Category </h2>

</div>

<div class="box">

    <div class="box-p">

        <table class="table table-bordered table-striped">

            <thead>

                <tr>

                    <th>#ID</th>

                    <th>Name</th>

                   

                    

                    <th></th>

                </tr>

            </thead>

            <tbody>

                <?php
 $i=1;
                if (is_array($categories) && count($categories) > 0) {

                    foreach ($categories as $cat) {

                        $ob = new AI_Category($cat -> id);

                        ?>

                        <tr>

                            <td><?= $i++; ?></td>

                            <td><?= $cat -> name; ?></td>

                           
                           

                            <td>

                                <div class="btn-group pull-right">

                                    <a href="<?= admin_url('categories/add_video_cat/' . $cat -> id); ?>" title="Edit"                                   class="btn btn-xs btn-info"><i class="fa fa-pencil"></i> </a>

                                   

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