<?php
$is_pending = false;
$c = $this->db->get_where('withdraw', array('user_id' => user_id(), 'status' => 0))->num_rows();
if ($c >= 1) {
    $is_pending = true;
}
?>
<div id="withdraw">
    <div v-if="err" v-bind:class="errClass">{{ errMsg }}</div>
    <div class="row">
        <div class="col-sm-5">
            <h5>Money Withdrawal Request</h5>
            <form action="<?= site_url('dashboard/withdraw'); ?>" method="post">
                <div class="box">
                    <div class="box-p">
                        <h6>Current Balance: <?= $wallet_bal; ?></h6>
                        <hr />
                        <?php
                        if ($is_pending) {
                        ?>
                            <div class="alert alert-danger">You already have one withdraw pending.</div>
                        <?php
                        } else {
                        ?>
                            <div class="from-group row">
                                <div class="col-sm-8">
                                    <input type="text" name="amount" v-model="amount" required placeholder="e.g. <?= config_item('min_withdraw_limit'); ?>" class="form-control form-control-sm">
                                    <small class="text-muted">Min withdrawal Rs <?= config_item('min_withdraw_limit'); ?>/- </small>
                                </div>
                                <div class="col-sm-4">
                                    <input type="button" v-on:click="withdraw()" name="btnsubmit" value="Submit" class="btn btn-sm btn-block btn-primary">
                                </div>
                            </div>
                        <?php
                        }
                        ?>

                    </div>
                </div>
            </form>
        </div>
        <div class="col-sm-7">
            <h5>Recent Withdrawal Request</h5>
            <div class="box box-p">
                <table class="table">
                    <thead>
                        <tr>
                            <th>Sl No</th>
                            <th>Amount</th>
                            <th>Status</th>
                            <th>Notes</th>
                            <th>Last update</th>
                            <th></th>
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
                                <td>
                                    <?php
                                    if ($ob->status == 0) echo "Pending";
                                    if ($ob->status == 1) echo "Approved";
                                    if ($ob->status == 2) echo "Rejected";
                                    if ($ob->status == 3) echo "Cancelled";
                                    ?>
                                </td>
                                <td>
                                    <?php
                                    if ($ob->comments != '') echo '<span class="badge badge-warning">' . $ob->comments . '</span>';
                                    ?>
                                </td>
                                <td><?= date('jS M, Y H:i', strtotime($ob->updated)); ?></td>
                                <td>
                                    <?php
                                    if ($ob->status == 0) {
                                    ?>
                                        <a href="#" v-on:click="deleteThis(<?= $ob->id ?>)" class="btn btn-xs delete"> <i class="fa text-white fa-close"></i> </a>
                                    <?php
                                    }
                                    ?>
                                </td>
                            </tr>
                        <?php
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
        el: '#withdraw',
        data: {
            err: false,
            errMsg: null,
            errClass: 'alert alert-danger',
            amount: null
        },
        methods: {
            withdraw: function() {
                this.err = true;
                this.errMsg = "Processing";
                let url = '<?= site_url('dashboard/call/withdraw') ?>';
                url += '/?amt=' + this.amount;
                fetch(url)
                    .then(ab => ab.json())
                    .then(resp => {
                        this.errMsg = resp.message;
                        this.err = true;
                        if (resp.status) {
                            this.errClass = 'alert alert-success';
                            this.amount = null;
                            setTimeout(function() {
                                location.reload();
                            }, 2000);
                        } else {
                            this.errClass = 'alert alert-danger';
                        }
                    });
            },
            deleteThis: function(req_id) {
                if (!confirm('Are you sure to delete this?'))
                    return false;
                let url = '<?= site_url('dashboard/call/remove-withdaw') ?>';
                url += '/?req_id=' + req_id;
                fetch(url).then(ab => ab.json())
                    .then(resp => {
                        if (resp.status) {
                            location.reload();
                        }
                    });
            }
        },
    });
</script>