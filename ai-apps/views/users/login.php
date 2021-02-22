<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
    <title>Login</title>
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link href="<?php echo base_url('assets/css/bootstrap.min.css'); ?>" rel="stylesheet" />
    <link href="<?php echo base_url('assets/fa/css/font-awesome.min.css'); ?>" rel="stylesheet" />
    <link href="<?php echo base_url('assets/css/style.css'); ?>" rel="stylesheet" />
</head>

<body>
    <div class="container" style="margin-top:120px;">
        <div class="col-sm-6 offset-sm-3">
            <div class="box">
                <div class="box-header">
                    <h6 class="box-title"><?= config_item('company') ?> Secure Login</h6>
                </div>
                <div class="box-p">
                    <?php $this->load->view('alert'); ?>
                    <form method="POST" action="<?= admin_url('users/login'); ?>" class="form-horizontal">
                        <div class="form-group row">

                            <label class="col-lg-3" for="username">Email Id:</label>
                            <div class="col-lg-6">
                                <input type="text" name="username" value="<?php echo set_value('username'); ?>" placeholder="Email Id" class="form-control input-sm" />
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-lg-3" for="password">Password:</label>
                            <div class="col-lg-6">
                                <input type="password" name="password" placeholder="Password" class="form-control input-sm" value="<?php echo set_value('password'); ?>" />
                            </div>
                        </div>
                        <div class="form-group row">
                            <div class="col-sm-6 offset-sm-3">
                                <button type="submit" value="Login" name="submit" class="btn btn-primary"><i class="fa fa-lock"></i> Login</button>
                            </div>
                        </div>
                        <?php echo form_close(); ?>
                </div>
                <div class="box-bt box-p">
                    <a href="<?= admin_url('users/forget'); ?>">Forgot Password</a>
                    <a href="<?= site_url(); ?>" class="float-right">Back to Website</a>
                </div>
            </div>
        </div>
    </div>
    </div>
    <div class="footer text-center" style="position: fixed; bottom: 0; width: 100%;"> Copyright &copy; <?php echo date('Y'); ?>. Version 1.1
    </div>
</body>

</html>