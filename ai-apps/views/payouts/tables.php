<div class="mb-3" style="display: flex; justify-content: space-between;">
    <h5><?= $type; ?> Payout</h5>
    <a href="<?= admin_url('payout/generatenow/?type=' . strtolower($type)); ?>" class="btn btn-sum btn-primary">GENERATE</a>
</div>
<div class="box p-2">
    <table class="table">
        <thead>
            <tr>
                <th>Sl no</th>
                <th>Name</th>
                <th>Username</th>
                <th>Mobile no</th>
                <th>Total</th>
                <th>TDS (5%) </th>
                <th>Admin (10%) </th>
                <th>Net Payment</th>
            </tr>
        </thead>
        <tbody>
            <?php
            $sl = 1;
            foreach ($users as $user) {
                if ($user->amount == 0) continue;
            ?>
                <tr>
                    <td><?= $sl++; ?></td>
                    <td><?= $user->first_name . ' ' . $user->last_name; ?></td>
                    <td><?= $user->username; ?></td>
                    <td><?= $user->mobile; ?></td>
                    <td><?= $user->amount; ?></td>
                    <td><?= $user->amount * 0.05; ?></td>
                    <td><?= $user->amount * 0.10; ?></td>
                    <td><?= $user->amount - ($user->amount * 0.15); ?></td>
                </tr>
            <?php
            }
            ?>
        </tbody>
    </table>
</div>