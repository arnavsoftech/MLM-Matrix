<div class="page-header">
    <h4>Upload Multiple Files</h4>
</div>
<?php echo form_open_multipart(admin_url('gallery/multiple/' . $id), array('id' => 'frmupload', 'class' => 'form-horizontal')); ?>
<div class="form-group">
    <label class="col-lg-2">Title : </label>

    <div class="col-lg-3">
        <input type="text" name="title" value="<?php echo set_value('title'); ?>" class="form-control input-sm"/>
    </div>
</div>
<div class="form-group">
    <label class="col-lg-2">Upload Files:</label>

    <div class="col-lg-3">
        <input type="file" name="filesToUpload[]" id="filesToUpload" multiple="" onChange="makeFileList();"/>

        <p><strong>Files You Selected:</strong></p>
        <ul id="fileList">
            <li>No Files Selected</li>
        </ul>
    </div>
</div>
<script type="text/javascript">
    function makeFileList() {
        var input = document.getElementById("filesToUpload");
        var ul = document.getElementById("fileList");
        while (ul.hasChildNodes()) {
            ul.removeChild(ul.firstChild);
        }
        for (var i = 0; i < input.files.length; i++) {
            var li = document.createElement("li");
            li.innerHTML = input.files[i].name;
            ul.appendChild(li);
        }
        if (!ul.hasChildNodes()) {
            var li = document.createElement("li");
            li.innerHTML = 'No Files Selected';
            ul.appendChild(li);
        }
    }
</script>
<div class="form-group">
    <div class="col-lg-4 col-lg-offset-2">
        <input type="hidden" name="submit" value="Save"/>
        <button type="submit" class="btn btn-primary btn-sm"><i class="fa fa-upload"></i> Upload
        </button>
        <a href="<?php echo admin_url('gallery'); ?>" class="btn btn-dark btn-sm"><i class="fa fa-close"></i> Cancel</a>
    </div>
</div>
</form>
