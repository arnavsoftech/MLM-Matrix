<?php
if($msg <> ''){
    ?>
    <div style="color: green; padding: 10px; border: solid 1px greenyellow; margin-bottom: 5px;"><?php echo $msg; ?></div>
    <?php
}
?>
<script src="<?php echo base_url ('js/jquery-1.10.2.min.js'); ?>"></script>
<form id="frmupload" method="post" enctype="multipart/form-data" action="<?= admin_url('products/ajax-upload'); ?>">
    <input type="file" name="filesToUpload[]" multiple />
    <input type="submit" id="btnsubmit" name="submit" value="Submit" style="display: none;" />
</form>
<script type="text/javascript">
    $(document).ready(function(){
        $('#frmupload').on('change', function(){
            $('#btnsubmit').trigger('click');
        });
    });
</script>