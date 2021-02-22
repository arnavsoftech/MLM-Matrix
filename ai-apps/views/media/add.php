<div class="row">
    <div class="col-sm-6">
        <div class="box box-p">
            <h4>Upload Files</h4>
            <hr />
            <div class="formview">

                <?php echo form_open_multipart(admin_url('media/add'), array('class' => 'form-horizontal')) ?>
                   


                 <div class="form-group row">

                    <label class="col-sm-4">Select Category:</label>

                    <div class="col-sm-8">

                        <?php 
                            //echo form_dropdown('type_img', array(1 => 'Banner', 2 => 'Meeting',3 => 'Our Achievers',4=>'Training Programme'), set_value('types_img'), 'class="form-control" required');
                           echo form_dropdown('type_img', $categories, set_value('type_img'), 'class="form-control form-category input-sm" required'); 
                        ?>

                    </div>

                </div> 
                 

                <div class="form-group row">

                    <label class="col-sm-4">Title:</label>

                    <div class="col-sm-8">

                        <input type="text" name="title" value="<?php echo set_value('title'); ?>" class="form-control input-sm">

                    </div>

                </div>

                <div class="form-group row">

                    <label class="col-sm-4">Upload Files:</label>

                    <div class="col-sm-8">

                        <input type="file" name="filesToUpload[]" id="filesToUpload" multiple="" onChange="makeFileList();" />

                        <p><strong>Files You Selected:</strong></p>

                        <ul id="fileList"><li>No Files Selected</li></ul>

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

                <div class="form-group row">

                    <label class="col-sm-4">&nbsp;</label>

                    <div class="col-sm-8">

                        <button type="submit" name="submit" class="btn btn-primary btn-sm" value="Upload">
                            <i class="fa fa-upload"></i> Upload
                        </button>

                    </div>

                </div>

                <?php echo form_close(); ?>

            </div>
        </div>
    </div>
</div>



