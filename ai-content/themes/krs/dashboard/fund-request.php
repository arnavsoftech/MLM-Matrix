<h5>Pin Request</h5>
<hr />

<div class="row">
    <div class="col-sm-5">
        <div class="box">
            <div class="box-p" ng-controller="PinCtrl">
                <form enctype="multipart/form-data" class="form-horizontal" method="POST" action="<?= site_url('dashboard/fund-request'); ?>">
                    <div class="form-group row">
                        <label class="col-sm-4 control-label">Request Amount <span class="required">*</span> </label>
                        <div class="col-md-8">
                            <input class="form-control" type="number" placeholder="0.00" name="amount">
                        </div>
                    </div>

                    <div class="form-group row">
                        <label class="col-sm-4 control-label">Transaction No <span class="required">*</span></label>
                        <div class="col-sm-7">
                            <input class="form-control" type="text" placeholder="Txn no" name="txn_no">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-sm-4 control-label">Screenshot</label>
                        <div class="col-sm-7">
                            <input name="screenshot" type="file">
                            <small>Only JPG/JPEG/PNG Supported</small>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-sm-4 control-label">Extra Notes</label>
                        <div class="col-sm-7">
                            <input class="form-control" type="text" placeholder="Write small optional notes" name="notes">
                        </div>
                    </div>

                    <div style="border: dashed 1px #DDD; font-size: 12px; background: #EEE; padding: 10px; border-radius: 3px; margin-bottom: 20px;">
                        Bank Details to which Payment should be made !!
                    </div>

                    <div class="form-group row">
                        <div class="col-sm-4"></div>
                        <div class="col-md-8">
                            <button class="btn btn-success" type="submit" name="save">Submit</button>
                            <button type="reset" class="btn btn-danger">Cancel</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <div class="col-sm-7">
        <div class="box">
            <div class="box-p">
                <table class="table">
                    <thead>
                        <tr>
                            <th>Sl No</th>
                            <th>Date</th>
                            <th>Amout</th>
                            <th>Status</th>
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
                                    <td> <i class="fa fa-inr"></i> <?= $ob->amount; ?></td>
                                    <td><?php
                                        if ($ob->status == 0) {
                                            echo '<span class="badge badge-info">Pending</span>';
                                        } else if ($ob->status == 1) {
                                            echo '<span class="badge badge-success">Approved</span>';
                                        } else if ($ob->status == 2) {
                                            echo '<span class="badge badge-danger">Rejected</span>';
                                        }
                                        ?>
                                    </td>
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

<script>
    var app = angular.module('OriginIT', []);
    app.controller('PinCtrl', function($scope) {

    });

    $(document).ready(() => {
        $('#pinqty').keyup(() => {
            let v = $('#pinqty').val();
            if (v == '') {
                v = 0;
            }
            let s = parseInt(v) * 1299;
            $('#amtid').val(s);
        });
    });
</script>