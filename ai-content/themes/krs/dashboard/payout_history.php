<h5>Payout history</h5>
<hr />

<div class="row">
    
    <div class="col-sm-12">
        <div class="box">
            <div class="box-p">

                <div class="table-responsive">
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>Sl No</th>
                            <th>Date</th>
                            <th>Amount</th>
                            <th>Txnid</th>
                            <th>Admin+TDS(10%)</th>
                            <th>Rebirth(10%)</th>
                            <th>Net Payable</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $sl = 1;
                        if (is_array($arorders) && count($arorders) > 0) {
                            foreach ($arorders as $ob) {
                        ?>
                                <tr>
                                    <td><?= $sl++; ?></td>
                                    <td><?= date('d-M-Y', strtotime($ob->created)); ?></td>
                                   
                                   <td><?= $ob->amount; ?></td>
                                   <td><?= $ob->rebirth; ?></td>
                                   <td><?= ($ob->amount*10)/100; ?></td>
                                   <td><?= ($ob->amount*10)/100; ?></td>
                                   <td><?= $ob->net_pay; ?></td>
                                </tr>
                        <?php
                            }
                        }
                        ?>
                    </tbody>
                </table>
            </div>
        </div>
        </div>
    </div>
</div>

