<h5>PIN Transfer</h5>
<hr>
<div class="row">
    <div class="col-sm-7">
        <form action="<?= site_url('dashboard/transfer') ?>" method="post">
            <div class="box">
                <div class="box-p">
                    <table class="table mb-2">
                        <thead>
                            <tr>
                                <th>Sl No</th>
                                <th>PIN</th>
                                <th>Package</th>
                                <th>Select</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $package = config_item('package');
                            if (is_array($epins) && count($epins) > 0) {
                                $sl = 1;
                                foreach ($epins as $ob) {
                            ?>
                                    <tr>
                                        <td><?= $sl++; ?></td>
                                        <td><?= $ob->pin; ?>
                                            <span class="badge badge-dark btn-copy" data-copy="<?= $ob->pin; ?>" style="cursor: pointer;" title="Copy"><i class="fa fa-copy"></i></span>
                                        </td>
                                        <td><?= $package[$ob->pintype]; ?></td>
                                        <td>
                                            <input type="checkbox" value="<?= $ob->pin; ?>" name="pinids[]">
                                        </td>
                                    </tr>
                                <?php
                                }
                            } else {
                                ?>
                                <tr>
                                    <td colspan="4">
                                        <div class="text-center p-4">
                                            You Don't have any PIN. <a href="<?= site_url('dashboard/pin-request') ?>" class="btn btn-sm btn-outline-primary">Order Now</a>
                                        </div>
                                    </td>
                                </tr>
                            <?php
                            }
                            ?>
                        </tbody>
                    </table>
                    <input type="submit" name="submit" value="Transfer Selected" class="btn btn-sm btn-primary">
                </div>
            </div>
        </form>
    </div>
</div>