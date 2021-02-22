<div class="row">
    <div class="col-sm-12">
        <div class="page-header">
	        <h2>Add Items </h2>
        </div>
   
  
<?php  $ar = $this -> Product_model -> getProductsName(); 

?>


	<div class="row form-search">
		<div class="col-sm-6">
             <div class="serch_frm">
                        <form action="<?php echo admin_url('products/add_item/'.$id); ?>" method="post"  role="search">
                            <div class="input-group custom-search-form">
                                <input list="unitlist"  type="text" name="pr_name" class="form-control" placeholder="Search...">
                                <datalist id="unitlist">
                                    <?php
                                   
                                    if (is_array($ar) && count($ar) > 0) {
                                        foreach ($ar as $row) {
                                            echo '<option value="' . $row['ptitle'] . '">';
                                        }
                                    }
                                    ?>
                                </datalist>
                                <span class="input-group-btn">
                                    <button class="btn btn-search" type="submit">
                                        <i class="fa fa-search"></i>
                                    </button>
                                </span>
                            </div>
                        </form>
                    </div>
		</div>
      
	</div>

   
<form id="frmsave" method="post" action="<?= admin_url('products/add_item/'.$id); ?>">
    
    <div class="row">
        <div class="col-sm-12">
           </div>
            <table class="table table-bordered table-striped">
                <thead>
                <tr>
                   
                   
                  
                  
                   
                    <th>Product Title</th>
				
                   <!--  <th>Price</th> -->
                   
                    <th>Quantity</th>
                    <th></th>
                </tr>
                </thead>
                <tbody>
                <?php
              
                if(is_array($item) && count($item) > 0){
                    foreach($item as $p){
                       
                        ?>

                        <tr>
                           <td>
                           
                            <input   type="text" name="frm[i_name]" value="<?= $p -> ptitle; ?>" class="form-control">
                           
                           </td>
                          
                           <!--  <td><input   type="text" name="frm[i_price]" value="<?= $p -> price; ?>" class="form-control"></td> -->
							
                          
                           
                            <td><input   type="text" name="frm[i_qty]" value="<?= $p -> qty; ?>" class="form-control"></td>
                           
                            <td>
                                <div class="btn-group pull-right">
                                   
                                  <input type="submit" name="add_item" value="add Item" class="btn btn-primary"> 
                                  
                                </div>
                            </td>
                        </tr>
                    <?php
                    }
                }
                
                ?>
                </tbody>
            </table>

        </div>
   
</form>

 
        <div class="page-header">
            <h2>Package Items </h2>
        </div>
            <table class="table table-bordered table-striped">
                <thead>
                <tr>
                   
                   
                  
                  
                   
                    <th>Product Title</th>
                
                   <!--  <th>Price</th>
                    -->
                    <th>Quantity</th>
                    <th> </th>
                </tr>
                </thead>
                <tbody>
                <?php
              
                if(is_array($product) && count($product) > 0){
                    foreach($product as $i){
                       
                        ?>

                        <tr>
                          
                           
                           <td> <?= $i -> i_name; ?>   </td>
                           
                        
                          
                           <!--  <td> <?= $i -> i_price; ?>   </td> -->
                            
                          
                           
                            <td> <?= $i -> i_qty; ?>   </td>
                            <td>
                                <div class="btn-group pull-right">
                                  
                                    <a href="<?= admin_url('products/deletep?pid=' . $i -> id .'&pkd='. $id); ?>" title="Delete" class="btn btn-xs btn-danger delete"><i class="fa fa-trash"></i> </a>
                                </div>
                            </td>
                          
                        </tr>
                    <?php
                    }
                }
                
                ?>
                </tbody>
            </table>

       </div>
    
  
   