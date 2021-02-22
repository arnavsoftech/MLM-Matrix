<h5>Create new account</h5>
<hr>
<div class="row">
    <div class="col-sm-12">
        <div class="box">
            <div class="box-p">
                <p>Please fill the details carefully. Password will be sent on given mobile no. </p>
                <form class="form-horizontal" method="POST" action="<?= site_url('dashboard/addnew/' . $pin->pin); ?>">
                    <div class="form-group row">
                        <label class="col-md-2 text-right">Pin <span class="required">*</span> </label>
                        <div class="col-md-4">
                            <input class="form-control" type="text" readonly value="<?= $pin->pin; ?>" name="form[epin]">
                        </div>
                        <label class="col-md-2 text-right">Sponsor Id <span class="required">*</span> </label>
                        <div class="col-md-4">
                            <input class="form-control" type="text" id="spid" required value="<?= set_value('sponsor', $me->username); ?>" name="sponsor">

                            <div id="result">
                                -
                            </div>
                        </div>
                    </div>

                    <div class="form-group row">
                        <label class="col-md-2 text-right">First name <span class="required">*</span> </label>
                        <div class="col-md-4">
                            <input class="form-control" type="text" required placeholder="First name" value="<?= set_value('form[first_name]'); ?>" name="form[first_name]">
                        </div>
                        <label class="col-md-2 text-right">Last name</label>
                        <div class="col-md-4">
                            <input class="form-control" type="text" placeholder="Last name" value="<?= set_value('form[last_name]'); ?>" name="form[last_name]">
                        </div>
                    </div>

                    <div class="form-group row">
                        <label class="col-md-2 text-right">Mobile <span class="required">*</span></label>
                        <div class="col-md-4">
                            <input class="form-control" type="mobile" required placeholder="Mobile no" value="<?= set_value('form[mobile]'); ?>" name="form[mobile]">
                        </div>
                        <label class="col-md-2 text-right">Join Kit <span class="required">*</span></label>
                        <div class="col-md-4">
                            <?php
                            $ar = array();
                            $ar['none'] = 'None';
                            $ar['products'] = 'Products';
                            // $ar['recharge'] = 'Recharge';
                            ?>
                            <?= form_dropdown('form[join_kit]', $ar, set_value('form[join_kit]'), 'class="form-control"'); ?>
                        </div>
                        <input type="hidden" name="form[kit_issue]" value="0">
                    </div>

                    <div class="form-group row">
                        <label class="col-sm-2"></label>
                        <div class="col-sm-10">
                            <button class="btn btn-sm btn-primary" type="submit" name="save">Create now</button>
                            <a href="<?= site_url('dashboard/pin-list'); ?>" class="btn btn-sm btn-dark">Cancel</a>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
    $(document).ready(function() {
        $('#spid').blur((e) => {
            let userid = e.target.value;
            $('#result').html('Checking...');
            $.ajax({
                url: '<?= site_url('dashboard/ajax_get_name'); ?>',
                method: 'get',
                type: 'json',
                data: 'userid=' + userid,
                success: (ob) => {
                    let userinfo = 'Name: ' + ob.first_name + ' ' + ob.last_name + ' Mobile: ' + ob.mobile;
                    if (ob.success) {
                        $('#result').html('<div class="text-success">' + userinfo + '</div>');
                    } else {
                        $('#result').html('<div class="text-danger">Invalid Sponsor Id</div>');
                    }
                },
                error: (e) => {
                    console.log(e);
                }
            });
        });
    });
</script>