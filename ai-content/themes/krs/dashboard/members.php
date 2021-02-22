<h5>Members List</h5>
<hr>
<div class="box">
    <div class="box-p table-responsive">
        <table class="table data-table">
            <thead>
                <tr>
                    <th>Sl No</th>
                    <th>Userinfo</th>
                    <th>Sponsorid</th>
                    <th>Joining Date</th>
                    <th>Downline</th>

                    <th>Total Income</th>
                </tr>
            </thead>
            <tbody>
                <?php
                if (is_array($members) && count($members) > 0) {
                    $sl = 1;
                    foreach ($members as $ob) {
                        $dl = $this->db->get_where('users', array('sponsor_id' => $ob->id))->num_rows();
                        $ti = 0;
                ?>
                        <tr>
                            <td><?= $sl++; ?></td>
                            <td><?= $ob->first_name . '  ' . $ob->last_name . '<br />' . $ob->username . '<br />' . $ob->mobile; ?></td>
                            <td><?= id2userid($ob->sponsor_id); ?></td>
                            <td><?= date('jS M, Y', strtotime($ob->join_date)); ?>
                                <br />
                                <?php
                                if ($ob->ac_status == 1) {
                                    echo '<span class="badge badge-success">Active</span>';
                                } else {
                                    echo '<span class="badge badge-danger">Pending</span>';
                                }
                                ?>
                            </td>
                            <td><?= $dl; ?></td>

                            <td> <i class="fa fa-inr"></i> <?= $ti; ?> </td>
                        </tr>
                <?php
                    }
                }
                ?>
            </tbody>
        </table>
    </div>
</div>