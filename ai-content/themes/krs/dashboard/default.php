<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <!-- <meta http-equiv="X-UA-Compatible" content="IE=edge"> -->
    <title>Dashboard</title>
    <!-- <meta content="width=device-width, initial-scale=1.0" name="viewport"> -->
    <!-- Custom fonts for this template-->
    <link href="<?= theme_url('dashboard/fa/css/font-awesome.css'); ?>" rel="stylesheet" type="text/css">
    <link href="<?= base_url('assets/css/bootstrap.min.css'); ?>" rel="stylesheet">
    <link href="<?= base_url('assets/js/datatables/datatables.css'); ?>" rel="stylesheet" />
    <link href="<?= theme_url(); ?>dashboard/css/style.css" rel="stylesheet">
    <link href="<?= theme_url(); ?>dashboard/css/responsive.css" rel="stylesheet">
    <link href="<?= base_url('assets/css/origin.css'); ?>" rel="stylesheet">

    <script src="<?= theme_url('dashboard/js/jquery-3.5.1.min.js'); ?>"></script>
    <script src="<?= base_url('assets/js/datatables/datatables.min.js'); ?>"></script>
    <script src="https://cdn.jsdelivr.net/npm/vue@2.6.12"></script>
    <script>
        var AppUrl = '<?= site_url('home/call/') ?>';
    </script>
    <script type="text/javascript">
        $(document).ready(function() {
            $('.data-table').DataTable({
                order: [],
                pageLength: 50
            });
        });
    </script>

</head>

