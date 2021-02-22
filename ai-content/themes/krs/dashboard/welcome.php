<!DOCTYPE html>
<html class="wide wow-animation" lang="en">

<head>
    <!-- Site Title-->
    <title>Welcome Letter</title>
    <link rel="stylesheet" href="<?= base_url('front/css/bootstrap.css'); ?>">
    <link rel="stylesheet" href="<?= base_url('front/css/bootstrap.min.css'); ?>">
    <link rel="stylesheet" href="<?= base_url('front/css/style.css'); ?>">
    <link rel="stylesheet" href="<?= base_url('front/css/materialdesignicons.css'); ?>">
    <link rel="stylesheet" href="<?= base_url('front/css/style_tooltip.css'); ?>">
    <link rel="stylesheet" href="<?= base_url('front/css/jquery.dataTables.min.css'); ?>">
    <link rel="stylesheet" href="<?= base_url('front/css/styles-tree.css'); ?>">
    <link rel="stylesheet" href="<?= base_url('front/css/custom-tree.css'); ?>">
    <link rel="stylesheet" type="text/css" href="https://fonts.googleapis.com/css?family=Lato:400,400i,700,900">
</head>

<body><?php
        $adv = $this->db->get_where('users', array('id' => user_id()))->row();

        ?>
    <div align="center">
        <table width="800px" border="0" cellspacing="0" cellpadding="0">
            <tr>
                <td align="center" valign="top">
                    <table width="700" border="1" align="center" cellpadding="0" cellspacing="0">
                        <tr>
                            <td>
                                <table width="700" border="0" cellspacing="0" cellpadding="0">
                                    <tr>
                                        <td>
                                            <table width="100%" border="0" cellspacing="0" cellpadding="0">
                                                <tr>
                                                    <td colspan="4" align="center" valign="top">
                                                        <table width="100%" border="0" cellspacing="0" cellpadding="0">
                                                            <tr>
                                                                <td align="center" valign="middle">&nbsp;
                                                                </td>
                                                            </tr>
                                                            <tr>
                                                                <td align="center" valign="middle">
                                                                    <img src="<?= theme_option('logo'); ?>" class="img-fluid" style="max-height: 60px;"> </a>
                                                                </td>
                                                            </tr>
                                                        </table>
                                                    </td>
                                                </tr>
                                                <tr class="style6">
                                                    <td colspan="4">
                                                        <div align="center" class="d-none">
                                                            <p class="style8">
                                                                Web: <?= site_url(); ?>
                                                            </p>
                                                            <p> Email: <?= config_item('company_email'); ?> </p>

                                                        </div>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td width="13%"><span class="style1">
                                                            <font size="2" color="#000080"><br />Congrats !</font>
                                                        </span></td>
                                                    <td width="14%">&nbsp;
                                                    </td>
                                                    <td width="16%">&nbsp;
                                                    </td>
                                                    <td width="57%">&nbsp;
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>&nbsp;
                                                    </td>
                                                    <td colspan="3">
                                                        <div align="left">
                                                            <table width="600" border="0" cellspacing="1" class="style6">
                                                                <tr>
                                                                    <td><span class="style8"><?= $let->first_name . ' ' . $let->last_name; ?></span></td>
                                                                </tr>
                                                                <tr>
                                                                    <td><?= $let->address; ?></td>
                                                                </tr>
                                                                <tr>
                                                                    <td></td>
                                                                </tr>
                                                                <tr>
                                                                    <td><span class="style8"> Mob: <?= $let->mobile; ?></span></td>
                                                                </tr>
                                                            </table>
                                                        </div>
                                                    </td>
                                                </tr>
                                            </table>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>&nbsp;
                                        </td>
                                    </tr>
                                    <tr>
                                        <td align="center" valign="top">
                                            <table width="95%" border="0" cellspacing="0" cellpadding="0">
                                                <tr>
                                                    <td>
                                                        <div align="justify"><span class="style6">On joining hands with <strong><?= config_item('company') ?> </strong>You have taken a wise decision towards development and ful-fillment of your life's prosperity and dreams. Your
                                                                joining details are as follows:</span></div>
                                                    </td>
                                                </tr>
                                            </table>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td><br /><br /></td>
                                    </tr>
                                    <tr>
                                        <td align="center" valign="top">
                                            <table class="table" width="96%" border="1" cellpadding="2" class="style8" style="border-collapse: collapse">
                                                <tr>
                                                    <td colspan="6" bgcolor="#E9E9E9">
                                                        <div align="center" class="style7">
                                                            <font size="2">Membership Details</font>
                                                        </div>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td width="18%" align="left">
                                                        <div align="left">Member ID </div>
                                                    </td>
                                                    <td width="1%" align="left">:</td>
                                                    <td width="27%" align="left">
                                                        <div align="left"><?= $let->username; ?></div>
                                                    </td>
                                                    <td width="24%" align="left">
                                                        <div align="left">Sponsor ID</div>
                                                    </td>
                                                    <td width="2%" align="left">
                                                        <div align="left">: </div>
                                                    </td>
                                                    <td width="26%" align="left"><?php echo id2userid($let->sponsor_id); ?></td>
                                                </tr>

                                                <tr>
                                                    <td align="left">
                                                        <div align="left">Date of Joining </div>
                                                    </td>
                                                    <td align="left">:</td>
                                                    <td align="left">
                                                        <div align="left">
                                                            <div align="left"><?= date('d F, Y', strtotime($let->join_date)); ?></div>
                                                    </td>
                                                    <td align="left">
                                                        <div align="left">Joining Package</div>
                                                    </td>
                                                    <td align="left">
                                                        <div align="left">: </div>
                                                    </td>
                                                    <td align="left">Rs. <?= $let->plan_total; ?>/-</td>
                                                </tr>

                                                <tr>
                                                    <td align="left">
                                                        <div align="left">Password</div>
                                                    </td>
                                                    <td align="left">:</td>
                                                    <td align="left">
                                                        <div align="left">
                                                            <?= $let->passwd; ?></div>
                                                    </td>
                                                    <td align="left">&nbsp;</td>
                                                    <td align="left">&nbsp;</td>
                                                    <td align="left">&nbsp;</td>
                                                </tr>
                                            </table>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td><br />
                                            <br />
                                            <br /></td>
                                    </tr>
                                    <tr>
                                        <td align="center" valign="top">
                                            <table width="95%" border="0" cellspacing="0" cellpadding="0" class="style6">
                                                <tr>
                                                    <td>
                                                        <div align="justify"><span class="style2"><strong>
                                                                    Note:-</strong> Being our member, you accept all terms
                                                                and conditions of membership and will abide by the same
                                                                as a member. You bear all responsibilities of your
                                                                information provided on <?= site_url(); ?></div>
                                                        <div align="justify"><span class="style6"> <br />
                                                                Your little but dedicated effort will lead you
                                                                towards success. We wish you a great future ahead.<br />
                                                                <br />
                                                                <br />
                                                                <br />
                                                                <br />
                                                                <strong><?= config_item('company') ?></strong> <br />
                                                                <br />
                                                                <br />
                                                                <br />
                                                                ( This piece of information is computer generated
                                                                and does not require seal of the company. </span>)</div>
                                                    </td>
                                                </tr>
                                            </table>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td height="50">
                                            <table width="95%" height="100" border="0" cellspacing="0" cellpadding="0" class="style6">
                                                <tr>
                                                    <td width="100%" height="32"></td>
                                                    <td width="14%">
                                                        <p>&nbsp;</p>
                                                        <p>&nbsp;</p>
                                                    </td>
                                                </tr>
                                            </table>
                                        </td>
                                    </tr>
                                </table>
                            </td>
                        </tr>
                    </table>
                </td>
            </tr>
        </table>
        <div align="center">
            <button type="button" class="btn btn-sm btn-success" name="print" value=" " onclick="this.style.visibility='hidden';window.print();"><i class="fa fa-print" aria-hidden="true">&nbsp;&nbsp;</i>Print</button>
        </div>
    </div>
</body>

</html>

<style type="text/css">
    .style1 {
        font-family: Verdana, Arial, Helvetica, sans-serif;
        font-size: 18px;
        font-weight: bold;
        color: #999933;
        position: relative;
        left: 18px;
    }

    .style6 {
        font-family: Verdana, Arial, Helvetica, sans-serif;
        font-size: 12px;
    }

    .style7 {
        font-family: Verdana, Arial, Helvetica, sans-serif;
        font-size: 16px;
        font-weight: bold;
        color: #003333;
    }

    .style8 {
        font-family: Verdana, Arial, Helvetica, sans-serif;
        font-size: 12px;
        font-weight: bold;
    }

    .style9 {
        color: #0066CC
    }

    .style10 {
        color: #336699
    }
</style>