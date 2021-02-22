<h4>Manage Products</h4>
<hr>

<div class="box box-header d-flex justify-content-between align-item-between">
    <div>
        Filters: Listing status
        <label class="checkbox-inline">
            <input name="status" type="radio" value="-1" <?php if ($filter_status == 'all') echo 'checked="checked"'; ?>> All
        </label>
        <label class="checkbox-inline">
            <input name="status" type="radio" value="1" <?php if ($filter_status == 'active') echo 'checked="checked"'; ?>> Active
        </label>
        <label class="checkbox-inline">
            <input name="status" type="radio" value="0" <?php if ($filter_status == 'inactive') echo 'checked="checked"'; ?>> Inactive
        </label>
    </div>
    <a href="<?= admin_url('products/add'); ?>" class="btn btn-sm btn-primary pull-right"><i class="fa fa-plus-circle"></i> Add Product</a>
</div>
<script type="text/javascript">
    $(document).ready(function() {
        $('.box-status input').on('click', function() {
            var v = $(this).val();
            if (v == 1) {
                window.location.href = "<?= admin_url('products/index?status=active'); ?>"
            } else if (v == 0) {
                window.location.href = "<?= admin_url('products/index?status=inactive'); ?>"
            } else {
                window.location.href = "<?= admin_url('products/index'); ?>"
            }
        });
        $('.btn-save-all').on('click', function() {
            $('#frmsave').submit();
        });

        $('.box-status select').on('change', function() {
            document.show.submit();
        });

    });
</script>

<div class="mb-3 row form-search">
    <div class="col-sm-6">
        <form method="get" action="<?= admin_url('products'); ?>">
            <div class="input-group">
                <input type="search" name="q" value="<?= $q; ?>" placeholder="e.g Product Title, ID" class="form-control input-sm" />

                <div class="input-group-btn">
                    <button type="submit" name="btnsearch" value="Search" class="btn btn-primary"><i class="fa fa-search"></i> Search
                    </button>
                </div>
            </div>
        </form>
    </div>
    <div class="col-sm-6">
        <a href="javascript:void(0);" onclick="submit('delete')" class="btn btn-sm btn-danger action pull-right tooltips" title="Delete"> <i class="fa fa-trash"></i> Delete Selected</a>
    </div>
</div>
<div class="box box-p">
    <form id="frmsave" class="m-0" method="post" action="<?= admin_url('products/print_barcode'); ?>">
        <input type="hidden" name="frmall" value="Save All" />
        <input type="hidden" name="url" value="<?= current_url(); ?>" />
        <div class="row">
            <div class="col-sm-12">
                <table class="table table-bordered table-striped m-0">
                    <thead>
                        <tr>
                            <th class="center" width="5%">
                                <input type="checkbox" onclick="dgUI.checkAll(this)" id="select_all">
                            </th>
                            <th>Id #</th>
                            <th>Status</th>
                            <th>Image</th>

                            <th>Title</th>
                            <th>Price</th>
                            <th>BVP</th>
                            <th>Options</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        if (is_array($products) && count($products) > 0) {
                            $x = count($products);
                            foreach ($products as $p) {
                                $ob = new AI_Product($p->id);
                                $text = '';
                        ?>
                                <tr>
                                    <td class="center">
                                        <input type="checkbox" class="checkb" value="<?php echo $p->id; ?>" name="ids[]" />
                                    </td>
                                    <td><?= $p->id; ?>.</td>
                                    <td>
                                        <?php
                                        if ($p->status == 1) {
                                        ?>
                                            <a href="<?= admin_url('products/deactivate/' . $p->id, true); ?>" class="badge badge-success">Active</a>
                                        <?php
                                        } else {
                                        ?>
                                            <a href="<?= admin_url('products/activate/' . $p->id, true); ?>" class="badge badge-danger">Deactive</a>
                                        <?php
                                        }
                                        ?>
                                    </td>
                                    <td><?= $ob->image('sm', array('class' => 'img-responsive img-admin-sm', 'width' => 100)); ?></td>
                                    <td><a href="<?php echo  $ob->permalink(); ?>" target="_blank"><?= $p->ptitle; ?></a></td>
                                    <td><?= $p->price; ?></td>
                                    <td><?= $p->bvp; ?></dd>
                                    <td>
                                        <div class="btn-group pull-right">
                                            <!-- <a href="#" title="Save" class="btn btn-xs btn-warning"><i class="fa fa-save"></i> </a> -->
                                            <a href="<?= admin_url('products/add/' . $p->id); ?>" title="Edit" class="btn btn-sm btn-info"><i class="fa fa-pencil"></i> </a>
                                            <a href="<?= admin_url('products/delete/' . $p->id); ?>" title="Delete" class="btn btn-sm btn-danger delete"><i class="fa fa-trash"></i> </a>
                                        </div>
                                    </td>
                                </tr>
                        <?php
                            }
                        }
                        ?>
                    </tbody>
                </table>

            </div>
        </div>
    </form>
</div>
<div class="pagination">
    <?php echo $paginate; ?>
</div>
<script>
    var select_all = document.getElementById("select_all"); //select all checkbox
    var checkboxes = document.getElementsByClassName("checkb"); //checkbox items

    //select all checkboxes
    select_all.addEventListener("change", function(e) {
        for (i = 0; i < checkboxes.length; i++) {
            checkboxes[i].checked = select_all.checked;
        }
    });

    for (var i = 0; i < checkboxes.length; i++) {
        checkboxes[i].addEventListener('change', function(e) { //".checkbox" change
            //uncheck "select all", if one of the listed checkbox item is unchecked
            if (this.checked == false) {
                select_all.checked = false;
            }
            //check "select all" if all checkbox items are checked
            if (document.querySelectorAll('.checkbox:checked').length == checkboxes.length) {
                select_all.checked = true;
            }
        });
    }
</script>
<script type="text/javascript">
    /*$("#select_all").change(function(){

        if (!$('input:checkbox').is('checked')) {
            $('input:checkbox').prop('checked',true);
        } else {
            $('input:checkbox').prop('checked',false);
        }
    });*/


    function submit(type) {
        var ids = '';
        $('.checkb').each(function() {
            if (jQuery(this).is(':checked')) {
                if (ids == '') ids = jQuery(this).val();
                else ids = ids + '-' + jQuery(this).val();
            }
        });
        if (ids == '') {
            alert('Select Checkbox');
            return;
        }
        var r = confirm("Are you sure want to delete");
        if (r == true) {
            var url = '<?php echo admin_url('products') . '/'; ?>' + type;
            $('#frmsave').attr('action', url).submit();
        } else {
            return false;
            //alert("You are safe!");
        }

    }

    function submit1(type) {
        var ids = '';
        $('.checkb').each(function() {
            if (jQuery(this).is(':checked')) {
                if (ids == '') ids = jQuery(this).val();
                else ids = ids + '-' + jQuery(this).val();
            }
        });
        if (ids == '') {
            alert('Select Checkbox');
            return;
        }
        //var r = confirm("Are you sure want to delete");
        //if (r == true) {
        var url = '<?php echo admin_url('products') . '/'; ?>' + type;
        $('#frmsave').attr('action', url).submit();
        //}

    }
</script>