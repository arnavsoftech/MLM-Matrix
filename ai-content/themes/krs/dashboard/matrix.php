<style>
    .box {
        padding: 15px;
        box-shadow: 2px 2px 2px #DDD;
        border-radius: 3px;
    }

    .box {
        background: #324fa6 !important;
    }

    .acb {
        text-align: center;
    }

    .usr {
        position: relative;
        cursor: pointer;
    }


    .usr:hover .user-details {
        display: block;
    }


    .user-details p {
        font-size: 14px;
    }


    .table tbody tr:nth-child(even) {
        background-color: #324fa6;
    }


    .user-details {


        background-color: #eee;


        width: 200px;


        position: absolute;


        z-index: 1000;


        padding: 6px;


        border-radius: 3px;


        top: 60px;


        left: 38%;


        display: none;


        box-shadow: 1px 1px 1px #4f96d5;
        text-align: left;
        background: #ffc11b;


    }


    .userinfo {
        font-size: 9px;
        background: #222;
        color: #fff;
        padding: 3px 5px;
        border-radius: 2px;
        display: inline-block;
        text-align: center;
        margin: 3px auto;
    }

    .acb img {
        width: 30px !important;
    }

    .acb a {
        font-size: 13px;
    }

    .pk img {
        width: 18px !important;
    }

    .xtable a {
        color: #fff;
        font-size: 10px;
        line-height: 1.6 !important;
        font-weight: bold;
        display: block;
    }

    @media(max-width:480px) {





        .mob-first {
            width: 50%;
        }





    }
</style>
<div class="row">
    <div class="col-sm-12">
        <div class="ui-container">
            <div class="admin_body bg-green">
                <div class="admin_body_top">
                    <div class="row">
                        <div class="col-sm-12">
                            <h5 class="admin_title text-center text-success"> Tree Structure</h5>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style type="text/css">
    .box {
        background-color: #fff !important;
    }
</style>




