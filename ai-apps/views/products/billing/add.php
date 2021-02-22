<div class="page-header">
	<h2>Billing Form</h2>
</div>
<?php
	$v_error = validation_errors();
	if($v_error != ''){
		?>
        <div class="alert alert-danger">
        	<?php echo $v_error; ?>
        </div>
        <?php	
	}
?>
<div class="row">
  

<div class="col-sm-12">
<div class="panel panel-default"> 
  <div class="panel-body">  
<div class="form-group col-sm-12">
<div class="col-sm-2"> &nbsp; </div>
        	<label class="col-sm-2" style="font-size: 20px; padding-top: 8px;">
        	Code Here</label>
            <div class="col-sm-6">
            <input id="code" type="text" name="code" placeholder="Enter Code Here" value="<?php  echo set_value('code'); ?>" onkeypress="add_bill(event);" class="form-control input-lg billchange" />
            </div>
<div class="col-sm-2"> &nbsp; </div>
        </div>

  </div>
</div>
</div>
<?php echo form_open_multipart($this -> config -> item('admin_folder').'/billing/add/'.$cat -> id, array('class' => 'form-horizontal formbill')); ?>
<div class="col-sm-12">
	
		<div class="panel panel-default"> 
  <div class="panel-body"> 
		
        <div class="form-group col-sm-12">
        	<label class="col-sm-2">Billing Center</label>
            <div class="col-sm-4">
            <select name="center_id" class="form-control form-category1 input-sm" required="">
                        <option value="">Billing Center</option>
                        <!--<option value="0">Parent</option>-->
                        <?php
                        $this->db->select('id,center');
                        $gift = $this -> db -> get('billing_center')->result();
                        if(is_array($gift) && count($gift) > 0){
                            foreach($gift as $gf){
                                ?>
                                <option value="<?= $gf -> id; ?>" <?php if($cat -> center_id == $gf -> id) echo "selected=selected"; ?>><?= $gf -> center; ?></option>
                            <?php
                            }
                        }
                        ?>
					<?php

					
					?>
                    </select>
            </div>
        </div>
        <div class="form-group col-sm-12">
        	<label class="col-sm-2">UserID</label>
            <div class="col-sm-4">
            <select name="user_id" class="form-control form-category1 input-sm" required="">
                        <option value="">User  Name</option>
                        <!--<option value="0">Parent</option>-->
                        <?php
                        $this->db->select('id,username');
                        $gift = $this -> db -> get('users')->result();
                        if(is_array($gift) && count($gift) > 0){
                            foreach($gift as $gf){
                                ?>
                                <option value="<?= $gf -> id; ?>" <?php if($cat -> user_id == $gf -> id) echo "selected=selected"; ?>><?= $gf -> username; ?></option>
                            <?php
                            }
                        }
                        ?>
					<?php

					
					?>
                    </select>
            </div>
        </div>

 		<input type="hidden" name="slno" id="slno" value="0">	
        <div class="col-sm-12">
            <table class="table table-bordered table-striped">
                <thead>
                <tr>
                   
                    <th>SL</th>
                    <th>Item Name</th>
                    <th>qty</th>
                    <th>Rate</th>
                    <th>Amount</th>
                    <th>BVP</th>
                    
                </tr>
                </thead>
                <tbody id="bill">

                </tbody>
            </table>



        </div>

        <div class="col-sm-12">
          <h3 class="pull-right"> Total Amount : <span class="text-muted" id="ttamount"></span> </h3>
        </div>
        <div class="col-sm-12" align="right" style="margin-top: 15px;">
          <button name="" type="submit" class="btn btn-primary"> Save & Print </button>
        </div>
                </div>
    </div>
    </div>
    </form>   
    </div> 

    <script>
    	function add_bill(e)
    	{
    		if(e.keyCode === 13){
    		var pid = $('#code').val();
    		var slno = $('#slno').val();
    		

    		if(pid!=''){
    		$.ajax({
        	type: 'POST',
            url: "<?=admin_url('/billing/html');?>",
            data: "pid=" + pid + '&sl='+slno,
            dataType: 'html',
            success: function (e){
             $('#bill').append(e);
             	var x = parseInt(slno) + 1;
    			$("#slno").val(x) ;
    			 $.ajax({
		            type: 'post',
		            url: '<?=admin_url('/billing/billchange');?>',
		            data: $('.formbill').serialize(),
		            success: function (p) {
		            	$('#ttamount').html(p);
		            }
		          });
         		}
     		});
    		}else{ alert('Please Enter Valid Code');}
    		}
    	}
    	function quantity(q,pid)
    	{
    		
    		$rate= $('#rate'+pid).val();
    		$bv= $('#bv'+pid).val();
			$bvp= $bv*q;
			$('#bvp'+pid).val($bvp);
    		$amount = $rate * q;
    		$('#total'+pid).val($amount);
    		 $.ajax({
		            type: 'post',
		            url: '<?=admin_url('/billing/billchange');?>',
		            data: $('.formbill').serialize(),
		            success: function (p) {
		            	$('#ttamount').html(p);
		            }
		          });
    		  
    	}

    	
    </script>
      <script type="text/javascript">
      	$(function () {

        $('.billchange').on('change', function (e) {
        	
          e.preventDefault();

         

        });

      });
      </script> 
             