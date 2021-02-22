<h5>Business Points</h5>
<hr>
<div class="box">
    <div class="box-p">
        <table class="table data-table">
            <thead>
                <tr>
                    <th>Sl No</th>
                    <th>Date</th>
                    <th>Notes</th>
                    <th>BVP</th>
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
                            <td><?= ($ob->cr_dr == 'cr') ? '<span class="text-success">' : '<span class="text-danger">'; ?><?= $ob->points; ?></span></td>
                        </tr>
                <?php
                    }
                }
                ?>
            </tbody>
        </table>
    </div>
</div>