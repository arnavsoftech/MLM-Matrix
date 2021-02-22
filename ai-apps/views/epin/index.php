<div class="page-header">
    <a id="pageload" href="<?= admin_url('epin/add'); ?>" class="btn btn-sm btn-primary pull-right"><i class="fa fa-plus-circle"></i> Generate Epin</a>
    <h3>Epin </h3>
</div>
<div class="box p-3">
    <table class="table table-bordered table-striped data-table">
        <thead>
            <tr>
                <th>Sl No</th>
                <th>Username</th>
                <th>PIN</th>
                <th>Pin Type</th>
                <th>Status</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>

            <?php
            $sl = 1;
            foreach ($mem_list as $m) {

                $u = $this->User_model->getUserById($m->user_id);
            ?>
                <tr>
                    <td><?= $sl++; ?></td>
                    <td><?= id2userid($m->user_id); ?></td>
                    <td><?= $m->pin; ?></td>
                    <td><?= $m->pintype; ?></td>
                    <td>
                        <?php
                        if ($m->status == 1) {
                        ?>
                            <span class="badge badge-success">Not Used</span>
                        <?php
                        } else {
                        ?>
                            <span class="badge badge-danger">Used</a>
                            <?php
                        }
                            ?>
                    </td>
                    <td>
                        <?php
                        if ($m->status == 1) {
                        ?>
                            <div class="pull-right btn-group">
                                <a href="<?php echo admin_url('epin/delete/' . $m->id); ?>" class="btn btn-danger btn-sm delete"><i class="fa fa-trash"></i> </a>
                            </div>
                        <?php
                        } else {
                            $m = $this->db->get_where('users', array('epin' => $m->pin))->row();
                            $name =  $m->first_name . '(' . $m->username . ')<br />' . $m->mobile;
                        ?>
                            <a href="<?= admin_url('members/details/' . $m->id); ?>"><?= $name; ?></a>
                        <?php
                        }
                        ?>
                    </td>
                </tr>
            <?php
            }
            ?>
        </tbody>
    </table>
</div>