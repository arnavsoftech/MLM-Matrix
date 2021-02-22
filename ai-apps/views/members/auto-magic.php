<h5>Auto Magic</h5>
<hr>
<div class="row">
    <div class="col-sm-5">
        <form action="<?= admin_url('members/add-magic/' . $id); ?>" method="post">
            <div class="box p-3">
                <div class="form-group row">
                    <label class="col-sm-12">Purchase Amount</label>
                    <div class="col-sm-10">
                        <input name="form[amount]" type="text" required class="form-control">
                    </div>
                </div>
                <?php
                $isExists = $this->db->get_where('matrix', array('user_id' => $id))->row();
                if (is_object($isExists)) {
                ?>
                    <div class="text-danger text-center"> You already in Auto Magic Matrix </div>
                <?php
                } else {
                ?>
                    <input type="submit" name="button" value="Save" class="btn btn-primary">
                    <a href="<?= admin_url('members/details/' . $id); ?>" class="btn btn-dark">Cancel</a>
                <?php
                }
                ?>

            </div>
        </form>
    </div>
    <div class="col-sm-7">
        <?php
        if (is_array($magicdata) && count($magicdata) > 0) {
        ?>
            <h5>Auto Matic History</h5>
            <div class="box box-p">
                <table class="table">
                    <thead>
                        <tr>
                            <th>Sl No</th>
                            <th>Date</th>
                            <th>Sponsor Id</th>
                            <th>Name</th>
                            <th>Position</th>
                            <th>Amount</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $sl = 1;
                        foreach ($magicdata as $ob) {
                        ?>
                            <tr>
                                <td><?= $sl++; ?></td>
                                <td><?= date('d-m-Y', strtotime($ob->created)); ?></td>
                                <td><?= $ob->username; ?></td>
                                <td><?= $ob->first_name . ' ' . $ob->last_name; ?></td>
                                <td><?= $ob->position; ?></td>
                                <td><?= $ob->amount; ?></td>
                            </tr>
                        <?php
                        }
                        ?>
                    </tbody>
                </table>
            </div>
        <?php
        }
        ?>
    </div>
</div>