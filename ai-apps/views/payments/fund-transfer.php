<h5>Fund Transfer</h5>
<hr>
<div class="row">
    <div class="col-sm-6">
        <div class="box p-3">
            <form action="<?= admin_url('payments/fund-transfer') ?>" method="post">
                <div class="form-group row">
                    <label class="col-sm-4 text-right">Select User</label>
                    <div class="col-sm-8">
                        <select required name="user_id" class="form-control">
                            <option value="">Select</option>
                            <?php
                            foreach ($users as $ob) {
                            ?>
                                <option value="<?= $ob->id; ?>"><?= $ob->first_name . ' ' . $ob->last_name . ' (' . $ob->username . ')'; ?></option>
                            <?php
                            }
                            ?>
                        </select>
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-sm-4 text-right">Amount</label>
                    <div class="col-sm-4">
                        <input required type="number" name="amount" class="form-control">
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-sm-4 text-right"></label>
                    <div class="col-sm-4">
                        <input type="submit" name="submit" value="SEND" class="btn btn-primary">
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    $(document).ready(function() {
        $('select').select2();
    });
</script>