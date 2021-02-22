<div class="mb-3" style="display: flex; justify-content: space-between;">
    <h5>Payout List</h5>
    <a href="<?= admin_url('payout'); ?>" class="btn btn-sum btn-primary">Go Back</a>
</div>
<div class="box p-2">
    <table class="table">
        <thead>
            <tr>
                <th>Sl no</th>
                <th>Name</th>
                <th>Username</th>
                <th>Mobile no</th>
                <!-- <th>Total Amount</th>
                <th>TDS @5%</th>
                <th>Admin @10%</th> -->
                <th>Net Payment</th>
                <th>Pay Status</th>
            </tr>
        </thead>
        <tbody>
            <?php
            $sl = 1;
          
            foreach ($payout as $ob) {
             
                $user = $this->db->get_where("users", array("id" => $ob->user_id))->row();
            ?>
                <tr>
                    <td><?= $sl++; ?></td>
                    <td><?= $user->first_name . ' ' . $user->last_name; ?></td>
                    <td><?= $user->username; ?></td>
                    <td><?= $user->mobile; ?></td>
                   <!--  <td>Rs <?= number_format($ob->amount, 2); ?></td>
                    <td>Rs <?= number_format($ob->amount * 0.10, 2); ?></td>
                    <td>Rs <?= number_format($ob->amount * 0.10, 2); ?></td> -->
                    <td>Rs <?= number_format($ob->amount, 2); ?></td>
                    <td><?php
                        
                            echo '<span class="btn btn-xs btn-success">PAID</span>';
                        ?></td>
                </tr>
            <?php
            }
            ?>
        </tbody>
    </table>
</div>