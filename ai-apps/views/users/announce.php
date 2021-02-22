<div class="page-header">

    <div class="float-right">

        <a class="btn btn-sm btn-primary" href="<?php echo admin_url('dashboard/announcement'); ?>"><i class="fa fa-plus-circle"></i> Add Announcement</a>

    </div>

    <h5>Announcement</h5>

</div>

<div class="box box-p">

    <table class="table data-table table-striped table-search1" id="post-index">

        <thead>

            <tr>

                <th>#ID</th>

                <th>Title</th>



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

                    <td><?= $row->title; ?></td>





                    <td>

                        <div class="btn-group pull-right">



                            <a class="btn btn-xs btn-secondary" href="<?php echo admin_url('dashboard/announcement/' . $row->id); ?>"><i class="fa fa-pencil"></i></a>

                            <a class="btn btn-xs btn-danger" onclick="return confirm('Are Your Sure to delete?');;" href="<?php echo admin_url('dashboard/delete/' . $row->id); ?>"><i class="fa fa-trash"></i></a>

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

    <?php echo $this->page_links; ?>

</div>