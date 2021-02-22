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
    width: 480px;
    margin-top: 20px !important;
    margin: auto;
}
  .list-box li{ margin-bottom:40px;     margin-left: -23px;  } 
  .list-box li:nth-child(odd){  float: left; } 
  .list-box li:nth-child(even){   } 

</style>
  </head>
  <!--onload="window.print();window.close()"-->
<body onload="window.print();window.close()">  
<ul class="list-box">
<?php if($this->input->get('ids')){
 $ids =  $this->input->get('ids');
 $qty =  $this->input->get('qty');
 $i=1;
 $ps = $ids%2==0?($qty/2):($qty/2)+1;
$i=1;
 for($j=1;$j<=$qty;$j++){
  $p= $this->db->get_where('products',array('id'=>$ids))->row();
  $text = $p->id.'-o';
  $cs ='';
  if($i%2==0){
      $cls = "margin-left:-80px;";
       $cls2 = "margin-left:-80px;";
       $cs ='margin-left:-80px';
  }
  else{
   $cls = "margin-left:30px;";
    $cls2 = "margin-left:25px;";
    $cs ='margin-left:25px';
  }
  $i++;
  ?>
    
  <li>
  <table class="" border="0px" cellpadding="1px" cellspacing="0px" width="240px" align="center">
    <tr>
       <td class="text-center"> 
<b class="text-center" style="display:block;<?=$cs;?>">OPSG MART - <?=$p->id?></b>
<img style="<?=$cls;?>" 
src="<?=admin_url('products/barcode?filepath=&text='.$text.'&size=36&orientation=horizontal&code_type=code128&print=false&sizefactor=2');?>"><br>
<b style="text-align:center; <?=$cls2;?>">MRP: <?=$p->price;?> BVP: <?=$p->bvp;?></b>
       </td>
    </tr>
</table> 
   </li>
<?php } } ?>
</ul>
  </body>
</html>