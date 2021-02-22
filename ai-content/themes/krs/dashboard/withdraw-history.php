<div class="row">
    <div class="col-sm-12">
        <h5>Money Withdraw History</h5>
        <hr>
        <div class="box box-p">
            <table class="table">
                <thead>
                    <tr>
                        <th>Sl No</th>
                        <th>Amount</th>
                        <th>Status</th>
                        <th>Notes</th>
                        <th>Last update</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $sl = 1;
                    foreach ($reqlist as $ob) {
                    ?>
                        <tr>
                            <td><?= $sl++; ?></td>
                            <td><?= $ob->amount; ?></td>
                            <td><?php
                                if ($ob->status == 0) echo "Pending";
                                if ($ob->status == 1) echo "Approved";
                                if ($ob->status == 2) echo "Rejected";
                                if ($ob->status == 3) echo "Cancelled";
                                ?></td>
                            <td> <?php
                                    if ($ob->comments != '') echo '<span class="badge badge-warning">' . $ob->comments . '</span>';
                                    ?></td>
                            <td><?= date('jS M, Y H:i', strtotime($ob->updated)); ?></td>
                        </tr>
                    <?php
                    }
                    ?>
                </tbody>
            </table>
        </div>
    </div>
</div>