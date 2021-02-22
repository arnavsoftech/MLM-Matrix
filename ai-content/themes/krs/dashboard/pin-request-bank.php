<h5>Pin Request</h5>
<hr />
<div class="alert alert-danger d-flex justify-content-between align-items-center flex-row">
    <span>Generate PIN from Balance</span>
    <a href="<?= site_url('dashboard/pin-request-balance') ?>" class="btn btn-sm btn-primary">Click here</a>
</div>
<div class="row">
    <div class="col-sm-5">
        <div class="box">
            <div class="box-p" ng-controller="PinCtrl">
                <form enctype="multipart/form-data" class="form-horizontal" method="POST" action="<?= site_url('dashboard/pin-request-bank'); ?>">
                    <div class="form-group row">
                        <label class="col-sm-4 control-label">Package <span class="required">*</span> </label>
                        <div class="col-md-8">
                            <?php
                            echo form_dropdown('pintype', config_item('package'), '', 'class="form-control" id="pintype"');
                            ?>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-sm-4 control-label">Pin Quantity <span class="required">*</span> </label>
                        <div class="col-md-8">
                            <input class="form-control" id="pinqty" type="text" placeholder="Pin Quantity" name="pin_qty">
                        </div>
                    </div>

                    <div class="form-group row">
                        <label class="col-sm-4 control-label">Transaction No <span class="required">*</span></label>
                        <div class="col-sm-7">
                            <input class="form-control" type="text" placeholder="Txn no" name="txn_no">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-sm-4 control-label">Amount <span class="required">*</span></label>
                        <div class="col-sm-7">
                            <input class="form-control" id="amtid" readonly type="text" placeholder="0.00">
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
                            <button class="btn btn-success" type="submit" name="save">Send</button>
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
                            <th>Qty</th>
                            <th>Package</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $package = config_item('package');
                        $sl = 1;
                        if (is_array($arorders) && count($arorders) > 0) {
                            foreach ($arorders as $ob) {
                        ?>
                                <tr>
                                    <td><?= $sl++; ?></td>
                                    <td><?= date('d-M-Y', strtotime($ob->created)); ?></td>
                                    <td><?= $ob->pin_qty; ?></td>
                                    <td><?= $package[$ob->pintype]; ?></td>
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
    $(document).ready(() => {
        $('#pinqty').change(() => {
            let rate = $('#pintype').val();
            let v = $('#pinqty').val();
            if (v == '') {
                v = 0;
            }
            let s = parseInt(v) * rate;
            $('#amtid').val(s);
        });
    });
</script>