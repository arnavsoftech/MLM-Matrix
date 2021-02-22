<link rel="stylesheet" href="<?= base_url('front/css/simplelightbox.css') ?>">
<section class="section section-lg bg-color">
    <div class="container container-wide">

        <div class="row mt-4">
            <div class="col-sm-12">

                <div class="card-body">
    <form action="<?= admin_url('members/edit_image/' . $doc->id); ?>" class="form-horizontal" enctype="multipart/form-data" method="post" accept-charset="utf-8">
                        <div class="form-group">
                            <div class="row">
                                <label class="col-md-2 control-label">Kyc Status <span class="required" style="color:red;">*</span> </label>
                                <div class="col-sm-4">
                                   <?php $arr= array('1'=>'Approved','0'=>'Disapproved');

                                   echo form_dropdown('kyc_status',$arr,$doc->kyc_status,array('class'=>'form-control'));
                                    ?>
                                </div>
                                <div class="col-sm-4">

                                    <button class="btn btn-primary " type="submit" name="btn_reg" value="upload">Sumbit</button>

                                </div>
                            </div>
                        </div>
                    </form>               
                    <form action="<?= admin_url('members/edit_image/' . $doc->id); ?>" class="form-horizontal" enctype="multipart/form-data" method="post">

                        <div class="form-group">
                            <div class="row">
                                <label class="col-md-2 control-label">Photo <span class="required" style="color:red;">*</span> </label>
                                <div class="col-sm-4">

                                    <input class="form-control" type="file" id="userImage" placeholder="select file" name="image">
                                </div>
                                <div class="col-sm-4">

                                    <button class="btn btn-primary" type="submit" name="btn_reg" value="upload">Upload</button> </div>
                            </div>
                        </div>
                    </form>
                    <form action="<?= admin_url('members/edit_image/' . $doc->id); ?>" class="form-horizontal" enctype="multipart/form-data" method="post" accept-charset="utf-8">

                        <div class="form-group">
                            <div class="row">
                                <label class="col-md-2 control-label">PAN Card </label>
                                <div class="col-sm-4">
                                    <input class="form-control" type="file" id="userImage1" placeholder="select file" name="pan">
                                </div>
                                <div class="col-sm-4">

                                    <button class="btn btn-primary" type="submit" name="btn_reg" value="upload">Upload</button>

                                </div>
                            </div>
                        </div>
                    </form>

                    <div class="form-group">
                        <div class="row">
                            <label class="col-md-2 control-label">PAN Card Number </label>
                            <?php
                            $pan = '';
                            if (is_object($doc)) {
                                $pan = $doc->pan_no;
                            } ?>
                            <div class="col-sm-4">
                                <input class="form-control" value="<?php echo $pan; ?>" type="text" placeholder="Enter Pan number" name="pan_no">
                            </div>
                        </div>
                    </div>

                    <form action="<?= admin_url('members/edit_image/' . $doc->id); ?>" class="form-horizontal" enctype="multipart/form-data" method="post" accept-charset="utf-8">

                        <div class="form-group">
                            <div class="row">
                                <label class="col-md-2 control-label">Aadhar Card front page <span class="required" style="color:red;">*</span> </label>
                                <div class="col-sm-4">
                                    <input class="form-control" id="userImage2" type="file" placeholder="select file" name="aadharf">
                                </div>
                                <div class="col-sm-4">

                                    <button class="btn btn-primary" type="submit" name="btn_reg" value="upload">Upload</button>

                                </div>
                            </div>
                        </div>
                    </form>

                    <form action="<?= admin_url('members/edit_image/' . $doc->id); ?>" class="form-horizontal" enctype="multipart/form-data" method="post" accept-charset="utf-8">
                        <div class="form-group">
                            <div class="row">
                                <label class="col-md-2 control-label">Aadhar Card back page <span class="required" style="color:red;">*</span> </label>
                                <div class="col-sm-4">
                                    <input class="form-control" type="file" id="userImage3" placeholder="select file" name="aadharb">
                                </div>
                                <div class="col-sm-4">

                                    <button class="btn btn-primary " type="submit" name="btn_reg" value="upload">Upload</button>

                                </div>
                            </div>
                        </div>
                    </form>

                    <form action="<?= admin_url('members/edit_image/' . $doc->id); ?>" class="form-horizontal" enctype="multipart/form-data" method="post" accept-charset="utf-8">
                        <div class="form-group">
                            <div class="row">
                                <label class="col-md-2 control-label"> Passbook front page <span class="required" style="color:red;">*</span> </label>
                                <div class="col-sm-4">
                                    <input class="form-control" type="file" id="userImage4" placeholder="select file" name="account">
                                </div>
                                <div class="col-sm-4">

                                    <button class="btn btn-primary " type="submit" name="btn_reg" value="upload">Upload</button>

                                </div>
                            </div>
                        </div>
                    </form>


                    <div class="table-responsive">
                        <?php if (is_object($doc)) { ?>
                            <?php if ($doc->image != '') { ?>
                                <div class="col-sm-4">
                                    <div class="gallery">

                                        <a href="<?= site_url(upload_dir($doc->image)) ?>" class="big"><img src="<?= site_url(upload_dir($doc->image)) ?>" alt="" title="Your Photo" /></a>
                                    </div>
                                </div>
                            <?php } ?>
                            <?php if ($doc->pan != '') { ?>
                                <div class="col-sm-4">
                                    <div class="gallery">
                                        <a href="<?= site_url(upload_dir($doc->pan)) ?>" class="big"><img src="<?= site_url(upload_dir($doc->pan)) ?>" alt="" title="Pan Card" /></a>
                                    </div>
                                </div>
                            <?php } ?>
                            <?php if ($doc->pan != '') { ?>
                                <div class="col-sm-4">
                                    <div class="gallery">
                                        <a href="<?= site_url(upload_dir($doc->aadharf)) ?>" class="big"><img src="<?= site_url(upload_dir($doc->aadharf)) ?>" alt="" title="Adhar Front" /></a>
                                    </div>
                                </div>
                            <?php } ?>
                            <?php if ($doc->pan != '') { ?>
                                <div class="col-sm-4">
                                    <div class="gallery">
                                        <a href="<?= site_url(upload_dir($doc->aadharb)) ?>" class="big"><img src="<?= site_url(upload_dir($doc->aadharb)) ?>" alt="" title="Adhar Back" /></a>
                                    </div>
                                </div>
                            <?php } ?>
                            <?php if ($doc->pan != '') { ?>
                                <div class="col-sm-4">
                                    <div class="gallery">
                                        <a href="<?= site_url(upload_dir($doc->passbook)) ?>" class="big"><img src="<?= site_url(upload_dir($doc->passbook)) ?>" alt="" title="Passbook" /></a>
                                    </div>
                                </div>
                            <?php } ?>
                        <?php } ?>
                    </div>
 
