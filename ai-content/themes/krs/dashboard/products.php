<h5>Latest Products</h5>
<hr>
<div class="row">
    <?php
    foreach ($products as $ob) {
        if ($ob->image == '') {
            $img_src = 'https://placeimg.com/400/300';
        } else {
            $img_src = base_url(upload_dir($ob->image));
        }
    ?>
        <div class="col-sm-3">
            <div class="box">
                <img src="<?= $img_src; ?>" class="img-fluid" />
                <div class="p-2">
                    <h6><?= $ob->ptitle; ?></h6>
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <div style="font-weight: bold;"> <i class="fa fa-inr"></i> <?= $ob->price; ?></div>
                            <div class="text-muted small">PV: <?= $ob->bvp; ?></div>
                        </div>
                        <div>
                            <a href="#" class="btn btn-xs btn-outline-primary">BUY NOW</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    <?php
    }
    ?>
</div>
<?php // print_r($products); 
?>