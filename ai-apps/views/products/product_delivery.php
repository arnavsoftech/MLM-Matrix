<div class="page-header">
    
      
      <h3>Search Product Delivery Report</h3>
     


</div>

<form method="get" action="<?= admin_url('products/delivery_report'); ?>">
 <div class="row form-group">
   <div class="col-sm-1">
    <label> From </label>
   </div>
   <div class="col-sm-3">
       <input type="date" name="from" class="form-control" value="<?=$this->input->get('from');?>">
   </div>

   <div class="col-sm-1">
    <label> To </label>
   </div>
   <div class="col-sm-3">
       <input type="date" name="to" value="<?=$this->input->get('to');?>" class="form-control">
   </div>
   <div class="col-sm-2">
       <input class="btn btn-primary" type="submit" name="" value="Search">
   </div>
   <div class="col-sm-2">
       <input class="btn btn-primary" type="submit" name="export" value="Export Report">
   </div>
  </div>

  <div class="row form-group">
 
   
      
  </div>
  </form>




    <div class="row form-search">

        <div class="col-sm-6">

        </div>

        <div class="col-sm-6">

         
        </div>

    </div>



<div class="widget1">

    <div class="widget-head">

        <hr>

        <h3 class="text-center h6">Product Delivery Report </h3>

    </div>

    <div class="widget-content">

        <table class="table table-bordered table-striped data-table">
            <thead>
                <tr>
                    <th>Sl No</th>
                    <th>Associate</th>
                    <th>Associate Name</th>
                    <th>Package</th>
                    <th>DOJ</th>
                    <th>DOA</th>
                    <th>Deliver Date</th>
                    <th>comment</th>
                    <th>Deliver</th>
                    <th>Bill</th>
                    

                </tr>
            </thead>
            <tbody>
                <?php
                $sl = 1;
                if(is_array($members) and count($members)>0){
                foreach ($members as $s) {
                  $m = $this->Master_model->getRow($s->user_id,'ai_users');
                    ?>
                    <tr>
                        <td><?= $sl++; ?></td>
                        <td><?= $m->userid; ?></td>
                        <td><?php echo $m->first_name . ' ' . $m->last_name; ?></td>
                        <?php if(@$m->package!=''){ 
                          $pack_info=$this->Package_model->getRow($m->package);
                        }?>
                        <td><?php if($m->package){ if(is_object($pack_info)) { echo @$pack_info->package; }}?></td>
                        <td><?php echo  date("Y-m-d h:i:s a",strtotime($m->join_date));?></td>
                        <td><?php echo  date("Y-m-d h:i:s a",strtotime($m->activated_date));?></td>
                         <td><?php echo  date("Y-m-d",strtotime($s->created));?></td>
                        <td><?=$s->comment;?></td>
                        <td><?= ($s->status == 1) ? '<span class="badge badge-success">Yes</span>' : '<span class="badge badge-danger">No</span>'; ?></td>
                        <td><?php 
                        if($s->combo!=''){?>
                          <a href="<?=admin_url('products/print_bill?user_id='.$s->user_id);?>" class="btn btn-sm btn-primary">View Bill</a>
                          <?php }?></td>
                    </tr>

                <?php

            } }

            ?>

            </tbody>

        </table>

    </div>

</div>