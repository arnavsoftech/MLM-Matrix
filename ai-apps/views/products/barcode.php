<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8"> 
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
<style type="text/css">
.list-box {
    list-style: none;
    padding: 0px;
    margin: 0px;
    width: 540px;
    margin: auto;
}
  .list-box li{ margin-bottom: 10px;   } 
  .list-box li:nth-child(odd){  float: left; } 
  .list-box li:nth-child(even){   } 

</style>
  </head>
  <!--onload="window.print();window.close()"-->
  <body onload="window.print();window.close()">  
<ul class="list-box">
<?php if($this->input->post('ids') and count($this->input->post('ids'))){
 $ids =  $this->input->post('ids');
 $i=1;
 foreach($ids as  $val){
  $p= $this->db->get_where('products',array('id'=>$val))->row();
  $text = $p->id.'-o';
  $cs ='';
  if($i%2==0){
      $cls = "margin-left:-42px;";
       $cls2 = "margin-left:-20px;";
       $cs ='text-align: left;';
  }
  else{
   $cls = "margin-left:8px;";
    $cls2 = "margin-left:32px;";
    $cs ='margin-left:32px';
  }
  $i++;
  ?>
    
  <li>
  <table class="" border="0px" cellpadding="1px" cellspacing="0px" width="250px" align="center">
    <tr>
       <td class="text-left"> 
<b class="text-center" style="display:block;<?=$cs;?>">OPSG MART - <?=$p->id?></b>
<img style="<?=$cls;?>" src="<?=admin_url('products/barcode?filepath=&text='.$text.'&size=40&orientation=horizontal&code_type=code128&print=false&sizefactor=2');?>"><br>
<b style="text-align:left; <?=$cls2;?>">MRP: <?=$p->price;?> BVP: <?=$p->bvp;?></b>
       </td>
    </tr>
</table> 
   </li>
<?php } }else{ echo '<h2>Please Select Product to print Barcode.!</h2>';} ?>
</ul>
  </body>
</html>