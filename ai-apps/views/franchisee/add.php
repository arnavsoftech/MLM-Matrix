<div class="page-header">
	<h2>Franchisee Order Form</h2>
</div>
<hr>
<div class="row">
    <div class="col-sm-4">
        </div>
         <div class="col-sm-4">
        </div>

 <div class="col-sm-4" >
    <a href="<?=admin_url('franchisee/add/');?>" class="btn btn-primary" style="float: right;">Add New</a>
        </div>
    </div>
<?php //echo validation_errors(); ?>
<div class="row">
    <div class="col-sm-4">
        <div class="box box-p">
            <script src="<?php echo site_url();?>assets/js/jquery.form-validator.min.js"></script>
            <?php $this -> load -> view('alert'); ?>
            <form id="fr-register" class="form-horizontal" method="POST" action="<?= admin_url('franchisee/add/'.$id);?>">
                <div class="form-group">
                    <div class="col-sm-12">
                        <label>Product</label>
                      <?php echo form_dropdown('f[product_id]',$p,$f->product_id,'class="form-control" id="product_id"'); ?>  
                    </div>
                </div>
                <div class="form-group">
                    <div class="col-sm-12">
                        <label>Quantity</label>
                        <input type="quantity" name="f[qty]" value="<?=set_value('f[qty]',$f->qty);?>" class="form-control">
                    </div>
                </div>

                <div class="form-group">
                    <label class="col-md-12">Franchisee </label>
                    <div class="col-md-12">
                       <?php echo form_dropdown('f[user_id]',$u,$f->user_id,'class="form-control"'); ?>

                        

                    </div>
                </div>

               

                <div class="form-group">
                    <div class="col-sm-12">
                        <button class="btn btn-primary btn-sm col-sm-12" type="submit" name="reg" value="Register">Submit</button>
                       
                    </div>
                </div>

            </form>
            
        </div>
    </div>
</div>

<!-- <script type="text/javascript">
    $('#product_id').change(function () {
        var product_id = $('#product_id').val();
        //alert(state_id);
        $.ajax({
            type: "POST",
            url: "<?php echo admin_url('franchisee/quantity'); ?>",
            data: 'id=' + product_id,
            success: function (f) {
                $('#product_id').val(f);
            }
        });
    });

</script> -->