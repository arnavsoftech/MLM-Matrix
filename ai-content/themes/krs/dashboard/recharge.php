<div class="d-flex justify-content-between">
    <h6>Recharge Services</h6>
    <h6>Available Balance: <?= $total_bal; ?></h6>
</div>

<?php
$arPrepaid = $arPostpaid = $arDTH = array();
$rest = $this->db->order_by('operator', 'ASC')->get_where('sercode', array('status' => 1))->result();
foreach ($rest as $ob) {
    if ($ob->rechtype == 'Prepaid') {
        $arPrepaid[$ob->scode] = $ob->operator;
    } else if ($ob->rechtype == 'Postpaid') {
        $arPostpaid[$ob->scode] = $ob->operator;
    } else {
        $arDTH[$ob->scode] = $ob->operator;
    }
}

$childs = $this->db->get_where("users", array("epin !=" => ''))->num_rows();
?>

<style>
    .msg1,
    .msg2,
    .msg3 {
        font-size: 11px;
    }
</style>

<hr>

<div>
    <!-- <a href="#" class="btn btn-sm mybtn" data-color="#007bff" data-target="#prepaid" style="border-radius: 3px 3px 0 0;">Prepaid</a> -->
    <!-- <a href="#" class="btn btn-sm mybtn" data-color="#007bff" data-target="#postpaid" style="border-radius: 3px 3px 0 0;">Postpaid</a> -->
    <!-- <a href="#" class="btn btn-sm mybtn" data-color="#007bff" data-target="#dth" style="border-radius: 3px 3px 0 0;">DTH</a> -->
    <a href="#" class="btn btn-sm mybtn mybtnactive" data-color="#007bff" data-target="#transfer" style="border-radius: 3px 3px 0 0;">Money Transfer</a>
    <div class="box box-content p-3">
        <!-- <div class="content" id="prepaid">
            <p>Please enter your prepaid mobile no</p>
            <div class="form-group row">
                <label class="col-sm-1 text-right">Network</label>
                <div class="col-sm-3">
                    <?= form_dropdown('scode', $arPrepaid, '', 'class="form-control network1"'); ?>
                </div>
            </div>
            <div class="form-group row">
                <label class="col-sm-1 text-right">Amount</label>
                <div class="col-sm-3">
                    <input type="number" class="form-control amount1">
                    <small class="text-muted">Max Usable Bal: <?= intval($rech_bal); ?></small>
                </div>
            </div>
            <div class="form-group row">
                <label class="col-sm-1 text-right">Mobile no</label>
                <div class="col-sm-3">
                    <input type="number" class="form-control mobile1">
                </div>
            </div>
            <div class="form-group row">
                <label class="col-sm-1 text-right"></label>
                <div class="col-sm-3">
                    <input type="submit" class="btn btn1 btn-primary">
                </div>
            </div>
            <div class="form-group row">
                <label class="col-sm-1"></label>
                <div class="col-sm-3">
                    <div class="loader1" style="display: none; ">
                        <img src="<?= theme_url('user/img/loader.gif'); ?>" width="20" />
                        <small>Processing</small>
                    </div>
                    <div class="msg1"></div>
                </div>
            </div>
            <script>
                $(document).ready(() => {
                    $('.btn1').click(() => {
                        let network = $('.network1').val();
                        let amount = $('.amount1').val();
                        let mobile = $('.mobile1').val();
                        $('.loader1').show();
                        $('.msg1').removeClass('alert').html('');
                        $.ajax({
                            url: '<?= site_url('home/recharge') ?>',
                            data: {
                                net: network,
                                amt: amount,
                                mob: mobile,
                                act: 'Prepaid'
                            },
                            method: 'POST',
                            success: (resp) => {
                                $('.loader1').hide();
                                if (resp.status) {
                                    $('.msg1').addClass('alert alert-success p-1').html('Recharge Successful');
                                } else {
                                    $('.msg1').addClass('alert alert-danger p-1').html('Recharge Failed');
                                }
                            },
                            error: (err) => {
                                console.log(err);
                            }
                        });
                    });
                });
            </script>
        </div> -->
        <!-- <div class="content" id="postpaid">
            <p>Please enter your postpaid mobile no</p>
            <div class="form-group row">
                <label class="col-sm-1 text-right">Network</label>
                <div class="col-sm-3">
                    <?= form_dropdown('scode', $arPostpaid, '', 'class="form-control network2"'); ?>
                </div>
            </div>
            <div class="form-group row">
                <label class="col-sm-1 text-right">Amount</label>
                <div class="col-sm-3">
                    <input type="number" class="form-control amount2">
                    <small class="text-muted">Max Usable Bal: <?= intval($rech_bal); ?></small>
                </div>
            </div>
            <div class="form-group row">
                <label class="col-sm-1 text-right">Mobile no</label>
                <div class="col-sm-3">
                    <input type="number" class="form-control mobile2">
                </div>
            </div>
            <div class="form-group row">
                <label class="col-sm-1 text-right"></label>
                <div class="col-sm-3">
                    <input type="submit" class="btn btn2 btn-primary">
                </div>
            </div>
            <div class="form-group row">
                <label class="col-sm-1"></label>
                <div class="col-sm-3">
                    <div class="loader2" style="display: none; ">
                        <img src="<?= theme_url('user/img/loader.gif'); ?>" width="20" />
                        <small>Processing</small>
                    </div>
                    <div class="msg2"></div>
                </div>
            </div>

            <script>
                $(document).ready(() => {
                    $('.btn2').click(() => {
                        let network = $('.network2').val();
                        let amount = $('.amount2').val();
                        let mobile = $('.mobile2').val();
                        $('.loader2').show();
                        $('.msg2').removeClass('alert').html('');
                        $.ajax({
                            url: '<?= site_url('home/recharge') ?>',
                            data: {
                                net: network,
                                amt: amount,
                                mob: mobile,
                                act: 'Postpaid'
                            },
                            method: 'POST',
                            success: (resp) => {
                                $('.loader2').hide();
                                if (resp.status) {
                                    $('.msg2').addClass('alert alert-success p-1').html('Recharge Successful');
                                } else {
                                    $('.msg2').addClass('alert alert-danger p-1').html('Recharge Failed');
                                }
                            }
                        });
                    });
                });
            </script>
        </div> -->
        <!-- <div class="content" id="dth">
            <div class="form-group row">
                <label class="col-sm-1 text-right">Network</label>
                <div class="col-sm-3">
                    <?= form_dropdown('scode', $arDTH, '', 'class="form-control network3"'); ?>
                </div>
            </div>
            <div class="form-group row">
                <label class="col-sm-1 text-right">Customer Id</label>
                <div class="col-sm-3">
                    <input type="number" class="form-control mobile3">
                </div>
            </div>
            <div class="form-group row">
                <label class="col-sm-1 text-right">Amount</label>
                <div class="col-sm-3">
                    <input type="number" class="form-control amount3">
                    <small class="text-muted">Max Usable Bal: <?= intval($rech_bal); ?></small>
                </div>
            </div>
            <div class="form-group row">
                <label class="col-sm-1 text-right"></label>
                <div class="col-sm-3">
                    <input type="submit" class="btn btn3 btn-primary">
                </div>
            </div>
            <div class="form-group row">
                <label class="col-sm-1"></label>
                <div class="col-sm-3">
                    <div class="loader3" style="display: none; ">
                        <img src="<?= theme_url('user/img/loader.gif'); ?>" width="20" />
                        <small>Processing</small>
                    </div>
                    <div class="msg3"></div>
                </div>
            </div>
            <script>
                $(document).ready(() => {
                    $('.btn3').click(() => {
                        let network = $('.network3').val();
                        let amount = $('.amount3').val();
                        let mobile = $('.mobile3').val();
                        $('.loader3').show();
                        $('.msg3').removeClass('alert').html('');
                        $.ajax({
                            url: '<?= site_url('home/recharge') ?>',
                            data: {
                                net: network,
                                amt: amount,
                                mob: mobile,
                                act: 'DTH'
                            },
                            method: 'POST',
                            success: (resp) => {
                                console.log(resp);
                                $('.loader3').hide();
                                if (resp.status) {
                                    $('.msg3').addClass('alert alert-success p-1').html('Recharge Successful');
                                } else {
                                    $('.msg3').addClass('alert alert-danger p-1').html('Recharge Failed');
                                }
                            }
                        });
                    });
                });
            </script>
        </div> -->
        <div class="content" id="transfer">
            <?php
            $u = $this->db->get_where('users', array('id' => user_id()))->row();
            ?>
            <div class="form-group row">
                <label class="col-sm-1 text-right">Bank Details</label>
                <div class="col-sm-3">
                    <?php
                    if ($u->bank_info == '') {
                    ?>
                        <div class="alert alert-danger">
                            You must Add your Bank Details. <a href="<?= site_url('dashboard/edit_profile'); ?>">Click here to Add</a>
                        </div>
                    <?php
                    } else {
                        $bank = json_decode($u->bank_info);
                        //print_r($bank);
                    ?>
                        <div>
                            <b>Bank: </b> <?= $bank->bank_name; ?> <br />
                            <b>A/c No: </b> <?= $bank->ac_number; ?>
                        </div>
                    <?php
                    }
                    ?>
                </div>
            </div>
            <div class="form-group row">
                <label class="col-sm-1 text-right">Amount</label>
                <div class="col-sm-3">
                    <input type="number" class="form-control amount4">
                    <small class="text-muted">Min Transfer: Rs 300</small>
                </div>
            </div>
            <div class="form-group row">
                <label class="col-sm-1 text-right"></label>
                <div class="col-sm-3">
                    <?php
                    if ($childs > 0) {
                        if ($rech_bal > 300) {
                    ?>
                            <input type="submit" value="Transfer" class="btn btn4 btn-primary">
                        <?php
                        } else {
                        ?>
                            <p class="text-danger">You don't have sufficient balance. </p>
                        <?php
                        }
                    } else {
                        ?>
                        <p class="text-danger">You must sponsor one id to transfer your fund. </p>
                    <?php
                    }
                    ?>

                </div>
            </div>
            <div class="form-group row">
                <label class="col-sm-1"></label>
                <div class="col-sm-3">
                    <div class="loader4" style="display: none; ">
                        <img src="<?= theme_url('user/img/loader.gif'); ?>" width="20" />
                        <small>Processing</small>
                    </div>
                    <div class="msg4"></div>
                </div>
            </div>
            <script>
                $(document).ready(() => {
                    $('.btn4').click(() => {
                        let amt = $('.amount4').val();
                        $('.loader4').show();
                        $('.msg4').removeClass('alert').html('');
                        $.ajax({
                            url: '<?= site_url('dashboard/ajax_money_transfer') ?>',
                            data: {
                                amount: amt
                            },
                            method: 'GET',
                            success: (resp) => {
                                $('.loader4').hide();
                                if (resp.status) {
                                    $('.msg4').addClass('alert alert-success p-1').html(resp.message);
                                    $('.btn4').attr('disabled', 'true');
                                } else {
                                    $('.msg4').addClass('alert alert-danger p-1').html(resp.message);
                                }
                            }
                        });
                    });
                });
            </script>
        </div>
    </div>
</div>

<style>
    .content {
        display: none;
    }

    #transfer {
        display: block;
    }

    .mybtn {
        background: #DDD;
        color: #333;
    }

    .mybtnactive {
        background: blue;
        color: #FFF
    }
</style>

<script>
    $(document).ready(function() {
        $('.mybtn').click(function() {
            $('.mybtn').removeClass('mybtnactive');
            $(this).addClass('mybtnactive');
            let tr = $(this).data('target');
            $('.content').hide();
            $(tr).show();
        });
    });
</script>