<h5>Pin Request</h5>
<hr />

<div id="pin" class="row">
    <div class="col-sm-5">
        <div class="box">
            <div class="box-p" ng-controller="PinCtrl">
                <form enctype="multipart/form-data" class="form-horizontal" method="POST" action="<?= site_url('dashboard/pin-request-balance'); ?>">
                    <div class="form-group row">
                        <label class="col-sm-4 control-label">Package <span class="required">*</span> </label>
                        <div class="col-md-8">
                            <?php
                            echo form_dropdown('pintype', config_item('package'), '', 'class="form-control" v-on:change="updateQty()" v-model="pintype" id="pintype"');
                            ?>
                        </div>
                    </div>
                    <?php $bal = $this->User_model->getWalletBalance(user_id()); ?>
                    <div class="form-group row">
                        <label class="col-sm-4 control-label">Current Balance </label>
                        <div class="col-md-8">
                            <input class="form-control" type="text" readonly value="<?= $bal ?>" v-model="balance">
                        </div>
                    </div>
                    <?php
                    $pin = $bal / 1299;
                    ?>
                    <div class="form-group row">
                        <label class="col-sm-4 control-label">Pin Quantity test<span class="required">*</span> </label>
                        <div class="col-md-8">
                            <select class="form-control" v-model="qty" v-on:change="setQty()" name="pin_qty">
                                <option value="0">Select</option>
                                <option v-for="i in items" v-bind:value="i">{{ i }}</option>
                            </select>
                        </div>
                    </div>


                    <div class="form-group row">
                        <label class="col-sm-4 control-label">Amount <span class="required">*</span></label>
                        <div class="col-sm-7">
                            <input class="form-control" v-model="total" readonly type="text" placeholder="0.00">
                        </div>
                    </div>

                    <!-- <div class="form-group row">
                        <label class="col-sm-4 control-label">Transaction No <span class="required">*</span></label>
                        <div class="col-sm-7">
                            <input class="form-control" type="text" placeholder="Txn no" name="txn_no">
                        </div> -->

                    <div class="form-group row">
                        <label class="col-sm-4 control-label">Extra Notes</label>
                        <div class="col-sm-7">
                            <input class="form-control" type="text" placeholder="Write small optional notes" name="notes">
                        </div>
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
    var vm = new Vue({
        el: '#pin',
        data: {
            qty: 0,
            items: [],
            balance: <?= $bal; ?>,
            pintype: 1000,
            total: 0
        },
        methods: {
            updateQty: function() {
                let q = this.balance / this.pintype;
                this.items = [];
                for (let i = 1; i <= q; i++) {
                    this.items.push(i);
                }
            },
            setQty: function() {
                this.total = this.qty * Number(this.pintype);
            }
        },
        created: function() {
            let q = this.balance / this.pintype;
            this.items = [];
            for (let i = 1; i <= q; i++) {
                this.items.push(i);
            }
        }
    });
</script>