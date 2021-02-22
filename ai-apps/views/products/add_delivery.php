<div class="box">

    <div class="box-header">

        <h4 class="h5 box-title">Add Product Delivery:</h4>

    </div>

    <div class="box-p">

        <div class="row">

            <div class="col-sm-12">

                <?php echo form_open(admin_url('products/add_delivery/' . $m->id), array('class' => 'form-horizontal')); ?>

                <div class="form-group row">
                <label class="col-sm-2">User Id</label>
                    <div class="col-sm-4">
                        <input type="text" id="userid" name="user_id" value="<?php echo ($m->user_id); ?>" class="form-control input-sm" required /> 
                    </div>
             
                </div>
                    <div class="form-group row" id="search-result">
                
                    <label class="col-sm-2">Associate Name</label>
                    <div class="col-sm-4">
                       <b> <?= $u;?></b>
                    </div>
                    <label class="col-sm-2">Package</label>
                    <div class="col-sm-4">
                     <b>  <?= $package_name;?> </b> 
                       
                    </div>
                    
                </div>
              <!--  <div class="form-group row">
                  <?php $s = $this->db->get_where('ai_product_gst')->result(); ?>  

                    <label class="col-sm-2">Select Combo Items</label>
                    <div class="col-sm-10">
                        <?php 
                            $com = json_decode($m->combo,true);

                        foreach ($s as $k) {
                            $check = @in_array($k->id,$com)?'checked':'';
                        ?>
                        <div class="form-check form-check-inline" style="padding:0px 40px 17px 2px; cursor:pointer;">
                            <input type="checkbox" name="gst[]" <?= $check;?> id="<?php echo $k->id;?>" value="<?php echo $k->id;?>" class="form-check-input" style="width:40px;height:15px;">
                             <label class="form-check-label" for="<?php echo $k->id;?>"><?php echo $k->name;?></label> 
                        </div>
                    <?php } ?>
                    </div>
                    
                </div> -->

                <div class="form-group row">
                    

                    <label class="col-sm-2">Delivery Date</label>
                    <div class="col-sm-4">
                        <input type="date" name="frm[created]" value="<?php echo $m->created; ?>" class="form-control input-sm" required>
                    </div>
                    
                </div>

 <div class="form-group row">
                    <label class="col-sm-2">Delivery</label>
                    <div class="col-sm-4">
                       <?php
                       $arr = array('1'=>'Yes','2'=>'No');
                       echo form_dropdown('frm[status]',$arr,$m->status,'class="form-control"');
                       ?>
                       
                    </div>

                    
                    
                </div>



                <div class="form-group row">

                    <label class="col-sm-2">Notes</label>
                    <div class="col-sm-4">
                        <textarea row="5" class="form-control" name="frm[comment]"><?=$m->comment;?> </textarea>
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