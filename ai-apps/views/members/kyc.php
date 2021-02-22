<style>
    .img-fluid {
        max-width: 100%;
        height: auto;
    }

    .img-size {
        height: 100px;
        width: 100;
    }
</style>

<div class="page-header">
    <h3>New Registered Members </h3>
</div>





<table class="table table-bordered table-striped">
    <tbody>
        <tr>
            <th>Username</th>
            <th> Photo</th>
            <th>Pancard</th>
            <th>Adhar front</th>
            <th>Adhar Back</th>
            <th>Passbook</th>
            <th>Action</th>
        </tr>
        <?php
        foreach ($doc as $d) {
        ?>
            <tr>

                <td><?php echo  $d->username; ?></td>
                <td><img onerror="this.src='<?= base_url(upload_dir('default.png')) ?>'" class="img-fluid img-size" src="<?= site_url(upload_dir($d->image)); ?>"></td>
                <td><img onerror="this.src='<?= base_url(upload_dir('default.png')) ?>'" class="img-fluid img-size" src="<?= site_url(upload_dir($d->pan)) ?>"></td>
                <td><img onerror="this.src='<?= base_url(upload_dir('default.png')) ?>'" class="img-fluid img-size" src="<?= site_url(upload_dir($d->aadharf)) ?>"></td>
                <td><img onerror="this.src='<?= base_url(upload_dir('default.png')) ?>'" class="img-fluid img-size" src="<?= site_url(upload_dir($d->aadharb)) ?>"></td>
                <td><img onerror="this.src='<?= base_url(upload_dir('default.png')) ?>'" class="img-fluid img-size" src="<?= site_url(upload_dir($d->passbook)) ?>"></td>
                <td>
                    <div class="pull-right btn-group">
                        <a href="<?= admin_url('members/edit_image/' . $d->id); ?>" class="btn btn-primary btn-sm"><i class="fa fa-pencil"></i></a>
                    </div>
                </td>
            </tr>
        <?php
        }
        ?>
    </tbody>
</table>