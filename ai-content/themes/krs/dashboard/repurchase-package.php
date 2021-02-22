<h5>Repurchase Package List</h5>
<hr>
<div class="box">
    <div class="box-p">
        <table class="table data-table">
            <thead>
                <tr>
                    <th>Sl No</th>
                    <th>Repurcase Code</th>
                    <th>Repurcase Value</th>
                    <th>Status</th>
                    <th>Apply</th>
                </tr>
            </thead>
            <tbody>
                <?php
                if (is_array($epins) && count($epins) > 0) {
                    $sl = 1;
                    foreach ($epins as $ob) {
                ?>
                        <tr>
                            <td><?= $sl++; ?></td>
                            <td>
                                <label class="btn btn-xs btn-outline-dark"><?= $ob->pcode; ?></label>
                                <span class="badge badge-dark btn-copy" data-copy="<?= $ob->pcode; ?>" style="cursor: pointer;" title="Copy"><i class="fa fa-copy"></i></span>
                            </td>
                            <td><?= $ob->pvalue; ?></td>
                            <td><?php
                                if ($ob->status == 1) {
                                    echo '<span class="badge badge-success">Active</span>';
                                } else {
                                    echo '<span class="badge badge-danger">Used</span>';
                                }
                                ?>
                            </td>
                            <td>
                                <?php
                                if ($ob->status == 1) {
                                ?>
                                    <a href="<?= site_url('dashboard/repurchase/' . $ob->pcode); ?>" class="btn btn-xs btn-primary">APPLY</a>
                                <?php
                                }
                                ?>
                            </td>
                        </tr>
                    <?php
                    }
                } else {
                    ?>
                    <tr>
                        <td colspan="4">
                            <div class="text-center p-4">
                                You Don't have any Repurchase Package.
                            </div>
                        </td>
                    </tr>
                <?php
                }
                ?>
            </tbody>
        </table>
    </div>
</div>