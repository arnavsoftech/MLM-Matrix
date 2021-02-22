<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');?>
<form method="post" enctype="multipart/form-data" action="<?php echo admin_url('products/import_files'); ?>" class="form-horizontal">
    <div class="box">
        <div class="box-header">
            <i class="fa fa-external-link-square icon-external-link-sign"></i>
            Import File
        </div>
        <div class="box-p">
            <div class="form-group">
                <label class="control-label col-md-2">Select File <span class="symbol required"></span></label>
                <div class="col-md-6">
                    <input type="file" name="excel_file" />
                </div>
            </div>
            <div class="form-group">
                <label class="control-label col-md-2"> </label>
                <div class="col-md-2">
                    <input type="submit" name="import_btn" value="Import File" class="btn btn-sm btn-round btn-primary" />
                </div>
            </div>
        </div>
    </div>
</form>