<h5>Bank Details</h5>
            <hr>
            <?php
            $bank            = new stdClass();
            $bank->bank_name = '';
            $bank->branch    = '';
            $bank->ifsc      = '';
            $bank->ac_number = '';
            $bank->ac_name   = '';
            $cls             = '';

            if ($doc->bank_info != '' and !is_null($doc->bank_info)) {
                $bank = json_decode($doc->bank_info);
            }
           
            ?>
        <form action="<?= admin_url('members/edit_image/' . $doc->id); ?>" class="form-horizontal" enctype="multipart/form-data" method="post" accept-charset="utf-8">    
            <div class="form-group row">
                <label class="col-sm-2 control-label">Bank Name <span class="required">*</span></label>
                <div class="col-sm-3">
                    <input required class="form-control" type="text" value="<?= set_value('bank[bank_name]', $bank->bank_name); ?>" name="bank[bank_name]">
                </div>
                <label class="col-sm-2 control-label">A/c Holder <span class="required">*</span></label>
                <div class="col-sm-3">
                    <input required class="form-control" type="text" value="<?= set_value('bank[ac_name]', $bank->ac_name); ?>" name="bank[ac_name]">
                </div>
            </div>
            <div class="form-group row">
                <label class="col-sm-2 control-label">A/c Number <span class="required">*</span></label>
                <div class="col-sm-3">
                    <input required class="form-control" type="text" value="<?= set_value('bank[ac_number]', $bank->ac_number); ?>" name="bank[ac_number]">
                    <small class="text-muted">Please enter the account number carfully</small>
                </div>
                <label class="col-sm-2 control-label">Bank Branch <span class="required">*</span></label>
                <div class="col-sm-3">
                    <input required class="form-control"type="text" value="<?= set_value('bank[branch]', $bank->branch); ?>" name="bank[branch]">
                </div>
            </div>
            <div class="form-group row">
                <label class="col-sm-2 control-label">IFSC Code <span class="required">*</span></label>
                <div class="col-sm-3">
                    <input  class="form-control"  type="text" value="<?= set_value('bank[ifsc]', $bank->ifsc); ?>" name="bank[ifsc]">
                </div>
                
            </div>

            <div class="form-group row">
                <label class="col-sm-2"></label>
                <div class="col-sm-8">
                    <button class="btn btn-success" type="submit" name="bankd" value="submit">
                        <i class="fa fa-send"></i> SAVE
                    </button>
                   
                </div>
            </div>
        </form>

                </div>
            </div>
        </div>
</section>