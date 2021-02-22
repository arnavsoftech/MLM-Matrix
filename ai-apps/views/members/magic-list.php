<h5>Auto Magic Matrix </h5>
<hr>

<div class="box">
    <div class="box-p">
        <table class="table table-bordered table-striped data-table">
            <thead>
                <tr>
                    <th>Sl No</th>
                    <th>Userinfo</th>
                    <th>Parentinfo</th>
                    <th>Amount</th>
                    <th>Join Date</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $sl = 1;
                foreach ($users as $m) {
                    if ($m->parent_id > 0) {
                        $p = $this->db->get_where('users', array('id' => $m->parent_id))->row();
                    } else {
                        $p = new stdClass();
                        $p->username = $p->first_name = $p->last_name = $p->mobile = $p->id = null;
                    }
                ?>
                    <tr>
                        <td><?= $sl++; ?></td>
                        <td>
                            <a href="<?php echo admin_url('members/details/' . $m->id); ?>">
                                <?= $m->username; ?> <br /><?= $m->first_name . ' ' . $m->last_name; ?><br /><?= $m->mobile; ?>
                            </a>
                        </td>
                        <td><a href="<?php echo admin_url('members/details/' . $p->id); ?>">
                                <?= $p->username; ?> <br /><?= $p->first_name . ' ' . $p->last_name; ?><br /><?= $p->mobile; ?>
                            </a></td>
                        <td><?= $this->User_model->MainBalance($m->id); ?></td>
                        <td><?php echo  date("Y-m-d h:i a", strtotime($m->created)); ?></td>


                    </tr>
                <?php
                }
                ?>
            </tbody>
        </table>
    </div>
</div>