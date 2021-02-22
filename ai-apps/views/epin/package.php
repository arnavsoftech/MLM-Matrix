<h5>Package PIN</h5>
<hr>
<div class="row">
    <div class="col-sm-5">
        <div class="box">
            <div class="box-p">
                <?php echo form_open(admin_url('epin/package'), array('class' => 'form-horizontal')); ?>
                <div class="form-group row">
                    <label class="col-sm-3 text-right">User id</label>
                    <div class="padrit col-sm-8">
                        <?php
                        // print_r($us);
                        $arr = array();
                        foreach ($us as $u) {
                            $arr[$u->id] = $u->first_name . " " . $u->last_name . "(" . $u->username . ')';
                        }
                        echo form_dropdown('user_id', $arr, set_value('user_id'), 'class="form-control newenqcl" required');
                        ?>
                    </div>
                </div>
                <div class="form-group row">
                    <label class="text-right col-sm-3">Quantity</label>
                    <div class="padrit col-sm-8">
                        <input type="text" name="quantity" value="" class="form-control input-sm" />
                    </div>
                </div>

                <div class="form-group row">
                    <label class="col-sm-3"></label>
                    <div class="col-sm-8">
                        <input type="submit" name="submit" value="Submit" class="btn btn-primary" />
                        <a href="<?= admin_url('epin'); ?>" class="btn btn-dark">Cancel</a>
                    </div>
                </div>
                <?php echo form_close(); ?>
            </div>
        </div>
    </div>
</div>

<div class="box box-p table-responsive">
    <table class="table data-table">
        <thead>
            <tr>
                <th>Sl no</th>
                <th>Name</th>
                <th>Code</th>
                <th>Date</th>
                <th>Status</th>
            </tr>
        </thead>
        <tbody>
            <?php
            $sl = 1;
            foreach ($ar_packages as $pack) {
                $us = $this->db->get_where('users', array('id' => $pack->user_id))->row();
            ?>
                <tr>
                    <td><?= $sl++; ?></td>
                    <td>
                        <a href="<?= admin_url('members/details/' . $us->id); ?>">
                            <?= $us->first_name . ' ' . $us->last_name . '(' . $us->username . ')'; ?>
                        </a>
                    </td>
                    <td><?= $pack->pcode; ?></td>
                    <td><?= date('d M Y', strtotime($pack->created)); ?></td>
                    <td><?= ($pack->status) ? '<span class="badge badge-success">Active</span>' : '<span class="badge badge-danger">Active</span>'; ?></td>
                </tr>
            <?php
            }
            ?>
        </tbody>
    </table>
</div>