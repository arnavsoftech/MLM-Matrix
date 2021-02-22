
<!DOCTYPE HTML>
<html>
    <head>
        <title>Invoice | opsgmart</title>
    <link href="<?php echo base_url ('assets/os/css/bootstrap.min.css'); ?>" rel="stylesheet" type="text/css"/>
    <link href="<?php echo base_url ('assets/fa/css/font-awesome.css'); ?>" rel="stylesheet" type="text/css"/>
   
    
    <script src="<?php echo base_url ('js/jquery-1.10.2.min.js'); ?>"></script>
    <script src="<?php echo base_url ('js/jquery-ui.js'); ?>"></script>
    <script src="<?php echo base_url ('js/bootstrap.min.js'); ?>"></script>
    <style>
    .invoice{

}
.invoice-slip{
    margin: auto;
    padding-top: 55px;
}
.invoice-slip .card{
    border: 1px solid #989898;
}
.invoice-slip .card .card-header{
    background: #fff;
    border-bottom: none;
    text-align: center;
}
.invoice-slip .card .card-header h4{
    font-size: 20px;
    color: #545454;
}
.invoice-slip .card .card-header p{
     margin: 0px;
    font-size: 16px;
    color: #545454;

}
.invoice-slip .card .card-body p{
    font-weight: 400;
    font-size: 14px;
}
.user-id{
    float: left;
}
.dop p{
    float: right;
}

.item-list .table .thead-light th {
    border:1px solid #adadad;
    font-size: 13px;
}
.item-list .table-bordered td, .table-bordered th {
    border: 1px solid #adadad;
}
.item-list tbody tr td{
        font-size: 13px;
}
.item-list tbody tr td span{
    float: right;
}
.print{
    text-align: center;
}
.btn-success {
    color: #28a745;
    background-color: #fff;
    border-color: #28a745;
    border: 2px solid;
}
</style>
    </head>
    <body>
        <div class="invoice">
            <div class="container">
                <div class="row">
                        <div class="invoice-slip">
                            <div class="card">
                                <div class="card-header">
                                    <h4>OPSG Marketing Pvt. Ltd.</h4>
                                    <p>Piper Toli, Argora, Ranchi</p>
                                    <p>Billing Center: <?=ucfirst($center);?></p>
                                </div>
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-sm-6 user-id">
                                            <p>User Id: <?=ucfirst($username);?></p>
                                        </div>
                                        <div class="col-sm-6 dop">
                                            <p>Date: <?=date('d-m-Y');?></p>
                                        </div>
                                    </div>
                                    <div class="item-list">
                                        <div class="table-responsive">
                                            <table class="table table-bordered">
                                                <thead class="thead-light">
                                                  <tr>
                                                    <th>Sl.No.</th>
                                                    <th>Item</th>
                                                    <th>Quantity</th>
                                                    <th>Rate</th>
                                                    <th>Amount</th>
                                                    <th>BVP</th>
                                                  </tr>
                                                </thead>
                                                <tbody>
                                                <?php  $i=1; $total=$bvp=0;
                                                if(is_array($print) and count($print)>0){
                                                foreach($print as $p){
                                                $total = $total + $p->total;
                                                $bvp = $bvp + $p->bvp;
                                                ?> 
                                                  <tr>
                                                    <td><?=$i++;?></td>
                                                    <td><?=$p->item_name;?></td>
                                                    <td><?=$p->qty;?></td>
                                                    <td><?=$p->rate;?></td>
                                                    <td><?=$p->total;?></td>
                                                    <td><?=$p->bvp;?></td>
                                                  </tr>
                                                 <?php } } ?> 


                                                  <tr>
                                                    <td colspan="4"><b><span>Total<span></b></td>
                                                    <td><?=number_format($total,2);?></td>
                                                    <td><?=number_format($bvp,2);?></td>
                                                  </tr>
                                                   <!-- <tr>
                                                    <td><b>In word</b></td>
                                                    <td colspan="5">One Hundred Only/-</td>
                                                  </tr> -->
                                                </tbody>
                                            </table>
                                        </div>
                                        <div class="print">
                                            <button type="button" class="btn btn-success" name="print" value=" " onclick="window.print();"><i class="fa fa-print" aria-hidden="true">&nbsp;&nbsp;</i>Print</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                </div>
            </div>
        </div>
       
    </body>
</html>

