<div class="page-header">
    <h3>Fund Request </h3>
</div>
<table class="table table-bordered table-striped data-table">
    <thead>
        <tr>
            <th>Sl No</th>
            <th>Username</th>
            <th>Request Amount</th>
            <th>TXN No</th>
            <th>Notes</th>
            <th>Screenshot</th>
            <th>Request Status</th>
            <th>Date</th>
            <th>Action</th>
        </tr>
    </thead>
    <tbody>

        <?php
        $sl = 1;
        foreach ($request as $m) {
            $u = $this->User_model->getUserById($m->user_id);
        ?>
            <tr>
                <td><?= $sl++; ?></td>
                <td><?php echo  id2userid($m->user_id); ?></td>
                <td><?php echo $m->amount; ?></td>
                <td><?php echo $m->txn_no; ?></td>
                <td><?php echo $m->notes; ?></td>
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
                <td><?= date("d M, Y h:i A", strtotime($m->created)); ?></td>
                <td>
                    <?php
                    if ($m->status == 0) {
                    ?>
                        <div class="pull-right btn-group">
                            <a href="<?= admin_url('payments/approved/' . $m->id) ?>" class="approve btn btn-xs btn-success"> <span class="label label-success">Approved </span></a>
                            <a href="<?= admin_url('payments/decline/' . $m->id) ?>" class="decline btn btn-xs btn-danger"><span class="label label-danger">Decline</span></a>
                        </div>
                    <?php } ?>
                </td>
            </tr>
        <?php
        }
        ?>
    </tbody>
</table>