<body id="page-top">
    <!-- Page Wrapper -->
    <div id="wrapper">
        <!-- Sidebar -->


        <div class='animated bounceInDown navbar-nav bg-dark sidebar sidebar-dark accordion side' style="background-image: url(<?= theme_url() ?>/dashboard/img/oo.png);">
            <a class="bg-white text-dark d-flex align-items-center justify-content-center p-1" href="<?= site_url('dashboard'); ?>">
                <?php
                $src = theme_option('logo');
                if ($src != '') {
                ?>
                    <img src="<?= theme_option('logo'); ?>" alt="" class="img-fluid img-responsive">
                <?php
                } else {
                    echo config_item('company');
                }
                ?>

            </a>
            <ul class="sidebar-menu">
                <li>
                    <a href="<?= site_url('dashboard'); ?>">
                        <i class="fa fa-dashboard"></i>
                        <span> Dashboard </span>
                    </a>
                </li>


                <!-- <li><a href='#profile'>Profile</a></li>

                <li><a href='#message'>Messages</a></li> -->
                <li class='sub-menu'><a href='#settings'>
                        <i class="fa fa-user"></i>
                        Profile<div class='fa fa-caret-down float-right'></div></a>
                    <ul>
                        <li><a href='<?= site_url('dashboard/edit_profile'); ?>'>Edit Profile</a></li>
                        <li><a href='<?= site_url('dashboard/change-password'); ?>'>Change Password</a></li>
                        <li><a target="_blank" href='<?= site_url('dashboard/welcome'); ?>'>Welcome Letter</a></li>
                        <li><a href='<?= site_url('dashboard/kyc'); ?>'>KYC Edit</a></li>
                    </ul>
                </li>
                <li>
                    <a href="<?= site_url('dashboard/pin-list'); ?>" class="bg-success"> <i class="fa fa-plus-circle"></i> ADD NEW JOINING</a>
                </li>
                <li class='sub-menu'><a href='#settings'>
                        <i class="fa fa-code"></i>
                        PIN Management<div class='fa fa-caret-down float-right'></div></a>
                    <ul>
                        <li><a href='<?= site_url('dashboard/pin-request-bank'); ?>'>Request Pin</a></li>
                        <li><a href='<?= site_url('dashboard/pin-list/?status=0'); ?>'>Used Pin</a></li>
                        <li><a href='<?= site_url('dashboard/pin-list/?status=1'); ?>'>Active Pin</a></li>
                        <li><a href='<?= site_url('dashboard/pin-transfer'); ?>'>Transfer Pin</a></li>
                        <li><a href='<?= site_url('dashboard/pin-list'); ?>'>Pin History</a></li>

                    </ul>
                </li>

                <li class='sub-menu'><a href='#message'>
                        <i class="fa fa-sitemap"></i>
                        Team<div class='fa fa-caret-down float-right'></div></a>
                    <ul>
                        <li><a href='<?= site_url('dashboard/members'); ?>'>My Team</a></li>
                        <li><a href='<?= site_url('dashboard/member_level'); ?>'>Team by Level </a></li>

                        <!-- <li><a href='#settings'>Network Status</a></li> -->
                    </ul>
                </li>
                <li class='sub-menu'><a href='#message'>
                        <i class="fa fa-inr"></i>
                        Income<div class='fa fa-caret-down float-right'></div></a>
                    <ul>
                        <li><a href="<?= site_url('dashboard/income/level') ?>">Level Income</a></li>
                        <li><a href="<?= site_url('dashboard/payment_history') ?>">Transaction History</a></li>
                    </ul>
                </li>
                <li class='sub-menu'><a href='#settings'>
                        <i class="fa fa-bank"></i>
                        Money Withdrawal<div class='fa fa-caret-down float-right'></div></a>
                    <ul>
                        <?php
                        if (config_item('bank_transfer')) {
                        ?>
                            <li>
                                <a href="<?= site_url('dashboard/recharge'); ?>">
                                    <span>Money Transfer</span>
                                </a>
                            </li>
                        <?php
                        }
                        if (config_item('manual_withdraw')) {
                        ?>
                            <li><a href='<?= site_url('dashboard/withdraw'); ?>'>Withdraw Request</a></li>
                        <?php
                        }
                        ?>
                        <li><a href='<?= site_url('dashboard/withdraw-history'); ?>'>Withdraw History</a></li>

                    </ul>
                </li>
                <li> <a href="<?= site_url('logout') ?>"> <i class="fa fa-power-off"></i> Logout </a>
                    <!-- <li><a href='#message'>Logout</a></li> -->
            </ul>
        </div>

        <!-- End of Sidebar -->
        <!-- Content Wrapper -->
        <div id="content-wrapper" class="d-flex flex-column">
            <!-- Main Content -->
            <div id="content" style="min-width: 760px; background-image: url(<?= theme_url() ?>/dashboard/img/webb.png);">
                <?php
                $arn = array();
                ?>
                <!-- Topbar -->
                <nav class="navbar navbar-expand navbar-light bg-white topbar mb-4 static-top shadow" style="min-width: 760px; background-image: url(<?= theme_url() ?>/dashboard/img/oo.png);">
                    <div class="d-flex justify-content-between align-items-center" style="flex: 1;">
                        <div>
                            <h6 class="text-white m-0"><?= $me->first_name . ' ' . $me->last_name; ?> </h6>
                        </div>
                        <div>
                            <?php if ($me->image != '') { ?>
                                <img class="img-profile rounded-circle" src="<?= site_url(upload_dir($me->image)); ?>" title="<?= $me->first_name . ' ' . $me->last_name ?>">
                            <?php } else { ?>
                                <img class="img-profile rounded-circle" src="<?= site_url('assets/img/avg.png'); ?>" title="<?= $me->first_name . ' ' . $me->last_name ?>">
                            <?php } ?>
                        </div>
                    </div>
                </nav>
                <div class="container-fluid">
                    <?php
                    $this->load->view("alert");
                    $this->load->front_view($main);
                    ?>
                </div>
            </div>
            <!-- End of Main Content -->
        </div>

        <!-- End of Content Wrapper -->
    </div>

    <!-- End of Page Wrapper -->
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
    <script>
        $(".mov-menu").click(function() {
            $(".side").slideToggle();
        });
        $(document).ready(function() {
            $(".btn-copy").click(function() {
                var metxt = $(this).data('copy');
                var $temp = $("<input>");
                $("body").append($temp);
                $temp.val(metxt).select();
                document.execCommand("copy");
                $temp.remove();
                alert('Text copied');
            });

            $('.sub-menu ul').hide();
            $(".sub-menu a").click(function() {
                $(this).parent(".sub-menu").children("ul").slideToggle("100");
                $(this).find(".right").toggleClass("fa-caret-up fa-caret-down");
            });

        });
    </script>

</body>

</html>