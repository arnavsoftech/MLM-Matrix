<h5>Recharge Users List </h5>
<hr>

<div class="box">
    <div class="box-p">
        <table class="table table-bordered table-striped data-table">
            <thead>
                <tr>
                    <th>Sl No</th>
                    <th>Userinfo</th>
                    <th>Balance Recharge</th>
                    <td>Recharge Report</td>
                    <td>Last Recharge</td>
                    <td>Next Recharge</td>
                    <th>Recharge</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $sl = 1;
                foreach ($users as $ob) {
                    $p = $this->db->get_where('users', array('id' => $ob->user_id))->row();
                ?>
                    <tr>
                        <td><?= $sl++; ?></td>
                        <td>
                            <a href="<?php echo admin_url('members/details/' . $p->id); ?>">
                                <?= $p->username; ?> <br /><?= $p->first_name . ' ' . $p->last_name; ?><br /><?= $p->mobile; ?>
                            </a>
                        </td>
                        <td class="text-center"><?= $ob->balance_recharge; ?></td>
                        <td><?= $ob->recharge_report; ?></td>
                        <td class="text-center"><?= date("d M Y", strtotime($ob->last_paid)); ?></td>
                        <td class="text-center"><?= date("d M Y", strtotime($ob->last_paid . ' +1 month')); ?></td>

                        <td class="text-center">
                            <?php
                            if ($ob->status == 1) {
                            ?>
                                <a href="<?= admin_url('members/rechargeoff/' . $ob->id); ?>" class="btn btn-xs btn-success">ON</a>
                            <?php
                            } else {
                            ?>
                                <a href="<?= admin_url('members/rechargeon/' . $ob->id); ?>" class="btn btn-xs btn-danger">OFF</a>
                            <?php
                            }
                            ?>

                    </tr>
                <?php
                }
                ?>
            </tbody>
        </table>
    </div>
</div>