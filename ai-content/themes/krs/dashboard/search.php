<h5>Search Account for Activation</h5>
<hr />

<div class="row">
    <div class="col-sm-8 m-auto">
        <form action="<?= site_url('dashboard/search'); ?>" method="POST">
            <div class="box">
                <div class="box-p">
                    <div class="row">
                        <div class="col-sm-9">
                            <input type="text" name="q" placeholder="Enter Name, Username or mobile no" class="form-control">
                        </div>
                        <div class="col-sm-3">
                            <input type="submit" value="Search" name="search" class="btn btn-block btn-primary">
                        </div>
                    </div>
                </div>
            </div>
        </form>
        <?php
        if (count($users) > 0) {
        ?>
            <div class="box">
                <div class="box-p">
                    <table class="table">
                        <thead>
                            <tr>
                                <th>Sl</th>
                                <th>User Details</th>
                                <th>Joining Date</th>
                                <th>Mobile no</th>
                                <th>Option</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $sl = 1;
                            foreach ($users as $ob) {
                            ?>
                                <tr>
                                    <td><?= $sl++; ?></td>
                                    <td><?= $ob->first_name . '  ' . $ob->last_name . ' (' . $ob->username; ?>)</td>
                                    <td><?= date('jS M, Y', strtotime($ob->join_date)); ?></td>
                                    <td><?= $ob->mobile; ?></td>
                                    <td>
                                        <?php
                                        if ($ob->ac_status == 1) {
                                            echo '<span class="badge badge-dark">Active</span>';
                                        } else {
                                        ?>
                                            <a href="<?= site_url('dashboard/activate/' . $ob->id); ?>" class="btn btn-xs btn-outline-light">Activate</a>
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
            </div>
        <?php
        }
        ?>
    </div>
</div>