<div class="body-inner">
    <section class="main-container" id="main-container">
        <div class="container py-5">
            <div class="row">
                <div class="col-sm-6 m-auto">
                    <?php $this->load->view("alert.php"); ?>
                    <div class="box border">
                        <div class="box-p p-3">
                            <h1 class="h4">Account Login</h1>
                            <hr>
                            <form class="form-horizontal" method="POST" action="<?= site_url('login'); ?>">
                                <form method="post" action="<?= site_url('home/login'); ?>">
                                    <div class="form-floating mb-3">
                                        <label>Username</label>
                                        <input class="form-control" placeholder="Username" type="text" name="data[userid]">

                                    </div>
                                    <div class="form-floating mb-3">
                                        <label>Password</label>
                                        <input class="form-control" placeholder="Password" type="password" name="data[passwd]">

                                    </div>
                                    <div class="form-group">
                                        <input type="submit" class=" btn btn-primary" name="submit" value="LOGIN">
                                    </div>
                                    Forgot your password? <a href="<?= site_url('reset'); ?>">Click here</a>
                                </form>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>