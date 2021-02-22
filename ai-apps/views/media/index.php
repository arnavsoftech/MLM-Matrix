<div class="page-header">
    <a href="<?php echo admin_url('media/add'); ?>" class="btn btn-sm btn-primary pull-right"><i class="fa fa-plus-circle"></i> Upload New</a>
    <h4>Media Manager </h4>

</div>
<div class="box box-p">
    <table class="table table-bordered table-striped">
        <thead>
            <tr>
                <th>Thumbnail</th>
                <th>Name</th>
                <th>Url</th>
                <th></th>
            </tr>
        </thead>
        <tbody>
            <?php
            foreach ($medias as $row) {
                ?>
                <tr>
                    <td align="center">
                        <a href="<?= base_url(upload_dir($row -> file_name)); ?>" target="_blank">
                            <?php if ($row -> file_type == "image/jpeg" || $row -> file_type == "image/png" || $row -> file_type == "image/gif" || $row -> file_type == "image/jpg") { ?>
                                <img src="<?= base_url(upload_dir($row -> file_name)); ?>" width="50">

                            <?php } else if ($row -> file_type == 'application/msword') { ?>

                                <img src="<?php echo base_url(); ?>/img/word-icon.jpg" width="50">

                            <?php } else if ($row -> file_type == 'application/pdf') { ?>

                                <img src="<?php echo base_url(); ?>/img/pdf-icon.jpg" width="50">

                            <?php } else if ($row -> file_type == 'application/octet-st') { ?>

                                <img src="<?php echo base_url(); ?>/img/zip-icon.jpg" width="50">

                                <?php
                            } else {

                                echo $row -> file_type;
                            }
                            ?>

                        </a>

                    </td>
                    <td><?= $row -> img_title; ?></td>

                    <td><?= base_url(upload_dir($row -> file_name)); ?></td>

                    <td align="center">

                        <div class="pull-right btn-group">

                            <?php if ($row -> file_type == "image/jpeg") { ?>

                                <a href="<?= admin_url('media/edit/' . $row -> id); ?>" title="Edit" class="btn btn-sm btn-secondary"><i class="fa fa-pencil"></i> </a>

                            <?php } ?>

                            <a href="<?= admin_url('media/delete/' . $row -> id); ?>" title="Delete" class="btn btn-danger btn-sm delete"><i class="fa fa-trash"></i> </a>

                        </div>

                    </td>

                </tr>

                <?php
            }
            ?>

        </tbody>

    </table>
</div>
<div class="clearfix">
    <?php echo $this -> page_links; ?>
</div>