<div class="clearfix">&nbsp;</div>
<div class="row page-white xtable">
    <div class="col-sm-12">

        <div class="table-responsive">
            <table class="table text-center">
                <tbody>
                    <tr>
                        <td colspan="25">
                            <div class="box text-center">
                                <div> <img style="width:50px;" src="<?= site_url('assets/images/') ?>1891016.png" alt="" class="img-fluid m-auto" />
                                </div>
                                <?php
                                if (isset($_GET['parent']) and !empty($_GET['parent'])) {
                                    //  $parent = substr($_GET['parent'], strlen('TRS'));
                                    $parent = intval($_GET['parent']);
                                } elseif (isset($_GET['sp']) and !empty($_GET['sp'])) {
                                    $parent = substr($_GET['sp'], strlen('BT'));
                                    $parent = intval($parent);
                                } else {
                                    $parent  = user_id();
                                }

                                //  $parent = isset(username2id($_GET['parent'])) ? username2id($_GET['parent']) : 663;

                                $u = $this->db->get_where('users', array('id' => $parent))->row();
                                ?>
                                <?= $u->first_name . " " . $u->last_name; ?> <br> (<?= $u->username; ?>)
                            </div>
                            <div class="arrow-img text-center">
                                <img style="width: 80%;" src="<?= site_url('front/images/') ?>first.png" alt="" class="img-fluid m-auto" />
                            </div>
                        </td>
                    </tr>


                    <?php
                    $first = $second = $third = $fourth = $five = false;
                    $childs = $this->User_model->get_diamond_childs($parent, $table);
                    // print_r($childs);
                    // $u=$this->db->get_where('users',array('id'=> $childs[0]))->row();

                    if (count($childs) > 0) {
                    ?>
                        <tr class="bg-primary">
                            <td colspan="5">
                                <div class="acb">
                                    <img style="width:50px; margin:auto;   display: block;" src="<?= site_url('assets/images/') ?>1891016.png" alt="" class="img-fluid m-auto" />

                                    <?php
                                    if (isset($childs[0])) {
                                        $u = $this->db->get_where('users', array('id' => $childs[0]))->row();

                                        $str = $u->first_name . " " . $u->last_name . "<br> (" . $u->username . ")";
                                        echo anchor(site_url("dashboard/matrix/" . $table . "?parent=" . $u->id), $str);
                                        $first = $childs[0];
                                        $childs1 = $this->User_model->get_diamond_childs($first, $table);
                                    }

                                    ?>
                                </div>
                                <div class="arrow-img text-center">
                                    <img style="" src="<?= site_url('front/images/') ?>second.png" alt="" class="img-fluid m-auto" />
                                </div>
                            </td>
                            <td colspan="5">
                                <div class="user-view acb"> <img style="width:50px;  margin:auto;   display: block;" src="<?= site_url('assets/images/') ?>1891016.png" alt="" class="img-fluid m-auto" />

                                    <?php
                                    if (isset($childs[1])) {
                                        $u = $this->db->get_where('users', array('id' => $childs[1]))->row();
                                        $str = $u->first_name . " " . $u->last_name . "<br> (" . $u->username . ")";
                                        echo anchor(site_url("dashboard/matrix/" . $table . "?parent=" . $u->id), $str);
                                        $second = $childs[1];
                                    }
                                    ?> </div>
                                <div class="arrow-img text-center">
                                    <img style="" src="<?= site_url('front/images/') ?>second.png" alt="" class="img-fluid m-auto" />
                                </div>
                            </td>
                            <td colspan="5">
                                <div class="user-view acb"> <img style="width:50px;   margin:auto;  display: block;" src="<?= site_url('assets/images/') ?>1891016.png" alt="" class="img-fluid m-auto" />

                                    <?php
                                    if (isset($childs[2])) {
                                        $u = $this->db->get_where('users', array('id' => $childs[2]))->row();
                                        $str = $u->first_name . " " . $u->last_name . "<br> (" . $u->username . ")";
                                        echo anchor(site_url("dashboard/matrix/" . $table . "?parent=" . $u->id), $str);
                                        $third = $childs[2];
                                    }
                                    ?> </div>
                                <div class="arrow-img text-center">
                                    <img style="" src="<?= site_url('front/images/') ?>second.png" alt="" class="img-fluid m-auto" />
                                </div>
                            </td>
                            <td colspan="5">
                                <div class="user-view acb"> <img style="width:50px;   margin:auto;  display: block;" src="<?= site_url('assets/images/') ?>1891016.png" alt="" class="img-fluid m-auto" />

                                    <?php
                                    if (isset($childs[3])) {
                                        $u = $this->db->get_where('users', array('id' => $childs[3]))->row();
                                        $str = $u->first_name . " " . $u->last_name . "<br> (" . $u->username . ")";
                                        echo anchor(site_url("dashboard/matrix/" . $table . "?parent=" . $u->id), $str);
                                        $fourth = $childs[3];
                                    }
                                    ?> </div>
                                <div class="arrow-img text-center">
                                    <img style="" src="<?= site_url('front/images/') ?>second.png" alt="" class="img-fluid m-auto" />
                                </div>
                            </td>
                            <td colspan="5">
                                <div class="user-view acb"> <img style="width:50px;   margin:auto;  display: block;" src="<?= site_url('assets/images/') ?>1891016.png" alt="" class="img-fluid m-auto" />

                                    <?php
                                    if (isset($childs[4])) {
                                        $u = $this->db->get_where('users', array('id' => $childs[4]))->row();
                                        $val = $this->db->get_where('users', array('sponsor_id' => $u->id))->row();



                                        $str = $u->first_name . " " . $u->last_name . "<br> (" . $u->username . ")";

                                        echo anchor(site_url("dashboard/matrix/" . $table . "?parent=" . $u->id), $str);

                                        $five = $childs[4];
                                    }

                                    ?> </div>
                                <div class="arrow-img text-center">
                                    <img style="" src="<?= site_url('front/images/') ?>second.png" alt="" class="img-fluid m-auto" />
                                </div>
                            </td>
                        </tr>
                    <?php
                    } else {
                    ?>
                        <tr>
                            <td colspan="5">
                                <div class="pk">
                                    <img style="width:50px; margin:auto;   display: block;" src="<?= site_url('assets/images/') ?>1891016.png" alt="" class="img-fluid m-auto" />
                                </div>
                            </td>
                            <td colspan="5">
                                <div class="pk">
                                    <img style="width:50px; margin:auto;   display: block;" src="<?= site_url('assets/images/') ?>1891016.png" alt="" class="img-fluid m-auto" />
                                </div>
                            </td>
                            <td colspan="5">
                                <div class="pk">
                                    <img style="width:50px; margin:auto;   display: block;" src="<?= site_url('assets/images/') ?>1891016.png" alt="" class="img-fluid m-auto" />
                                </div>
                            </td>
                            <td colspan="5">
                                <div class="pk">
                                    <img style="width:50px; margin:auto;   display: block;" src="<?= site_url('assets/images/') ?>1891016.png" alt="" class="img-fluid m-auto" />
                                </div>
                            </td>
                            <td colspan="5">
                                <div class="pk">
                                    <img style="width:50px; margin:auto;   display: block;" src="<?= site_url('assets/images/') ?>1891016.png" alt="" class="img-fluid m-auto" />
                                </div>
                            </td>
                        </tr>


                    <?php   }
                    ?>
                    <?php
                    if ($first || $second || $third || $fourth || $five) {
                    ?>
                        <tr class="bg-primary">
                            <?php
                            if ($first) {
                                $childs1 = $this->User_model->get_diamond_childs($first, $table);
                                //print_r($childs1);
                                if (count($childs1) > 0) {
                            ?>
                                    <td>
                                        <div class="pk"> <img style="width:50px; margin:auto;" src="<?= site_url('assets/images/') ?>1891016.png" alt="" class="img-fluid m-auto" />
                                        </div>
                                        <?php
                                        if (isset($childs1[0])) {
                                            $u = $this->db->get_where('users', array('id' => $childs1[0]))->row();
                                            $str = $u->first_name . " " . $u->last_name . "<br> (" . $u->username . ")";
                                            echo anchor(site_url("dashboard/matrix/" . $table . "?parent=" . $u->id), $str);
                                        }
                                        ?>
                                    </td>
                                    <td>
                                        <div class="pk"> <img style="width:50px;margin:auto;" src="<?= site_url('assets/images/') ?>1891016.png" alt="" class="img-fluid m-auto" />
                                        </div>
                                        <?php
                                        if (isset($childs1[1])) {
                                            $u = $this->db->get_where('users', array('id' => $childs1[1]))->row();
                                            $str = $u->first_name . " " . $u->last_name . "<br> (" . $u->username . ")";
                                            echo anchor(site_url("dashboard/matrix/" . $table . "?parent=" . $u->id), $str);
                                        }
                                        ?>
                                    </td>
                                    <td>
                                        <div class="pk"> <img style="width:50px;margin:auto;" src="<?= site_url('assets/images/') ?>1891016.png" alt="" class="img-fluid m-auto" />
                                        </div>
                                        <?php
                                        if (isset($childs1[2])) {
                                            $u = $this->db->get_where('users', array('id' => $childs1[2]))->row();
                                            $str = $u->first_name . " " . $u->last_name . "<br> (" . $u->username . ")";
                                            echo anchor(site_url("dashboard/matrix/" . $table . "?parent=" . $u->id), $str);
                                        }
                                        ?>
                                    </td>
                                    <td>
                                        <div class="pk"> <img style="width:50px;margin:auto;" src="<?= site_url('assets/images/') ?>1891016.png" alt="" class="img-fluid m-auto" />
                                        </div>
                                        <?php
                                        if (isset($childs1[3])) {
                                            $u = $this->db->get_where('users', array('id' => $childs1[3]))->row();
                                            $str = $u->first_name . " " . $u->last_name . "<br> (" . $u->username . ")";
                                            echo anchor(site_url("dashboard/matrix/" . $table . "?parent=" . $u->id), $str);
                                        }
                                        ?>
                                    </td>
                                    <td>
                                        <div class="pk"> <img style="width:50px;margin:auto;" src="<?= site_url('assets/images/') ?>1891016.png" alt="" class="img-fluid m-auto" />
                                        </div>
                                        <?php
                                        if (isset($childs1[4])) {
                                            $u = $this->db->get_where('users', array('id' => $childs1[4]))->row();
                                            $str = $u->first_name . " " . $u->last_name . "<br> (" . $u->username . ")";
                                            echo anchor(site_url("dashboard/matrix/" . $table . "?parent=" . $u->id), $str);
                                        }
                                        ?>
                                    </td>
                                <?php
                                } else { ?>

                                    <td>
                                        <div class="pk">
                                            <img style="width:50px;  margin:auto;  display: block;" src="<?= site_url('assets/images/') ?>1891016.png" alt="" class="img-fluid m-auto" />
                                        </div>
                                    </td>
                                    <td>
                                        <div class="pk">
                                            <img style="width:50px; margin:auto;   display: block;" src="<?= site_url('assets/images/') ?>1891016.png" alt="" class="img-fluid m-auto" />
                                        </div>
                                    </td>
                                    <td>
                                        <div class="pk">
                                            <img style="width:50px; margin:auto;   display: block;" src="<?= site_url('assets/images/') ?>1891016.png" alt="" class="img-fluid m-auto" />
                                        </div>
                                    </td>
                                    <td>
                                        <div class="pk">
                                            <img style="width:50px; margin:auto;   display: block;" src="<?= site_url('assets/images/') ?>1891016.png" alt="" class="img-fluid m-auto" />
                                        </div>
                                    </td>
                                    <td>
                                        <div class="pk">
                                            <img style="width:50px; margin:auto;   display: block;" src="<?= site_url('assets/images/') ?>1891016.png" alt="" class="img-fluid m-auto" />
                                        </div>
                                    </td>
                            <?php

                                }
                            }
                            ?>

                            <!--  Second -->
                            <?php
                            if ($second) {
                                $childs1 = $this->User_model->get_diamond_childs($second, $table);
                                if (count($childs1) > 0) {
                            ?>
                                    <td>
                                        <div class="pk"> <img style="width:50px;margin:auto;" src="<?= site_url('assets/images/') ?>1891016.png" alt="" class="img-fluid m-auto" />
                                        </div>
                                        <?php
                                        if (isset($childs1[0])) {
                                            $u = $this->db->get_where('users', array('id' => $childs1[0]))->row();
                                            $str = $u->first_name . " " . $u->last_name . "<br> (" . $u->username . ")";
                                            echo anchor(site_url("dashboard/matrix/" . $table . "?parent=" . $u->id), $str);
                                        }
                                        ?>
                                    </td>
                                    <td>
                                        <div class="pk"> <img style="width:50px;margin:auto;" src="<?= site_url('assets/images/') ?>1891016.png" alt="" class="img-fluid m-auto" />
                                        </div>
                                        <?php
                                        if (isset($childs1[1])) {
                                            $u = $this->db->get_where('users', array('id' => $childs1[1]))->row();
                                            $str = $u->first_name . " " . $u->last_name . "<br> (" . $u->username . ")";
                                            echo anchor(site_url("dashboard/matrix/" . $table . "?parent=" . $u->id), $str);
                                        }
                                        ?>
                                    </td>
                                    <td>
                                        <div class="pk"> <img style="width:50px;margin:auto;" src="<?= site_url('assets/images/') ?>1891016.png" alt="" class="img-fluid m-auto" />
                                        </div>
                                        <?php
                                        if (isset($childs1[2])) {
                                            $u = $this->db->get_where('users', array('id' => $childs1[2]))->row();
                                            $str = $u->first_name . " " . $u->last_name . "<br> (" . $u->username . ")";
                                            echo anchor(site_url("dashboard/matrix/" . $table . "?parent=" . $u->id), $str);
                                        }
                                        ?>
                                    </td>
                                    <td>
                                        <div class="pk"> <img style="width:50px;margin:auto;" src="<?= site_url('assets/images/') ?>1891016.png" alt="" class="img-fluid m-auto" />
                                        </div>
                                        <?php
                                        if (isset($childs1[3])) {
                                            $u = $this->db->get_where('users', array('id' => $childs1[3]))->row();
                                            $str = $u->first_name . " " . $u->last_name . "<br> (" . $u->username . ")";
                                            echo anchor(site_url("dashboard/matrix/" . $table . "?parent=" . $u->id), $str);
                                        }
                                        ?>
                                    </td>
                                    <td>
                                        <div class="pk"> <img style="width:50px;margin:auto;" src="<?= site_url('assets/images/') ?>1891016.png" alt="" class="img-fluid m-auto" />
                                        </div>
                                        <?php
                                        if (isset($childs1[4])) {
                                            $u = $this->db->get_where('users', array('id' => $childs1[4]))->row();
                                            $str = $u->first_name . " " . $u->last_name . "<br> (" . $u->username . ")";
                                            echo anchor(site_url("dashboard/matrix/" . $table . "?parent=" . $u->id), $str);
                                        }
                                        ?>
                                    </td>
                                <?php
                                } else { ?>

                                    <td>
                                        <div class="pk">
                                            <img style="width:50px;  margin:auto;  display: block;" src="<?= site_url('assets/images/') ?>1891016.png" alt="" class="img-fluid m-auto" />
                                        </div>
                                    </td>
                                    <td>
                                        <div class="pk">
                                            <img style="width:50px; margin:auto;   display: block;" src="<?= site_url('assets/images/') ?>1891016.png" alt="" class="img-fluid m-auto" />
                                        </div>
                                    </td>
                                    <td>
                                        <div class="pk">
                                            <img style="width:50px;  margin:auto;  display: block;" src="<?= site_url('assets/images/') ?>1891016.png" alt="" class="img-fluid m-auto" />
                                        </div>
                                    </td>
                                    <td>
                                        <div class="pk">
                                            <img style="width:50px;  margin:auto;  display: block;" src="<?= site_url('assets/images/') ?>1891016.png" alt="" class="img-fluid m-auto" />
                                        </div>
                                    </td>
                                    <td>
                                        <div class="pk">
                                            <img style="width:50px;  margin:auto;  display: block;" src="<?= site_url('assets/images/') ?>1891016.png" alt="" class="img-fluid m-auto" />
                                        </div>
                                    </td>
                            <?php

                                }
                            }
                            ?>
                            <!-- Third Child -->
                            <?php
                            if ($third) {
                                $childs1 = $this->User_model->get_diamond_childs($third, $table);

                                if (count($childs1) > 0) {

                            ?>
                                    <td>
                                        <div class="pk"> <img style="width:50px;margin:auto;" src="<?= site_url('assets/images/') ?>1891016.png" alt="" class="img-fluid m-auto" />
                                        </div>
                                        <?php
                                        if (isset($childs1[0])) {
                                            $u = $this->db->get_where('users', array('id' => $childs1[0]))->row();
                                            $str = $u->first_name . " " . $u->last_name . "<br> (" . $u->username . ")";
                                            echo anchor(site_url("dashboard/matrix/" . $table . "?parent=" . $u->id), $str);
                                        }
                                        ?>
                                    </td>
                                    <td>
                                        <div class="pk"> <img style="width:50px;margin:auto;" src="<?= site_url('assets/images/') ?>1891016.png" alt="" class="img-fluid m-auto" />
                                        </div>
                                        <?php
                                        if (isset($childs1[1])) {
                                            $u = $this->db->get_where('users', array('id' => $childs1[1]))->row();
                                            $str = $u->first_name . " " . $u->last_name . "<br> (" . $u->username . ")";
                                            echo anchor(site_url("dashboard/matrix/" . $table . "?parent=" . $u->id), $str);
                                        }
                                        ?>
                                    </td>
                                    <td>
                                        <div class="pk"> <img style="width:50px;margin:auto;" src="<?= site_url('assets/images/') ?>1891016.png" alt="" class="img-fluid m-auto" />
                                        </div>
                                        <?php
                                        if (isset($childs1[2])) {
                                            $u = $this->db->get_where('users', array('id' => $childs1[2]))->row();
                                            $str = $u->first_name . " " . $u->last_name . "<br> (" . $u->username . ")";
                                            echo anchor(site_url("dashboard/matrix/" . $table . "?parent=" . $u->id), $str);
                                        }
                                        ?>
                                    </td>
                                    <td>
                                        <div class="pk"> <img style="width:50px;margin:auto;" src="<?= site_url('assets/images/') ?>1891016.png" alt="" class="img-fluid m-auto" />
                                        </div>
                                        <?php
                                        if (isset($childs1[3])) {
                                            $u = $this->db->get_where('users', array('id' => $childs1[3]))->row();
                                            $str = $u->first_name . " " . $u->last_name . "<br> (" . $u->username . ")";
                                            echo anchor(site_url("dashboard/matrix/" . $table . "?parent=" . $u->id), $str);
                                        }
                                        ?>
                                    </td>
                                    <td>
                                        <div class="pk"> <img style="width:50px;margin:auto;" src="<?= site_url('assets/images/') ?>1891016.png" alt="" class="img-fluid m-auto" />
                                        </div>
                                        <?php
                                        if (isset($childs1[4])) {
                                            $u = $this->db->get_where('users', array('id' => $childs1[4]))->row();

                                            $str = $u->first_name . " " . $u->last_name . "<br> (" . $u->username . ")";
                                            echo anchor(site_url("dashboard/matrix/" . $table . "?parent=" . $u->id), $str);
                                        }
                                        ?>
                                    </td>
                                <?php
                                } else { ?>

                                    <td>
                                        <div class="pk">
                                            <img style="width:50px; margin:auto;   display: block;" src="<?= site_url('assets/images/') ?>1891016.png" alt="" class="img-fluid m-auto" />
                                        </div class="pk">
                                    </td>
                                    <td>
                                        <div class="pk">
                                            <img style="width:50px;margin:auto;    display: block;" src="<?= site_url('assets/images/') ?>1891016.png" alt="" class="img-fluid m-auto" />
                                        </div>
                                    </td>
                                    <td>
                                        <div class="pk">
                                            <img style="width:50px;  margin:auto;  display: block;" src="<?= site_url('assets/images/') ?>1891016.png" alt="" class="img-fluid m-auto" />
                                        </div>
                                    </td>
                                    <td>
                                        <div class="pk">
                                            <img style="width:50px;  margin:auto;  display: block;" src="<?= site_url('assets/images/') ?>1891016.png" alt="" class="img-fluid m-auto" />
                                        </div>
                                    </td>
                                    <td>
                                        <div class="pk">
                                            <img style="width:50px;  margin:auto;  display: block;" src="<?= site_url('assets/images/') ?>1891016.png" alt="" class="img-fluid m-auto" />
                                        </div>
                                    </td>
                            <?php

                                }
                            }
                            ?>

                            <!-- Third Child -->
                            <?php
                            if ($fourth) {
                                $childs1 = $this->User_model->get_diamond_childs($fourth, $table);

                                if (count($childs1) > 0) {

                            ?>
                                    <td>
                                        <div class="pk"> <img style="width:50px;margin:auto;" src="<?= site_url('assets/images/') ?>1891016.png" alt="" class="img-fluid m-auto" />
                                        </div>
                                        <?php
                                        if (isset($childs1[0])) {
                                            $u = $this->db->get_where('users', array('id' => $childs1[0]))->row();
                                            $str = $u->first_name . " " . $u->last_name . "<br> (" . $u->username . ")";
                                            echo anchor(site_url("dashboard/matrix/" . $table . "?parent=" . $u->id), $str);
                                        }
                                        ?>
                                    </td>
                                    <td>
                                        <div class="pk"> <img style="width:50px;margin:auto;" src="<?= site_url('assets/images/') ?>1891016.png" alt="" class="img-fluid m-auto" />
                                        </div>
                                        <?php
                                        if (isset($childs1[1])) {
                                            $u = $this->db->get_where('users', array('id' => $childs1[1]))->row();
                                            $str = $u->first_name . " " . $u->last_name . "<br> (" . $u->username . ")";
                                            echo anchor(site_url("dashboard/matrix/" . $table . "?parent=" . $u->id), $str);
                                        }
                                        ?>
                                    </td>
                                    <td>
                                        <div class="pk"> <img style="width:50px;margin:auto;" src="<?= site_url('assets/images/') ?>1891016.png" alt="" class="img-fluid m-auto" />
                                        </div>
                                        <?php
                                        if (isset($childs1[2])) {
                                            $u = $this->db->get_where('users', array('id' => $childs1[2]))->row();
                                            $str = $u->first_name . " " . $u->last_name . "<br> (" . $u->username . ")";
                                            echo anchor(site_url("dashboard/matrix/" . $table . "?parent=" . $u->id), $str);
                                        }
                                        ?>
                                    </td>
                                    <td>
                                        <div class="pk"> <img style="width:50px;margin:auto;" src="<?= site_url('assets/images/') ?>1891016.png" alt="" class="img-fluid m-auto" />
                                        </div>
                                        <?php
                                        if (isset($childs1[3])) {
                                            $u = $this->db->get_where('users', array('id' => $childs1[3]))->row();
                                            $str = $u->first_name . " " . $u->last_name . "<br> (" . $u->username . ")";
                                            echo anchor(site_url("dashboard/matrix/" . $table . "?parent=" . $u->id), $str);
                                        }
                                        ?>
                                    </td>
                                    <td>
                                        <div class="pk"> <img style="width:50px;margin:auto;" src="<?= site_url('assets/images/') ?>1891016.png" alt="" class="img-fluid m-auto" />
                                        </div>
                                        <?php
                                        if (isset($childs1[4])) {
                                            $u = $this->db->get_where('users', array('id' => $childs1[4]))->row();
                                            $str = $u->first_name . " " . $u->last_name . "<br> (" . $u->username . ")";
                                            echo anchor(site_url("dashboard/matrix/" . $table . "?parent=" . $u->id), $str);
                                        }
                                        ?>
                                    </td>
                                <?php
                                } else { ?>

                                    <td>
                                        <div class="pk">
                                            <img style="width:50px; margin:auto;   display: block;" src="<?= site_url('assets/images/') ?>1891016.png" alt="" class="img-fluid m-auto" />
                                        </div>
                                    </td>
                                    <td>
                                        <div class="pk">
                                            <img style="width:50px;margin:auto;    display: block;" src="<?= site_url('assets/images/') ?>1891016.png" alt="" class="img-fluid m-auto" />
                                        </div>
                                    </td>
                                    <td>
                                        <div class="pk">
                                            <img style="width:50px;  margin:auto;  display: block;" src="<?= site_url('assets/images/') ?>1891016.png" alt="" class="img-fluid m-auto" />
                                        </div>
                                    </td>
                                    <td>
                                        <div class="pk">
                                            <img style="width:50px;  margin:auto;  display: block;" src="<?= site_url('assets/images/') ?>1891016.png" alt="" class="img-fluid m-auto" />
                                        </div>
                                    </td>
                                    <td>
                                        <div class="pk">
                                            <img style="width:50px;  margin:auto;  display: block;" src="<?= site_url('assets/images/') ?>1891016.png" alt="" class="img-fluid m-auto" />
                                        </div>
                                    </td>
                            <?php

                                }
                            }
                            ?>

                            <!-- Third Child -->
                            <?php
                            if ($five) {
                                $childs1 = $this->User_model->get_diamond_childs($five, $table);

                                if (count($childs1) > 0) {

                            ?>
                                    <td>
                                        <div class="pk"> <img style="width:50px;margin:auto;" src="<?= site_url('assets/images/') ?>1891016.png" alt="" class="img-fluid m-auto" />
                                        </div>
                                        <?php
                                        if (isset($childs1[0])) {
                                            $u = $this->db->get_where('users', array('id' => $childs1[0]))->row();
                                            $str = $u->first_name . " " . $u->last_name . "<br> (" . $u->username . ")";
                                            echo anchor(site_url("dashboard/matrix/" . $table . "?parent=" . $u->id), $str);
                                        }
                                        ?>
                                    </td>
                                    <td>
                                        <div class="pk"> <img style="width:50px;margin:auto;" src="<?= site_url('assets/images/') ?>1891016.png" alt="" class="img-fluid m-auto" />
                                        </div>
                                        <?php
                                        if (isset($childs1[1])) {
                                            $u = $this->db->get_where('users', array('id' => $childs1[1]))->row();
                                            $str = $u->first_name . " " . $u->last_name . "<br> (" . $u->username . ")";
                                            echo anchor(site_url("dashboard/matrix/" . $table . "?parent=" . $u->id), $str);
                                        }
                                        ?>
                                    </td>
                                    <td>
                                        <div class="pk"> <img style="width:50px;margin:auto;" src="<?= site_url('assets/images/') ?>1891016.png" alt="" class="img-fluid m-auto" />
                                        </div>
                                        <?php
                                        if (isset($childs1[2])) {
                                            $u = $this->db->get_where('users', array('id' => $childs1[2]))->row();
                                            $str = $u->first_name . " " . $u->last_name . "<br> (" . $u->username . ")";
                                            echo anchor(site_url("dashboard/matrix/" . $table . "?parent=" . $u->id), $str);
                                        }
                                        ?>
                                    </td>
                                    <td>
                                        <div class="pk"> <img style="width:50px;margin:auto;" src="<?= site_url('assets/images/') ?>1891016.png" alt="" class="img-fluid m-auto" />
                                        </div>
                                        <?php
                                        if (isset($childs1[3])) {
                                            $u = $this->db->get_where('users', array('id' => $childs1[3]))->row();
                                            $str = $u->first_name . " " . $u->last_name . "<br> (" . $u->username . ")";
                                            echo anchor(site_url("dashboard/matrix/" . $table . "?parent=" . $u->id), $str);
                                        }
                                        ?>
                                    </td>
                                    <td>
                                        <div class="pk"> <img style="width:50px;margin:auto;" src="<?= site_url('assets/images/') ?>1891016.png" alt="" class="img-fluid m-auto" />
                                        </div>
                                        <?php
                                        if (isset($childs1[4])) {
                                            $u = $this->db->get_where('users', array('id' => $childs1[4]))->row();
                                            $str = $u->first_name . " " . $u->last_name . "<br> (" . $u->username . ")";
                                            echo anchor(site_url("dashboard/matrix/" . $table . "?parent=" . $u->id), $str);
                                        }
                                        ?>
                                    </td>
                                <?php
                                } else { ?>

                                    <td>
                                        <div class="pk">
                                            <img style="width:50px; margin:auto;   display: block;" src="<?= site_url('assets/images/') ?>1891016.png" alt="" class="img-fluid m-auto" />
                                        </div>
                                    </td>
                                    <td>
                                        <div class="pk">
                                            <img style="width:50px;margin:auto;    display: block;" src="<?= site_url('assets/images/') ?>1891016.png" alt="" class="img-fluid m-auto" />
                                        </div>
                                    </td>
                                    <td>
                                        <div class="pk">
                                            <img style="width:50px;  margin:auto;  display: block;" src="<?= site_url('assets/images/') ?>1891016.png" alt="" class="img-fluid m-auto" />
                                        </div>
                                    </td>
                                    <td>
                                        <div class="pk">
                                            <img style="width:50px;  margin:auto;  display: block;" src="<?= site_url('assets/images/') ?>1891016.png" alt="" class="img-fluid m-auto" />
                                        </div>
                                    </td>
                                    <td>
                                        <div class="pk">
                                            <img style="width:50px;  margin:auto;  display: block;" src="<?= site_url('assets/images/') ?>1891016.png" alt="" class="img-fluid m-auto" />
                                        </div>
                                    </td>
                            <?php

                                }
                            }
                            ?>
                        </tr>
                    <?php
                    }
                    ?>
                </tbody>
            </table>
        </div>

    </div>
</div>