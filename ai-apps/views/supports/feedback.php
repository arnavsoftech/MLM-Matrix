<div class="page-header">
    <h4>Feedback</h4>    
</div>
<div class="box">
    <div class="box-p">
        <table id="data-table-ajax" class="table table-bordered table-striped">
            <thead>
                <tr>
                    <th>#Id</th>
                    <th>Student name</th>
                    <th>Email Id</th>
                    <th>Description</th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
                <?php
                if(is_array($datalist) && count($datalist) > 0){
                    foreach($datalist as $ob){
                        ?>
                        <tr>
                            <td><?= $sl++; ?></td>
                            <td><?= $ob -> name; ?></td>
                            <td><?= $ob -> email; ?></td>
                            <td><?= $ob -> description; ?></td>
                            <td class="text-center">
                                <a href="#" data-id="<?= $ob -> id; ?>" data-table="ai_feedback" class="btn btn-xs btn-danger ajax-delete"> <i class="fa fa-trash" aria-hidden="true"></i> </a>
                                <a href="<?= admin_url('supports/reply/' . $ob -> id); ?>" class="btn btn-xs btn-info"> <i class="fa fa-reply"></i> </a>
                            </td>
                        </tr>
                        <?php 
                    }
                }
                ?>
            </tbody>
        </table>
    </div>
</div>
<div class="pagination pagination-small">
    <?= $this->page_links; ?>
</div>