<div class="d-flex justify-content-between">
    <h4>Member Details: <?= $user->first_name . ' - ' . $user->username; ?></h4>
    <div>
        <!--
        <a href="<?= admin_url('members/add-purchase/' . $user->id); ?>" class="btn btn-primary"> <i class="fa fa-plus-circle"></i> ADD PURCHASE</a>
        <a href="<?= admin_url('members/add-magic/' . $user->id); ?>" class="btn btn-warning"> <i class="fa fa-plus-circle"></i> Auto Magic</a>
        -->
    </div>
</div>
<div class="d-flex text-muted justify-content-between">
    <div>Mobile: <?= $user->mobile; ?></div>
    <div>Joining: <?= date('d M Y', strtotime($user->join_date)); ?></div>
</div>

<hr>
<div class="row text-white text-center mb-4">
    <div class="col-sm-3">
        <div class="p-3 bg-info">
            Direct Joining: <?= count($members); ?>
        </div>
    </div>
    <div class="col-sm-3">
        <div class="p-3 bg-success">
            Total Joining: <?= $downline; ?>
        </div>
    </div>
    <div class="col-sm-3">
        <div class="p-3 bg-warning">
            Wallet Income: <?= $current_income; ?>
        </div>
    </div>
    <div class="col-sm-3">
        <div class="p-3 bg-primary">
            Total Income: <?= $total_income; ?>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-sm-6">
        <div class="box">
            <div class="box-header">
                <b class="box-title">Direct Members</b>
            </div>
            <table class="table">
                <thead>
                    <tr>
                        <th>Sl</th>
                        <th>Name</th>
                        <th>Username</th>
                        <th>Mobile no</th>
                        <th>Joining</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $sl = 1;
                    foreach ($members as $m) {
                    ?>
                        <tr>
                            <td><?= $sl++; ?></td>
                            <td><?= $m->first_name . ' ' . $m->last_name; ?></td>
                            <td><?= $m->username; ?></td>
                            <td><?= $m->mobile; ?></td>
                            <td><?= $m->join_date; ?></td>
                        </tr>
                    <?php
                    }
                    ?>
                </tbody>
            </table>
        </div>
    </div>
    <div class="col-sm-6">
        <div class="box">
            <div class="box-header">
                <b class="box-title">Order Purchase</b>
            </div>
            <table class="table">
                <thead>
                    <tr>
                        <th>Date</th>
                        <th>Purchase Order</th>
                        <th>Point Value</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    foreach ($purchase as $ob) {
                    ?>
                        <tr>
                            <td><?= date('d M Y', strtotime($ob->created)); ?></td>
                            <td><?= $ob->amount; ?></td>
                            <td><?= $ob->pv; ?></td>
                        </tr>
                    <?php
                    }
                    ?>
                </tbody>
            </table>
        </div>
    </div>
</div>
<?php // print_r($user);
?>
<h5>KYC Details</h5>
<div class="row">
    <div class="col-sm-12">
        <div class="box">
            <table class="table">
                <tr>
                    <th>PAN</th>
                    <th>Aadhar No</th>
                    <th>Aadhar Front</th>
                    <th>Aadhar Back</th>
                    <th>Bank Details</th>
                    <th>Nominee</th>
                    <th>Relation</th>
                </tr>
                <tr>
                    <td><?php show($user->pan); ?></td>
                    <td><?= $user->adhar_no; ?></td>
                    <td><?php show($user->aadharf); ?></td>
                    <td><?php show($user->aadharb); ?></td>
                    <td><?php
                        if ($user->bank_info != '') {
                            foreach (json_decode($user->bank_info) as $key => $val) {
                                echo ucwords(str_replace('_', ' ', $key)) . ': ' . $val . '<br />';
                            }
                        }
                        ?>
                    </td>
                    <td><?= $user->nominee; ?></td>
                    <td><?= $user->relation; ?></td>
                </tr>
            </table>
        </div>
    </div>
</div>

<?php

function show($name)
{
    if ($name != '') {
        echo '<img src="' . upload_dir($name) . '" width="100" />';
    } else {
        echo 'Not uploaded';
    }
}
