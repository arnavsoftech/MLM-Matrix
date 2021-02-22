<h5>Activate Account</h5>
<hr />

<div class="row">
    <div class="col-sm-6 m-auto">
        <form action="<?= site_url('dashboard/search'); ?>" method="POST">
            <div class="box">
                <div class="box-p">
                    <div class="row">
                        <div class="col-sm-9">
                            <input type="text" placeholder="Enter Name, Username or Mobile no" class="form-control">
                        </div>
                        <div class="col-sm-3">
                            <input type="submit" value="Search" name="search" class="btn btn-block btn-primary">
                        </div>
                    </div>
                </div>
            </div>
        </form>
        <div class="box">
            <div class="box-p" ng-controller="PinCtrl">
                <form class="form-horizontal" method="POST" action="<?= site_url('dashboard/activate/' . $user->id); ?>">
                    <p><b>User Details: </b></p>
                    <div style="border: dashed 1px #DDD; font-size: 12px; background: #EEE; padding: 10px; border-radius: 3px; margin-bottom: 20px;">
                        <b>Name: </b><?= $user->first_name . ' ' . $user->last_name; ?><br />
                        <b>Mobile: </b><?= $user->mobile; ?><br />
                        <b>Username: </b><?= $user->username; ?>
                    </div>
                    <div class="form-group row">
                        <label class="col-sm-4 control-label">Pin <span class="required">*</span> </label>
                        <div class="col-md-6">
                            <input class="form-control form-control-sm" required type="text" placeholder="Activation Pin" name="epin">
                        </div>
                    </div>

                    <div class="form-group row">
                        <div class="col-sm-4"></div>
                        <div class="col-md-8">
                            <button class="btn btn-sm btn-success" type="submit" name="submit" value="Activate">Activate Now</button>
                            <button type="reset" class="btn btn-sm btn-danger">Cancel</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
        <div class="box bg-danger text-white">
            <div class="box-p text-center">
                Don't have Activation PIN ? <a class="text-warning" href="<?= site_url('dashboard/pin-list') ?>">Click here</a>
            </div>
        </div>
    </div>
</div>