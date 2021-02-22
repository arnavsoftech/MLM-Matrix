<div class="row">
    <div class="col-sm-6">
        <h5><?= $title ?></h5>
    </div>
    <div class="col-sm-6 text-right"><a href="<?= site_url('dashboard/income_detail/' . $type) ?>" class="btn btn-sm btn-primary"><?= $title ?> Detail Report</a></div>
</div>
<hr />
<div class="row">
    <div class="col-sm-12">
        <div class="box">
            <div class="table-responsive">
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>Sl No</th>
                            <th>Level</th>
                            <th>Amount</th>
                            <th>Admin(<?= config_item('admin_charge') ?>%)</th>
                            <th>TDS(<?= config_item('tds_charge') ?>%)</th>
                            <th>Bonanza offer(<?= config_item('extra_charge') ?>%)</th>
                            <th>Net Amount</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $sl = 1;
                        $admin = config_item('admin_charge');
                        $tds = config_item('tds_charge');
                        $ext = config_item('extra_charge');
                        if (is_array($arorders) && count($arorders) > 0) {
                            foreach ($arorders as $ob) {
                                $total = $this->db->select('sum(amount) as total')->get_where('transaction', array('user_id' => user_id(), 'notes' => $type))->row()->total;
                        ?>
                                <tr>
                                    <td><?= $sl++; ?></td>

                                    <td><?= $ob->paylevel ?></td>
                                    <td><?= $total > 0 ? $total : 0; ?></td>
                                    <td><?= $total > 0 ? ($total * $admin) / 100 : 0; ?></td>
                                    <td><?= $total > 0 ? ($total * $tds) / 100 : 0; ?></td>
                                    <td><?= $total > 0 ? ($total * $ext) / 100 : 0; ?></td>
                                    <td><?= $total > 0 ? $total - ($total * ($admin + $tds + $ext)) / 100 : 0; ?></td>
                                </tr>
                        <?php
                            }
                        }
                        ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>