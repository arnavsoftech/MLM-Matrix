<div class="page-header">
    <h4>Supports Enquiry</h4>
</div>

<div class="box">
    <div class="box-p">
        <table class="table data-table table-bordered table-striped">
            <thead>
                <tr>
                    <th>#Id</th>
                    <th>Subject</th>
                    <th>User Information</th>
                    <th>Created</th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
                <?php
                $u = $this->session->userdata();
                $admin = $this->db->get_where('ai_admin', array('id' => $u['userid']))->row();
                // print_r($admin);
                if (is_array($datalist) && count($datalist) > 0) {
                    foreach ($datalist as $d) {
                        ?>
                        <tr>
                            <td><?= $d->id; ?></td>
                            <td><?= $d -> subject; ?></td>
                            <td></td>
                            <td><?= date('d-m-y', strtotime($d -> created)); ?></td>
                            <td>
                                <div class="btn-group pull-right">
                                    <a href="<?= admin_url("supports/views/" . $d->id); ?>" title="Edit" class="btn btn-xs btn-info"><i class="fa fa-reply"></i> </a>
                                    <a data-id="<?= $d -> id; ?>" data-table="supports" href="#" title="Delete" class="btn btn-xs btn-danger ajax-delete"><i class="fa fa-trash"></i> </a>
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
</div>
<div class="pagination pagination-small">
    <?= $this->page_links; ?>
</div>