<div class="page-header">

    <h2>Blog Form</h2>

</div>

<div class="row">

    <div class="col-sm-12">

        <?php echo form_open_multipart(admin_url('posts/add-page/' . $p -> id), array('class' => 'form-horizontal')); ?>
 
        <div class="form-group row">

            <label class="col-sm-2 control-label">Title</label>



            <div class="col-sm-8">

                <input type="text" name="data[post_title]" value="<?= set_value('data[post_title]', $p -> post_title); ?>"

                       class="form-control input-sm"/>

            </div>

        </div>

       <!--  <div class="form-group row">

            <label class="col-sm-2 control-label">Category</label>



            <div class="col-sm-8">

               <?php 
                           
                           echo form_dropdown('data[parent_id]', $categories, $p -> parent_id, 'class="form-control form-category input-sm" required'); 
                        ?>

            </div>

        </div>
    -->

        <div class="form-group row">

            <label class="col-sm-2 control-label">Description</label>



            <div class="col-sm-10">

                <textarea rows="8" cols="" class="form-control input-sm ckeditor"

                          name="data[description]"><?= set_value('data[description]', $p -> description); ?></textarea>

            </div>

        </div>

        

        <div class="form-group row">

            <label class="col-sm-2 control-label">Image</label>

            <div class="col-sm-6">

                <input type="file" name="image" />

                <?php

                if ($p -> image <> '') {

                    ?>

                    <img src="<?= base_url(upload_dir($p -> image)); ?>" class="img-thumbnail img-responsive" /><br />

                    <label class="checkbox checkbox-inline"><input type="checkbox" name="del_img" value="1" /> Delete Image</label>

                    <input type="hidden" name="hid_img" value="<?= $p -> image; ?>" />



                    <?php

                }

                ?>

            </div>

        </div>

       
        <div class="form-group row">

            <label class="col-sm-2 control-label">Status</label>



            <div class="col-sm-3">

                <?php

                $st = array(

                    1 => 'Active',

                    0 => 'Deactive'

                );

                echo form_dropdown('data[status]', $st, $p -> status, 'class="form-control input-sm"');

                ?>

            </div>

        </div>

        <div class="form-group row">

            <div class="col-sm-8 offset-sm-2">

                <input type="submit" name="submit" value="Save" class="btn btn-primary" />

                <a href="<?= admin_url('posts/pages'); ?>" class="btn btn-dark">Cancel</a>

            </div>

        </div>

        <?php echo form_close(); ?>

    </div>

</div>



<script type="text/javascript">

    $('.img-preview').on('click', function (e) {

        $('.img-preview').removeClass('cover-img');

        $(this).addClass('cover-img');

        $('#cover_image').val($(this).attr('src'));

    });

</script>

