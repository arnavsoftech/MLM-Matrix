<h5>Add Purchase</h5>
<hr>
<div class="row">
    <div class="col-sm-5">
        <form action="<?= admin_url('members/add-purchase/' . $id); ?>" method="post">
            <div class="box p-3">
                <div class="form-group row">
                    <label class="col-sm-12">Purchase Amount</label>
                    <div class="col-sm-10">
                        <input name="form[amount]" type="text" required class="form-control">
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-sm-12">Point Value</label>
                    <div class="col-sm-6">
                        <input name="form[pv]" type="text" required class="form-control">
                    </div>
                </div>
                <input type="submit" name="button" value="Save" class="btn btn-primary">
                <a href="<?= admin_url('members/details/' . $id); ?>" class="btn btn-dark">Cancel</a>
            </div>
        </form>
    </div>
</div>