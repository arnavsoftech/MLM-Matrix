<section id="main-content" class=" ">
    <div class="row">
        <div class="col-lg-12">
            <section class="box">
                <header class="box-header">
                    <a href="<?= admin_url("dashboard/add-user"); ?>" class="btn btn-primary btn-xs float-right"><i class="fa fa-plus-circle"></i> Add User</a>
                    <h6 class="box-title">Users List</h6>
                </header>
                <div class="box-p">

                    <table id="example-1"class="table table-striped dt-responsive display dataTable dtr-inline">
                        <thead>
                            <tr>
                                <th>Sl</th>
                                <th>Username</th>
                                <th>Email</th>
                                <th>Role</th>
                                <th>Role</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $i = 1;
                            foreach ($list as $ky => $va) {
                                ?>
                                <tr role="row">
                                    <td><?= $i++; ?></td>
                                    <td><?= $va -> first_name . ' ' . $va -> last_name; ?></td>
                                    <td><?= $va -> email_id; ?></td>
                                    <td><?= $va -> role; ?></td>
                                    <td>
                                        <?php
                                        if ($va -> status == 1) {
                                            ?>
                                            <span class="badge badge-success">Active</span>
                                            <?php
                                        } else {
                                            ?>
                                            <span class="badge badge-secondary">Draft</span>
                                            <?php
                                        }
                                        ?>
                                    </td>
                                    <td>
                                        <a href="<?= admin_url("dashboard/add-user/" . $va -> id); ?>" class="btn btn-xs btn-primary"><i class="fa fa-pencil"></i> Edit</a>
                                    </td>
                                </tr>
                            <?php } ?>
                        </tbody>
                    </table>
                </div>
            </section>
        </div>
    </div>
</section>