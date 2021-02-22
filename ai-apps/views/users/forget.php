<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Login</title>
<link href="<?php echo base_url('css/bootstrap.min.css'); ?>" rel="stylesheet">
<link href="<?php echo base_url('css/style.css'); ?>" rel="stylesheet">
</head>

<body>
	<div class="container" style="margin-top:50px;">
    <?php
	$error = validation_errors();
	if($this -> session -> flashdata('error'))
		$error = $this -> session -> flashdata('error');
	if($error){
	?>
        <div class="alert alert-danger">
				<a class="close" data-dismiss="alert">�</a>
				<?php echo $error; ?>
        </div>
	<?php
	}
	?>
    	<div class="col-lg-6 col-lg-offset-3">
        	<div class="page-header">
			<h3>User Login</h3>
            </div>
		<?php echo form_open(admin_url('users/forget'), array('class' => 'form-horizontal')); ?>
        		<div class="form-group">
						<label class="col-lg-2" for="username">Email ID:</label>
						<div class="controls">
                            <div class="input-group">
                              <input type="text" name="email_id" class="form-control" value="<?php echo set_value('email_id'); ?>"/>
                              <span class="input-group-btn">
                                <button class="btn btn-primary" type="submit">Get Now!</button>
                              </span>
                            </div>
						</div>
				</div>
                <input type="hidden" value="Submit" name="submit"/>
				<?php echo form_close(); ?>
                <div style="text-align:center;">
				<p>Already heve password. <a href="<?php echo base_url($this -> config -> item('admin_folder').'/users/login'); ?>">Login now</a></p>
			</div>
        </div>
	</div>
    <div class="footer text-center" style="position: fixed; bottom: 0; width: 100%;">
        Copyright &copy; <?php echo date('Y'); ?>. Version 1.1
    </div>
</body>
</html>
