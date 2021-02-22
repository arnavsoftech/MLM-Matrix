<?php
$level = isset($_GET['level']) ? intval($_GET['level']) : 1;
$ids = $this->User_model->getMatrixDownlineIds(user_id(), $level, false);
?>

<div class="row">
    <div class="col-lg-12">
        <div class="d-flex mb-3 p-2 border rounded bg-white justify-content-center">
            <?php
            for ($i = 1; $i <= 7; $i++) {
            ?>
                <a href="<?= site_url('dashboard/member_level/?level=' . $i); ?>" class="btn <?= $level == $i ? 'btn-success' : 'btn-info'; ?>">Level <?= $i; ?></a> &nbsp;
            <?php
            }
            ?>
        </div>
    </div>
</div>
<div class="bg-white mb-3 p-3">
    <div id="result">
        <table class="table mb-0">
            <thead>
                <tr>
                    <th>Sl No</th>
                    <th>Name</th>
                    <th>Username</th>
                    <th>Mobile no</th>
                    <th>Join Date</th>
                    <th>KYC Status</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $sl = 1;
                foreach ($ids as $id) {
                    $u = $this->User_model->getRow($id);
                ?>
                    <tr>
                        <td><?= $sl++; ?></td>
                        <td><?= $u->first_name . ' ' . $u->last_name; ?></td>
                        <td><?= $u->username; ?></td>
                        <td><?= $u->mobile; ?></td>
                        <td><?= date('jS M, Y H:i A', strtotime($u->join_date)); ?></td>
                        <td><?= ($u->epin != '') ? '<span class="badge badge-success">Completed</span>' : '<span class="badge badge-danger">KYC Pending</span>'; ?></td>
                    </tr>
                <?php
                }
                ?>
            </tbody>
        </table>
    </div>
</div>