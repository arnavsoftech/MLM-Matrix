<div class="page-header">
    <h3>Epin Request </h3>
</div>
<table class="table table-bordered table-striped data-table">
    <thead>
        <tr>
            <th>Sl No</th>
            <th>Username</th>
            <th>Package</th>
            <th>PIN Quantity</th>
            <th>TXN No</th>
            <th>Screenshot</th>
            <th>Request Status</th>
            <th>Action</th>
        </tr>
    </thead>
    <tbody>
        <?php
        $packages = config_item('package');
        $sl = 1;
        foreach ($request as $m) {
            $u = $this->User_model->getUserById($m->user_id);
        ?>
            <tr>
                <td><?= $sl++; ?></td>
                <td><?= id2userid($m->user_id); ?></td>
                <td><?= $packages[$m->pintype]; ?></td>
                <td><?php echo $m->pin_qty; ?></td>
                <td><?php echo $m->txn_no; ?></td>
                <td>
                    <?php
                    if ($m->screenshot != '') {
                    ?>
                        <img src="<?= base_url(upload_dir($m->screenshot)); ?>" width="100" />
                    <?php
                    }
                    ?>
                </td>
                <td>
                    <?php
                    if ($m->status == 0) {
                        echo '<span class="badge badge-info">Active</span>';
                    } else if ($m->status == 2) {
                        echo '<span class="badge badge-danger">Decline</a>';
                    } else if ($m->status == 1) {
                        echo '<span class="badge badge-success">Approved</a>';
                    }
                    ?>
                </td>
                <td>
                    <?php
                    if ($m->status == 0) {
                    ?>
                        <div class="pull-right btn-group">
                            <a href="<?= admin_url('epin/approved/' . $m->id) ?>" class="approve btn btn-xs btn-success"> <span class="label label-success">Approved </span></a>
                            <a href="<?= admin_url('epin/decline/' . $m->id) ?>" class="decline btn btn-xs btn-danger"><span class="label label-danger">Decline</span></a>
                        </div>
                    <?php } ?>
                </td>
            </tr>
        <?php
        }
        ?>
    </tbody>
</table>