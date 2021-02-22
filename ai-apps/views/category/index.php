<a class="btn pull-right btn-sm btn-primary" href="<?php echo admin_url('categories/add'); ?>"><i class="fa fa-plus-circle"></i> Add Category</a>
<h4>Categories </h4>
<hr>
<div class="box">
    <div class="box-p">
        <table class="table table-bordered table-striped">
            <thead>
                <tr>
                    <th>#ID</th>
                    <th>Name</th>
                    <th>Parent</th>
                    <th>Sequence</th>
                    <th>Status</th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
                <?php
                if (is_array($categories) && count($categories) > 0) {
                    $sl = 1;
                    foreach ($categories as $cat) {
                        $ob = new AI_Category($cat->id);
                        ?>
                        <tr>
                            <td><?= $sl++; ?></td>
                            <td><a href="<?= $ob->permalink(); ?>" target="_blank"><?= $cat->name; ?></a></td>
                            <td>
                                <?php
                                        if ($cat->parent_id == 0)
                                            echo 'Top Category';
                                        else {
                                            $tc = $this->Category_model->getRow($cat->parent_id);
                                            echo $tc->name;
                                        }
                                        ?>
                            </td>
                            <td><?= $cat->sequence; ?></td>
                            <td>
                                <?php if ($cat->status == 1) { ?>
                                    <a href="<?= admin_url('categories/deactivate/' . $cat->id, TRUE); ?>" class="badge badge-success">Active</a>
                                <?php } else { ?>
                                    <a href="<?= admin_url('categories/activate/' . $cat->id, TRUE); ?>" class="badge badge-danger">Deactive</a>
                                <?php } ?>
                            </td>
                            <td>
                                <div class="btn-group pull-right">
                                    <a href="<?= admin_url('categories/add/' . $cat->id); ?>" title="Edit" class="btn btn-xs btn-info"><i class="fa fa-pencil"></i> </a>
                                    <a href="<?= admin_url('categories/delete/' . $cat->id); ?>" title="Delete" class="btn btn-xs btn-danger delete"><i class="fa fa-trash"></i> </a>
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
    <?= $this->page_links; ?>
</div>