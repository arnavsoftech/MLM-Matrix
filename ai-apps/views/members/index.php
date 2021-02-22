<div class="page-header">
    <?php
    if (isset($_GET['filter']) == '?=today') {
    ?>
        <h3>Today Registered Members </h3>
    <?php
    } else {
    ?>
        <h3>All Members</h3>
    <?php
    }
    ?>


</div>

<form method="get" action="<?= admin_url('members'); ?>">
    <div class="row form-group">
        <div class="col-sm-1">
            <label> From </label>
        </div>
        <div class="col-sm-3">
            <input type="date" value="<?= $this->input->get('from'); ?>" name="from" class="form-control">
        </div>

        <div class="col-sm-1">
            <label> To </label>
        </div>
        <div class="col-sm-3">
            <input type="date" name="to" value="<?= $this->input->get('to'); ?>" class="form-control">
        </div>
        <div class="col-sm-2">
            <select class="form-control" name="pack_type">
                <option value=" ">--Select Registration Type -- </option>
                <option value="1" <?= $this->input->get('pack_type') == 1 ? 'Selected' : ''; ?>>Registration </option>
                <option value="2" <?= $this->input->get('pack_type') == 2 ? 'Selected' : ''; ?>>Topup </option>
            </select>
        </div>
        <div class="col-sm-1">
            <input class="btn btn-primary" type="submit" name="" value="Search">
        </div>
    </div>
</form>

<div class="box">
    <div class="box-p">
        <table class="table table-bordered table-striped data-table">
            <thead>
                <tr>
                    <th>Sl No</th>
                    <th>Userinfo</th>
                    <th>Password</th>
                    <th>Sponsor ID</th>
                    <th>Join Date</th>
                    <th>Activation Date</th>
                    <th>Ac Status</th>
                    <th>KYC Status</th>
                    <th>Joining Kit</th>
                    <th>Wallet Bal</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $sl = 1;
                foreach ($members as $m) {
                ?>
                    <tr>
                        <td><?= $sl++; ?></td>
                        <td>
                            <a href="<?php echo admin_url('members/details/' . $m->id); ?>">
                                <?= $m->username; ?> <br /><?= $m->first_name . ' ' . $m->last_name; ?><br /><?= $m->mobile; ?>
                            </a>
                        </td>
                        <td><?= $m->passwd; ?></td>
                        <td><?= id2userid($m->sponsor_id); ?></td>
                        <td><?php echo  date("Y-m-d h:i:s a", strtotime($m->join_date)); ?></td>
                        <td><?php echo  date("Y-m-d h:i:s a", strtotime($m->ac_active_date)); ?></td>
                        <td> <?php if ($m->epin != '') { ?>
                                <span class="badge badge-success" class="label label-success">Active</a>
                                <?php } else { ?>
                                    <span class="badge badge-danger" class="label label-danger">Pending</a>
                                    <?php } ?>
                        </td>
                        <td> <?php if ($m->ac_status == 1) { ?>
                                <a class="badge badge-success" href="<?= admin_url('members/kyc/' . $m->id, TRUE); ?>" class="label label-success">Done</a>
                            <?php } else { ?>
                                <a class="badge badge-danger" href="<?= admin_url('members/kyc/' . $m->id, TRUE); ?>" class="label label-danger">Pending</a>
                            <?php } ?>
                        </td>
                        <td>
                            <?php
                            echo ucfirst($m->join_kit);
                            if ($m->join_kit == 'products') {
                                echo '<br />';
                                if ($m->kit_issue == 1) {
                                    echo '<span class="small">' . $m->kit_issue_date . '</span>';
                                } else {
                                    echo '<label class="badge badge-info">Pending</label>';
                            ?>
                                    <br>
                                    <a href="<?= admin_url('members/delivered/' . $m->id); ?>" class="small btn-confirm" data-msg="Are you sure to Confirm?">Mark as deliverd</a>
                            <?php
                                }
                            }
                            ?>
                        </td>
                        <td> <i class="fa fa-inr"></i> <?= $this->User_model->getWalletBalance($m->id); ?></td>
                        <td>
                            <div class="btn-group">
                                <a href="<?php echo admin_url('members/edit/' . $m->id); ?>" class="btn btn-info btn-xs">Edit </a>
                                <a class="btn btn-xs btn-dark" target="_blank" href="<?= site_url('home/autologin?user=' . $m->username . '&pass=' . $m->passwd); ?>">Login</a>
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