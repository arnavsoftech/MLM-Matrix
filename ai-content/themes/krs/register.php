<div class="container py-5">
    <img src="<?= theme_url('img/reg.png') ?>" class="img-fluid mb-3" alt="" />
    <div class="row">
        <div class="col-sm-8 m-auto">
            <h4>Register an Account</h4>
            <hr />
            <?php $this->load->view("alert.php"); ?>
            <div class="border rounded">
                <div class="box-p p-3">
                    <p>Please fill the details carefully. Password will be sent on given mobile no. </p>
                    <form class="form-horizontal" method="POST" action="<?= site_url('register'); ?>">
                        <div class="form-group mb-3 row">
                            <label class="col-md-3 text-right">I have </label>
                            <div class="col-md-8">
                                <label class="radio"><input class="jtype" type="radio" name="jointype" checked value="1"> Sponsor ID &nbsp; &nbsp; </label>
                                <label class="radio"><input class="jtype" type="radio" name="jointype" value="2"> Joining PIN</label>
                            </div>
                        </div>

                        <div class="form-group mb-2 row">
                            <label class="col-md-3 text-right"><span id="jtext">Sponsor Id </span> <span class="text-danger">*</span> </label>
                            <div class="col-md-8">
                                <input class="form-control" type="text" id="resinput" value="<?= $refcode; ?>" name="form[epin]" placeholder="e.g">
                                <small id="respval"></small>
                            </div>
                        </div>
                        <div class="form-group mb-2 row">
                            <label class="col-md-3 text-right">Full Name <span class="text-danger">*</span> </label>
                            <div class="col-md-4">
                                <input class="form-control" type="text" required placeholder="First name" value="<?= set_value('form[first_name]'); ?>" name="form[first_name]">
                            </div>
                            <div class="col-md-4">
                                <input class="form-control" type="text" required placeholder="Last name" value="<?= set_value('form[last_name]'); ?>" name="form[last_name]">
                            </div>
                        </div>

                        <div class="form-group mb-2 row">
                            <label class="col-md-3 text-right">Mobile <span class="text-danger">*</span></label>
                            <div class="col-md-4">
                                <input class="form-control" required type="mobile" placeholder="Mobile no" value="<?= set_value('form[mobile]'); ?>" name="form[mobile]">
                            </div>
                        </div>
                        <div class="form-group mb-3 row">
                            <label class="col-sm-3"></label>
                            <div class="col-sm-9" style="font-size: 12px; color: #888">
                                <input type="checkbox" checked disabled>
                                I Agree the <a href="#" target="_blank">Terms & Conditions</a> and <a href="#" target="_blank">Privacy Policy</a>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label class="col-sm-3"></label>
                            <div class="col-sm-6">
                                <button class="btn btn-primary" type="submit" name="save" value="Create">Create</button>
                                <a href="<?= site_url(); ?>" class="btn btn-dark">Cancel</a>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
            <p class="box p-2">
            </p>
        </div>
    </div>
</div>

<script>
    $(document).ready(() => {
        var v = 1;
        $('.jtype').click(() => {
            v = $('.jtype:checked').val();
            if (v == 1) {
                $('#jtext').html('Sponsor Id');
            } else {
                $('#jtext').html('Joining PIN');
            }
            $('#resinput').val('');
        });
        $('#resinput').blur(function() {
            let nm = $(this).val();
            $('#respval').removeClass().html("Checking...").addClass('text-info');
            $.ajax({
                url: '<?= site_url('home/ajax_signup_check') ?>',
                data: {
                    txt: nm,
                    type: v
                },
                dataType: 'json',
                success: function(res) {
                    if (res.success) {
                        $('#respval').html(res.message).addClass('text-success');
                    } else {
                        $('#respval').html(res.message).addClass('text-danger');
                    }
                },
                error: function(err) {
                    console.log(err);
                }
            });
        });

    });
</script>