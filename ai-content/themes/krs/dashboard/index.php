<style>
    .Level_box {
        width: 32%;
        border-radius: 3px;
        background-image: url('<?= theme_url() ?>/dashboard/img/oo.png');
        text-align: center;
    }

    .box {
        margin-bottom: 15px;
    }
</style>

<div class="float-right origin-class">
    <a href="<?= site_url('dashboard/pin-list'); ?>" class="btn btn-sm btn-primary">
        <i class="fa fa-plus-circle"></i>
        Add Joining</a>
    <a href="<?= site_url('dashboard/search'); ?>" class="btn btn-sm btn-warning">
        <i class="fa fa-plus-circle"></i>
        Activate Account</a>
</div>

<?= theme_option('header_block'); ?>
<h3 class="top-text">Welcome <span class="text-danger"><?= $me->first_name . ' ' . $me->last_name; ?></span> (<?= $me->username; ?>)</h3>
<hr />
<?php
if ($me->epin == '') {
?>
    <div class="bg-danger p-5 text-center rounded mb-3">
        <h3 class="text-white">You Account is not Active</h3><br />
        <br />
        <a href="<?= site_url('dashboard/activate/' . $me->id); ?>" class="btn btn-lg btn-warning">Activate Now</a>
    </div>
<?php
} elseif ($me->ac_status == 0) {
?>
    <div class="bg-info p-3 text-center rounded mb-3">
        <h4 class="text-white"><br />You must Complete your KYC.</h4><br />
        <br />
        <a href="<?= site_url('dashboard/kyc'); ?>" class="btn btn-lg btn-warning">Complete KYC</a>
    </div>
<?php
}
?>
<div class="box">
    <div class="cover-link text-center bg-warning">
        <span style="cursor: pointer;" data-copy="<?= site_url('register/?ref=' . $me->username); ?>" class="btn-copy" id="div_1" name="copy_pre"><?= site_url('register/?ref=' . $me->username); ?> &nbsp; &nbsp; &nbsp; &nbsp;Click To Copy</span>
    </div>
</div>
<?php
if (theme_option('message') != '') {
?>
    <div class="box bg-danger p-2 text-white">
        <marquee class="m-0" onmouseover="this.stop();" onmouseout="this.start();" behavior="scroll" direction="left"><?= theme_option('message'); ?></marquee>
    </div>
<?php
}
$arp = $this->db->get_where('users', array('epin' => '', 'sponsor_id' => $me->id))->result();
?>
<div>
    <div class="row">
        <div class="col-sm-7">
            <div class="row row-xs text-center text-white">
                <div class="col-sm-4">
                    <div class="box border p-3 bg-warning">
                        <div class="box-p">
                            <h6>Level Income</h6>
                            Rs <?= $level_income; ?>
                        </div>
                    </div>
                </div>
                <div class="col-sm-4">
                    <div class="box border p-3 bg-info">
                        <div class="box-p">
                            <h6>ROI Income</h6>
                            Rs <?= $roi_income; ?>
                        </div>
                    </div>
                </div>
                <div class="col-sm-4">
                    <div class="box border p-3 bg-warning">
                        <div class="box-p">
                            <h6>Direct Team</h6>
                            <?= $self_team; ?>
                        </div>
                    </div>
                </div>
                <div class="col-sm-4">
                    <div class="box border p-3 bg-info">
                        <div class="box-p">
                            <h6>Total Team</h6>
                            <?= $total_team; ?>
                        </div>
                    </div>
                </div>
                <div class="col-sm-4">
                    <div class="box border p-3 bg-warning">
                        <div class="box-p">
                            <h6>Total Income</h6>
                            Rs <?= $total_income; ?>
                        </div>
                    </div>
                </div>
                <div class="col-sm-4">
                    <div class="box border p-3 bg-info">
                        <div class="box-p">
                            <h6>Wallet Income</h6>
                            Rs <?= $wallet_income; ?>
                        </div>
                    </div>
                </div>
                <div class="col-sm-4">
                    <div class="box border p-3 bg-success">
                        <div class="box-p">
                            <h6>Shopping Wallet</h6>
                            Rs <?= ($me->epin != '') ? $me->plan_total : 0; ?>
                        </div>
                    </div>
                </div>
            </div>
            <div class="d-flex justify-content-between flex-wrap">
                <?php
                for ($i = 1; $i <= 7; $i++) {
                    $amt = $this->User_model->level_income(user_id(), $i);
                ?>
                    <div class="Level_box">
                        <h2>Level Income - <?= $i; ?> <br><span><?= $amt; ?></span></h2>
                    </div>
                <?php
                }
                ?>
            </div>
        </div>
        <div class="col-sm-5">
            <div class="name bg-white text-center">
                <?php
                $src = base_url(upload_dir('default.png'));
                if ($me->image != '') {
                    $src = base_url(upload_dir($me->image));
                }
                ?>
                <img class="img-profile img-circle mb-3" src="<?= $src; ?>" title="<?= $me->first_name; ?>">
                <h2 class="h4"><?= $me->first_name . ' ' . $me->last_name; ?></h2>
            </div>
            <table class="table table-striped">
                <tbody>
                    <tr>
                        <td>Mobile No</td>
                        <td><?= $me->mobile; ?></td>
                    </tr>
                    <tr>
                        <td>My Total Team</td>
                        <td><?= $total_team; ?></td>
                    </tr>
                    <tr>
                        <td>My Active Member</td>
                        <td><?= $active_members; ?></td>
                    </tr>
                    <tr>
                        <td>Date of Joining</td>
                        <td><?= date('jS M, Y', strtotime($me->join_date)) ?></td>
                    </tr>
                    <tr>
                        <td>KYC Status</td>
                        <td><?= ($me->kyc_status) ? '<span class="badge badge-success">Active</span>' : '<span class="badge badge-danger">Not yet done</span>'; ?></td>
                    </tr>
                    <tr>
                        <td>Package Amount</td>
                        <td>Rs <?= $me->plan_total; ?></td>
                    </tr>
                    <tr>
                        <td>Address</td>
                        <td><?= $me->address; ?></td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</div>


</div>


<div class="box">
    <div class="box-p">
        <table class="table">
            <thead>
                <tr>
                    <th>Sl No</th>
                    <th>Name</th>
                    <th>Mobile no</th>
                    <th>Username</th>
                    <th>Joining Date</th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
                <?php
                if (is_array($arp) && count($arp) > 0) {
                    $sl = 1;
                    foreach ($arp as $ob) {
                ?>
                        <tr>
                            <td><?= $sl++; ?></td>
                            <td><?= $ob->first_name . ' ' . $ob->last_name; ?></td>
                            <td><?= $ob->mobile; ?></td>
                            <td><?= $ob->username; ?></td>
                            <td><?= date('d-M-Y', strtotime($ob->join_date)); ?></td>
                            <td>
                                <a class="btn btn-sm btn-outline-light" href="<?= site_url('dashboard/activate/' . $ob->id); ?>">Activate Now</a>
                            </td>
                        </tr>
                    <?php
                    }
                } else {
                    ?>
                    <tr>
                        <td colspan="6">
                            <div class="text-center text-dark">NO ANY PENDING CHILD SPONSER</div>
                        </td>
                    </tr>
                <?php
                }
                ?>
            </tbody>
        </table>
    </div>
</div>