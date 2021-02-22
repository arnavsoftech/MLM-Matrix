<div class="row">
    <div class="col-sm-6 col-md-3">
        <div class="box text-center">
            <div class="box-header">
                <b class="box-title">NEW JOINING</b>
            </div>
            <div class="box-p">
                <?= $users; ?>
            </div>
        </div>
    </div>

    <div class="col-sm-6 col-md-3">
        <div class="box text-center">
            <div class="box-header">
                <b class="box-title">TOTAL MEMBERS</b>
            </div>
            <div class="box-p">
                <?= $total; ?>
            </div>
        </div>
    </div>

    <div class="col-sm-6 col-md-3">
        <div class="box text-center">
            <div class="box-header">
                <b class="box-title">FRANCHISE</b>
            </div>
            <div class="box-p">
                <?= $franchise; ?>
            </div>
        </div>
    </div>

    <div class="col-sm-6 col-md-3">
        <div class="box text-center">
            <div class="box-header">
                <b class="box-title">NEW PIN REQUEST</b>
            </div>
            <div class="box-p">
                <?= $pin; ?>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-sm-6 col-md-3">
        <div class="box text-center">
            <div class="box-header">
                <b class="box-title">NEW ORDERS</b>
            </div>
            <div class="box-p">
                0
            </div>
        </div>
    </div>

    <div class="col-sm-6 col-md-3">
        <div class="box text-center">
            <div class="box-header">
                <b class="box-title">TOTAL PRODUCTS</b>
            </div>
            <div class="box-p">
                <?= $this->db->select('count(*) as c')->get('products')->row()->c; ?>
            </div>
        </div>
    </div>

    <div class="col-sm-6 col-md-3">
        <div class="box text-center">
            <div class="box-header">
                <b class="box-title">LOW INVENTARY</b>
            </div>
            <div class="box-p">
                0
            </div>
        </div>
    </div>

    <div class="col-sm-6 col-md-3">
        <div class="box text-center">
            <div class="box-header">
                <b class="box-title">Royalty Income</b>
            </div>
            <div class="box-p">
                <?php
                $total = $this->db->select('count(*) as c')->get_where("users", array('epin !=' => ''))->row()->c;
                $business = $total * 1000 * 0.05;
                ?>
                <i class="fa fa-inr"></i> <?= $business; ?>
            </div>
        </div>
    </div>
</div>
<h5>In-active Accounts</h5>
<?php
$ld = date("Y-m-d", strtotime("-7 days"));
$list = $this->db->order_by('id', 'ASC')->get_where('users', array('epin' => '', 'join_date <' => $ld, 'status' => 1))->result();
?>
<div class="box p-2">
    <table class="table">
        <thead>
            <tr>
                <th>Sl No</th>
                <th>Name</th>
                <th>Username</th>
                <th>Phone no</th>
                <th>Sponsor Details</th>
                <th>Sponsor Details</th>
                <th>Joining Date</th>
                <th></th>
            </tr>
        </thead>
        <tbody>
            <?php
            $sl = 1;
            foreach ($list as $ob) {
                $sp = $this->db->get_where("users", array('id' => $ob->sponsor_id))->row();
            ?>
                <tr>
                    <td><?= $sl++; ?></td>
                    <td>
                        <a href="<?= admin_url('members/details/' . $ob->id); ?>">
                            <?= $ob->first_name; ?>
                        </a>
                    </td>
                    <td><?= $ob->username; ?></td>
                    <td><?= $ob->mobile; ?></td>
                    <td><?= id2userid($ob->sponsor_id); ?></td>
                    <td><?= $sp->first_name; ?> - <?= $sp->mobile; ?></td>
                    <td><?= date('Y-m-d', strtotime($ob->join_date)); ?></td>
                    <td>
                        <a href="<?= admin_url('dashboard/deactive/' . $ob->id); ?>" class="btn btn-xs btn-danger">Deactive</a>
                    </td>
                </tr>
            <?php
            }
            ?>
        </tbody>
    </table>
</div>