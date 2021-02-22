<div class="row">
    <div class="col-sm-12">
        <?php
        if($this -> session -> flashdata('success')){
            ?>
            <div class="alert alert-success">
                <a class="close" data-dismiss="alert" href="#" aria-hidden="true">&times;</a>
                <?php echo $this -> session -> flashdata('success'); ?>
            </div>
        <?php
        }
        ?>
        <?php
        if($this -> session -> flashdata('info')){
            ?>
            <div class="alert alert-info">
                <a class="close" data-dismiss="alert" href="#" aria-hidden="true">&times;</a>
                <?php echo $this -> session -> flashdata('info'); ?>
            </div>
        <?php
        }
        ?>
        <?php
        if($this -> session -> flashdata('error')){
            ?>
            <div class="alert alert-danger">
                <a class="close" data-dismiss="alert" href="#" aria-hidden="true">&times;</a>
                <?php echo $this -> session -> flashdata('error'); ?>
            </div>
        <?php
        }
        ?>
        <?php
        if($this -> session -> flashdata('warning')){
            ?>
            <div class="alert alert-warning">
                <a class="close" data-dismiss="alert" href="#" aria-hidden="true">&times;</a>
                <?php echo $this -> session -> flashdata('warning'); ?>
            </div>
        <?php
        }
        ?>
        <?php
        $err = validation_errors();
        if($err){
            ?>
            <div class="alert alert-danger">
                <?php echo $err; ?>
            </div>
        <?php
        }
        ?>
    </div>
</div>
