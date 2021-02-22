<div class="box">

    <div class="box-header">

        <h4 class="h5 box-title">Print Bill:</h4>

    </div>

    <div class="box-p">

        <div class="row">

            <div class="col-sm-12">

                <?php echo form_open(admin_url('products/print_bill/'), array('class' => 'form-horizontal','method'=>'GET')); ?>

                <div class="form-group row">
                <label class="col-sm-2">User Id</label>
                    <div class="col-sm-4">
                        <input type="text" id="userid" name="user_id" value="" class="form-control input-sm" required /> 
                    </div>
             
                </div>
                    <div class="form-group row" id="search-result">
                
                    <label class="col-sm-2">Associate Name</label>
                    <div class="col-sm-4">
                       <b> </b>
                    </div>
                    <label class="col-sm-2">Package</label>
                    <div class="col-sm-4">
                     <b>  </b> 
                       
                    </div>
                    
                </div>
              

                



               
                

                

               

                <div class="form-group row">

                    <label class="col-sm-2">&nbsp;</label>

                    <div class="col-sm-4">

                        <input type="submit" name="submit" value="Save & Print Bill" class="btn btn-primary" />

                        

                    </div>

                </div>

                <?php echo form_close(); ?>

            </div>

        </div>

    </div>

</div>
<script type="text/javascript">
    $('#userid').keyup(function(){
            
            var spid = $('#userid').val();
            var u = {
                user_id: spid
            };
            $.ajax({
                url: '<?=admin_url('products/user_info');?>',
                data: u,
                success: function(res){
                    $('#search-result').html(res);
                    $('#sponsorid').val(spid);
                },
                error: function(f){
                    console.log(f);
                }
            });
        });

</script>