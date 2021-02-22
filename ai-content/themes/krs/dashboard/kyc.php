<div class="d-flex justify-content-between align-items-center">
    <div>
        <h5>KYC Upload-  You KYC Status: <?=$doc->kyc_status==1?'Approved':'Pending'?></h5>
        <div class="text-muted small">Please upload clearly visible documents. Size max 2 MB</div>
    </div>
    <a href="<?= site_url('dashboard/edit-profile') ?>" class="btn btn-sm btn-primary">Go Back</a>
</div>
<hr>
<style>
    .browse {
        display: flex;
        justify-content: flex-start;
        align-items: center;
    }

    .preview {
        background: #F8f5f9;
        border: dotted 1px #DDD;
        width: 80px;
        border-radius: 5px;
        margin-right: 15px;
        min-height: 80px;
    }
</style>

<script>
    $(document).ready(() => {

        $('.fileupload').on('change', function(e) {
            $(this).parent().parent().submit();
        });
    });
</script>
<?php
$img = theme_url('images/default.png');

$doc->aadharf  = $doc->aadharf == '' ? $img : base_url(upload_dir($doc->aadharf));
$doc->aadharb  = $doc->aadharb == '' ? $img : base_url(upload_dir($doc->aadharb));
$doc->photo  = $doc->photo == '' ? $img : base_url(upload_dir($doc->photo));
$doc->pan  = $doc->pan == '' ? $img : base_url(upload_dir($doc->pan));
$doc->passbook  = $doc->passbook == '' ? $img : base_url(upload_dir($doc->passbook));
?>
<div class="row">
    <div class="col-sm-8">
        <div class="box">
            <table class="table">
                <tr>
                    <td>Photo</td>
                    <td>
                        <form enctype="multipart/form-data" id="photoform" action="<?= site_url('dashboard/kyc'); ?>" method="post">
                            <div data-file="aadhar" class="browse">
                                <div class="preview">
                                    <img id="photo-image" src="<?= $doc->photo; ?>" class="img-fluid" alt="">
                                </div>
                                <?php
                                if ($doc->photo == $img) {
                                ?>
                                    <input class="fileupload" type="file" name="photo">
                                <?php
                                }
                                ?>

                            </div>
                        </form>

                    </td>
                </tr>
                <tr>
                    <td>Adhar Number</td>
                    <td>
                        <form action="<?= site_url('dashboard/kyc'); ?>" method="post">
                            <div class="row">
                                <div class="col-sm-5">
                                    <input type="text" name="adhar_no" value="<?= $doc->adhar_no; ?>" class="form-control">
                                </div>
                                <div class="col-sm-4">
                                    <?php
                                    if ($doc->adhar_no == '') {
                                    ?>
                                        <button type="submit" class="btn btn-primary">Save</button>
                                    <?php
                                    }
                                    ?>
                                </div>
                            </div>
                        </form>
                    </td>
                </tr>
                <tr>
                    <td>Aadhar Card (Front)</td>
                    <td>
                        <form enctype="multipart/form-data" action="<?= site_url('dashboard/kyc'); ?>" method="post">
                            <div data-file="aadhar" class="browse">
                                <div class="preview">
                                    <img id="photo-image" src="<?= $doc->aadharf; ?>" class="img-fluid" alt="">
                                </div>
                                <?php
                                if ($doc->aadharf == $img) {
                                ?>
                                    <input class="fileupload" type="file" name="aadharf">
                                <?php
                                }
                                ?>

                            </div>
                        </form>
                    </td>
                </tr>
                <tr>
                    <td>Aadhar Card (Back)</td>
                    <td>
                        <form enctype="multipart/form-data" action="<?= site_url('dashboard/kyc'); ?>" method="post">
                            <div data-file="aadhar" class="browse">
                                <div class="preview">
                                    <img id="photo-image" src="<?= $doc->aadharb; ?>" class="img-fluid" alt="">
                                </div>

                                <?php
                                if ($doc->aadharb == $img) {
                                ?>
                                    <input class="fileupload" type="file" name="aadharb">
                                <?php
                                }
                                ?>
                            </div>
                        </form>
                    </td>
                </tr>
                <tr>
                    <td>PAN Number</td>
                    <td>
                        <form action="<?= site_url('dashboard/kyc'); ?>" method="post">
                            <div class="row">
                                <div class="col-sm-5">
                                    <input type="text" name="pan_no" value="<?= $doc->pan_no; ?>" class="form-control">
                                </div>
                                <div class="col-sm-4">
                                    <?php
                                    if ($doc->pan_no == '') {
                                    ?>
                                        <button type="submit" class="btn btn-primary">Save</button>
                                    <?php
                                    }
                                    ?>

                                </div>
                            </div>
                        </form>

                    </td>
                </tr>
                <tr>
                    <td>PAN Card</td>
                    <td>
                        <form enctype="multipart/form-data" action="<?= site_url('dashboard/kyc'); ?>" method="post">
                            <div data-file="aadhar" class="browse">
                                <div class="preview">
                                    <img id="photo-image" src="<?= $doc->pan; ?>" class="img-fluid" alt="">
                                </div>
                                <?php
                                if ($doc->pan == $img) {
                                ?>
                                    <input class="fileupload" type="file" name="pan">
                                <?php
                                }
                                ?>
                            </div>
                        </form>
                    </td>
                </tr>

                <tr>
                    <td>Passbook</td>
                    <td>
                        <form enctype="multipart/form-data" action="<?= site_url('dashboard/kyc'); ?>" method="post">
                            <div data-file="aadhar" class="browse">
                                <div class="preview">
                                    <img id="photo-image" src="<?= $doc->passbook; ?>" class="img-fluid" alt="">
                                </div>
                                <?php
                                if ($doc->passbook == $img) {
                                ?>
                                    <input class="fileupload" type="file" name="passbook">
                                <?php
                                }
                                ?>
                            </div>
                        </form>
                    </td>
                </tr>
            </table>
        </div>
    </div>
</div>