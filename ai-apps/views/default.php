<!DOCTYPE html>

<head>

    <title><?= config_item('company'); ?> - Secure Admin</title>
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="stylesheet" type="text/css" href="<?= base_url("assets/css/bootstrap.min.css"); ?>" />
    <link rel="stylesheet" type="text/css" href="<?= base_url("assets/fa/css/font-awesome.min.css"); ?>" />
    <link rel="stylesheet" type="text/css" href="<?= base_url("assets/css/datepicker.css"); ?>" />
    <link rel="stylesheet" type="text/css" href="<?= base_url("assets/css/style.css"); ?>" />
    <link rel="stylesheet" type="text/css" href="<?= base_url("assets/plugins/data-table/datatables.min.css"); ?>" />
    <link rel="stylesheet" type="text/css" href="<?= base_url("assets/plugins/select2/css/select2.min.css"); ?>" />
    <link rel="stylesheet" type="text/css" href="<?= base_url("assets/plugins/select2/css/select2-bootstrap4.css"); ?>" />
    <script type="text/javascript" src="<?= base_url("assets/js/jquery-3.2.1.min.js"); ?>"></script>
    <style>
        .menu li .fa {
            width: 20px;
        }
    </style>
</head>

<body>
    <div class="topbar">
        <div class="container-fluid">
            <div class="row">
                <div class="col-sm-4">
                    <b>Dashboard</b>
                </div>

                <div class="col-sm-8">
                    <ul class="qmenu">
                        <li><a href="<?= admin_url("settings"); ?>"><i class="fa fa-wrench"></i> Settings</a></li>
                        <li><a href="<?= admin_url("users/logout"); ?>"><i class="fa fa-sign-out"></i> Logout</a></li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
    <?php
    $u = $this->Admin_model->getRow($_SESSION['userid'], 'admin');
    ?>
    <div class="main-outer">
        <div class="sidebar">
            <div class="userinfo">
                <img src="<?= base_url('assets/img/avg.png') ?>" class="img-fluid circle" />
                <div class="user-details">
                    Welcome <b><?= $u->first_name; ?></b> <br />
                    <small><?php echo date("jS M, h:i A"); ?></small><br />
                    <a href="<?= admin_url("users/logout"); ?>" class="btn btn-light btn-logout">Logout <span class="fa fa-sign-out"></span></a>
                </div>
            </div>
            <ul class="menu">
                <li><a href="<?= admin_url(); ?>"><i class="fa fa-home"></i> Dashboard </a></li>
                <li class="has-submenu"><a href="#"><i class="fa fa-list"></i> Catalog<span class="fa fa-angle-right"></span></a></a>
                    <ul>
                        <li><a href="<?= admin_url('categories'); ?>"><span class="fa fa-angle-right"></span>Categories</a></li>
                        <li><a href="<?= admin_url('products'); ?>"><span class="fa fa-angle-right"></span>Products</a></li>
                    </ul>
                </li>
                <li class="has-submenu "><a href="#"><i class="fa fa-youtube"></i> Member Reports<span class="fa fa-angle-right"></span></a></a>
                    <ul>
                        <li><a href="<?= admin_url('members'); ?>"><span class="fa fa-angle-right"></span>All Members</a></li>
                        <li><a href="<?= admin_url('members/?filter=today'); ?>"><span class="fa fa-angle-right"></span>Today's Registered User</a></li>
                        <li><a href="<?= admin_url('members/kyc'); ?>"><span class="fa fa-angle-right"></span>KYC List</a></li>
                    </ul>
                </li>
                <!--   <li class="has-submenu "><a href="#"><i class="fa fa-youtube"></i> Fund Management <span class="fa fa-angle-right"></span></a></a>
                    <ul>
                        <li><a href="<?= admin_url('payments/fund-transfer'); ?>"><span class="fa fa-angle-right"></span>Fund Transfer</a></li>
                        <li><a href="<?= admin_url('payments/?type=today'); ?>"><span class="fa fa-angle-right"></span>New Fund Request</a></li>
                        <li><a href="<?= admin_url('payments'); ?>"><span class="fa fa-angle-right"></span>All Fund Request</a></li>
                        <li><a href="<?= admin_url('payments/debit-credit'); ?>"><span class="fa fa-angle-right"></span>Current Income DR/CR </a></li>
                    </ul>
                </li> -->

                <li class="has-submenu "><a href="#"><i class="fa fa-youtube"></i> Payout Report <span class="fa fa-angle-right"></span></a></a>
                    <ul>
                        <li><a href="<?= admin_url('payout/withdrawal/?new=yes'); ?>"><span class="fa fa-angle-right"></span>New Request</a></li>
                        <li><a href="<?= admin_url('payout/withdrawal'); ?>"><span class="fa fa-angle-right"></span>Withdrawal History</a></li>
                    </ul>
                </li>

                <li class="has-submenu"><a href="#"><i class="fa fa-dashboard"></i>PIN Management<span class="fa fa-angle-right"></span></a>
                    <ul>
                        <li><a href="<?= admin_url("epin"); ?>"><span class="fa fa-angle-right"></span>PIN Allocation</a></li>
                        <li><a href="<?= admin_url("epin/request-pin"); ?>"><span class="fa fa-angle-right"></span>PIN Request</a></li>
                    </ul>
                </li>

                <li class="has-submenu"><a href="#"><i class="fa fa-dashboard"></i>Media and Setting<span class="fa fa-angle-right"></span></a>
                    <ul>
                        <li><a href="<?= admin_url("dashboard/announce"); ?>"><span class="fa fa-angle-right"></span>Announcement </a></li>
                        <li><a href="<?= admin_url("settings"); ?>"><span class="fa fa-angle-right"></span>General Settings</a></li>
                        <li><a href="<?= admin_url("dashboard/changepass"); ?>"><span class="fa fa-angle-right"></span>Change Password </a></li>
                    </ul>
                </li>
            </ul>
        </div>
        <div class="main" style="min-width: 1100px;">
            <div class="matter">
                <div class="container">
                    <?php $this->load->view("alert"); ?>
                </div>
                <div class="container">
                    <?php $this->load->view($main); ?>
                </div>
            </div>
        </div>
    </div>
    <script type="text/javascript" src="<?= base_url("assets/js/bootstrap.min.js"); ?>"></script>
    <script type="text/javascript" src="<?= base_url("assets/js/datepicker.js"); ?>"></script>
    <script type="text/javascript" src="<?= base_url("assets/js/editors/standard/ckeditor.js"); ?>"></script>
    <script type="text/javascript" src="<?= base_url("assets/plugins/data-table/datatables.min.js"); ?>"></script>
    <script type="text/javascript" src="<?= base_url("assets/plugins/select2/js/select2.min.js"); ?>"></script>
    <script type="text/javascript" src="<?= base_url("assets/js/custom.js"); ?>"></script>
    <script>
        CKEDITOR.replace('.ckeditor');
    </script>
    <script type="text/javascript">
        $(document).ready(function() {
            $(".has-submenu").click(function(e) {
                $(this).children("ul").slideToggle("slow");
            });
            $('.data-table').DataTable({
                "order": [],
                "pageLength": 50
            });

            $('.datepicker').datepicker({
                format: 'yyyy-mm-dd'
            });
            $('a.delete').click(function() {
                if (!confirm('Are you sure to delete?'))
                    return false;
            });

            $('.btn-confirm').click(function() {
                var msg = $(this).data('msg');
                if (!confirm(msg))
                    return false;
            });
            $('.form-select').select2();
        });
    </script>
</body>

</html>