<div class="container">
    <div class="row py-4">
        <div class="col-lg-12">
            <div class="table-responsive tbl_responsive">
                <table class="table table-striped table-bordered tbl_plan">
                    <thead>
                        <tr class="">
                            <th colspan="10">
                                <div class="tree_box">
                                    <div class="img_tr">
                                        <?php if ($id) {
                                            $me = $this->User_model->getUserById($id);
                                        } ?>
                                        <?php if ($me->image != '') {
                                        ?>
                                            <img class="img-profile rounded-circle" src="<?= site_url(upload_dir($me->image)); ?>" title="<?= $me->first_name . ' ' . $me->last_name ?>">
                                        <?php } else { ?>
                                            <img class="img-profile rounded-circle" src="<?= site_url('assets/img/avg.png'); ?>" title="<?= $me->first_name . ' ' . $me->last_name ?>">
                                        <?php } ?>
                                    </div>
                                    <div class="tr_details">
                                        <p>
                                            <span> Username: <?= $me->username; ?> </span>
                                            <span> Id: <?= $me->id; ?> </span>
                                            <span> Name:<?= $me->first_name . ' ' . $me->last_name; ?> </span>
                                            <span> Mobile: <?= $me->mobile; ?> </span>
                                        </p>
                                    </div>
                                </div>
                            </th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $member = ($this->User_model->getDirectChild($me->id));
                        ?>
                        <tr>
                            <?php
                            foreach ($member as $me) {
                                $me = $this->db->get_where('users', array('id' => $me->id))->row();
                            ?>
                                <td>
                                    <a href="<?= site_url('dashboard/member_tree/' . $me->id); ?>">
                                        <div class="tree_box">
                                            <div class="img_tr">
                                                <?php if ($me->image != '') { ?>
                                                    <img class="img-profile rounded-circle" src="<?= site_url(upload_dir($me->image)); ?>" title="<?= $me->first_name . ' ' . $me->last_name ?>">
                                                <?php } else { ?>
                                                    <img class="img-profile rounded-circle" src="<?= site_url('assets/img/avg.png'); ?>" title="<?= $me->first_name . ' ' . $me->last_name ?>">
                                                <?php } ?>
                                            </div>
                                            <div class="tr_details">
                                                <p>
                                                    <span> Username:<?= $me->username; ?> </span>

                                                    <span> Name: <?= $me->first_name . ' ' . $me->last_name; ?> </span>
                                                    <span> Mobile: <?= $me->mobile; ?> </span>
                                                    <span> Total Downline:
                                                        <?php
                                                        $sub_member = count($this->User_model->getDownloadLineIds($me->id));
                                                        echo $sub_member;
                                                        ?>
                                                    </span>

                                                </p>
                                            </div>
                                        </div>
                                </td>
                            <?php
                            }
                            ?>







                        </tr>

                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>