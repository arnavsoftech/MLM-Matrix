<h5><?= $title; ?></h5>
<hr>
<div class="box">
    <div class="box-p table-responsive">
        <table class="table data-table">
            <thead>
                <tr>
                    <th>Sl No</th>
                    <th>Date</th>
                    <th>Notes</th>
                    <th>Amount</th>
                    <th>TXN</th>
                </tr>
            </thead>
            <tbody>
                <?php
                if (is_array($arrdata) && count($arrdata) > 0) {
                    $sl = 1;
                    foreach ($arrdata as $ob) {
                ?>
                        <tr>
                            <td><?= $sl++; ?></td>
                            <td><?= date('jS M, Y', strtotime($ob->created)); ?></td>
                            <td><?= ucfirst($ob->notes); ?></td>
                            <td><?= ($ob->cr_dr == 'cr') ? '<span class="text-success">' : '<span class="text-danger">'; ?><?= $ob->amount; ?></span></td>
                            <td><?= $ob->ref_id; ?></td>
                        </tr>
                <?php
                    }
                }
                ?>
            </tbody>
        </table>
    </div>
</div>