<?php
defined('APP_NAME') or die(header('HTTP/1.1 403 Forbidden'));

/*
 * @author MD ARIFUL HAQUE
 * @name: PDF Studio
 * @copyright 2024 PDF Studio
 *
 */
?>
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            <?php echo $pageTitle; ?>
            <small>Control panel</small>
        </h1>
        <ol class="breadcrumb">
            <li><a href="<?php adminLink(); ?>"><i class="<?php getAdminMenuIcon($controller,$menuBarLinks); ?>"></i> Admin</a></li>
            <li class="active"><a href="<?php adminLink($controller); ?>"><?php echo $pageTitle; ?></a> </li>
        </ol>
    </section>

    <!-- Main content -->
    <section class="content">

        <div class="nav-tabs-custom">
            <ul class="nav nav-tabs">
                <li class="<?php echo $page1; ?>"><a href="#adminPages" data-toggle="tab">Overview</a></li>
                <li class="<?php echo $page2; ?>"><a href="#pass-change" data-toggle="tab">Change Username/Password</a></li>
                <li class="<?php echo $page3; ?>"><a href="#avatar" data-toggle="tab">Avatar</a></li>
            </ul>
            <div class="tab-content">

                <div class="tab-pane <?php echo $page1; ?>" id="adminPages" >
                    <br />
                    <?php
                    if(isset($msg)){
                        echo $msg;
                    }?>
                    <div class="row">
                        <div class="col-md-2">
                            <table class="table table-hover table-bordered">
                                <tbody>
                                <tr>
                                    <td><img src="<?php createLink($admin_logo); ?>" alt="Admin Logo" /></td>
                                </tr>
                                </tbody>
                            </table>
                        </div>
                        <div class="col-md-6" style="margin-left: 30px;">
                            <table class="table table-hover table-bordered">
                                <tbody>
                                <tr>
                                    <td style="width: 200px;">Admin Name</td>
                                    <td><span><?php echo $admin_name; ?></span></td>
                                </tr>
                                <tr>
                                    <td style="width: 200px;">Admin ID</td>
                                    <td><span><?php echo $admin_user; ?></span></td>
                                </tr>
                                <tr>
                                    <td style="width: 200px;">Registration Date</td>
                                    <td><span><?php echo $admin_reg_date; ?></span></td>
                                </tr>
                                <tr>
                                    <td style="width: 200px;">Registration IP</td>
                                    <td><span><?php echo $admin_reg_ip; ?></span></td>
                                </tr>
                                <tr>
                                    <td style="width: 200px;">Last Login Date</td>
                                    <td><span><?php echo $admin_last_login_date; ?></span></td>
                                </tr>
                                <tr>
                                    <td style="width: 200px;">Last Active IP</td>
                                    <td><span><?php echo $admin_last_login_ip; ?></span></td>
                                </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>


                    <div class="box-header">
                        <!-- tools box -->

                        <h3 class="box-title">
                            Admin Login History
                        </h3>
                    </div>
                    <br />
                    <div class="box-body">
                        <table class="table table-striped">
                            <tbody>
                            <tr>
                                <th>Last Login Date</th>
                                <th>IP</th>
                                <th>Country</th>
                                <th>Browser</th>
                                <th>OS</th>
                            </tr>

                            <?php
                            $rec_limit = 10;
                            if (isset($_GET['page'])) {
                                $page = $_GET['page'] + 1;
                                $offset = $rec_limit * $page;
                            } else {
                                $page = 0;
                                $offset = 0;
                            }

                            $left_rec = $rec_count - ($page * $rec_limit);
                            $result = mysqli_query($con, "SELECT last_date,ip,browser FROM admin_history ORDER BY `id` DESC LIMIT $offset, $rec_limit");
                            while($row = mysqli_fetch_assoc($result)) {
                                echo '<tr>';
                                echo '<td>' . $row['last_date'] . '</td>';
                                echo '<td>' . $row['ip'] . '</td>';
                                $admin_country = geoip_country_name_by_addr($gi, $row['ip']);
                                $admin_country = (!empty($admin_country)) ? $admin_country : "Unknown";
                                $admin_browser = $row['browser'];
                                $admin_browser = parse_user_agent($admin_browser);
                                extract($admin_browser);
                                $admin_browser = (!empty($browser)) ? $browser : "Unknown";
                                $admin_platform = (!empty($platform)) ? $platform : "Unknown";
                                echo '<td>' . $admin_country . '</td>';
                                echo '<td>' . $admin_browser . '</td>';
                                echo '<td>' . $admin_platform . '</td>';
                            }
                            echo '</tr>';
                            echo '</tbody>';
                            echo '</table>';
                            echo '<ul class="pager">';
                            if ($left_rec < $rec_limit) {
                                $last = $page - 2;
                                echo '<li><a href="'.createLink($controller.'/&page='.$last, true).'">Previous</a></li>';
                            } else if ($page == 0) {
                                echo '<li><a href="'.createLink($controller.'/&page='.$page, true).'">Next</a></li>';
                            } else if ($page > 0) {
                                $last = $page - 2;
                                echo '<li><a href="'.createLink($controller.'/&page='.$last, true).'">Previous</a></li>';
                                echo '<li><a href="'.createLink($controller.'/&page='.$page, true).'">Next</a></li>';
                            }
                            echo '</ul>';
                            ?>

                    </div><!-- /.box-body -->


                </div>

                <div class="tab-pane <?php echo $page2; ?>" id="pass-change" >

                    <form action="#" method="POST">
                        <div class="box-body">
                            <?php
                            if(isset($msg)){
                                echo $msg;
                            }?>

                            <div class="form-group">
                                <label for="admin_user">Admin ID</label>
                                <input type="email" placeholder="Enter your email id" value="<?php echo $admin_user; ?>" name="admin_user" class="form-control" />
                            </div>

                            <div class="form-group">
                                <label for="admin_name">Admin Name</label>
                                <input type="text" placeholder="Enter your page url" value="<?php echo $admin_name; ?>" name="admin_name" class="form-control" />
                            </div>

                            <div class="form-group">
                                <label for="new_pass">New Password</label>
                                <input type="password" placeholder="Enter your new password" name="new_pass" class="form-control" />
                            </div>

                            <div class="form-group">
                                <label for="retype_pass">Retype Password</label>
                                <input type="password" placeholder="Retype the new password" name="retype_pass" class="form-control" />
                            </div>

                            <hr />

                            <div class="form-group">
                                <label for="old_pass">Old Password</label>
                                <input type="password" placeholder="Enter your old admin panel password" name="old_pass" class="form-control" />
                            </div>
                            <input type="hidden" name="passChange" value="1" />
                            <input type="submit" name="save" value="Save" class="btn btn-primary"/>
                            <br />

                        </div><!-- /.box-body -->
                    </form>
                </div>

                <div class="tab-pane <?php echo $page3; ?>" id="avatar" >
                    <br />
                    <div class="box-body">
                        <?php
                        if(isset($msg))
                            echo $msg;
                        ?>
                        <form id="theme_id" method="POST" action="<?php adminLink($controller); ?>" enctype="multipart/form-data">
                            <div class="form-group">
                                <label for="logoID">Select image to upload:</label>
                                <div class="controls">
                                    <img src="<?php createLink($admin_logo); ?>" style="text-align:center;"/> <br /><br />
                                    <input type="file" name="logoUpload" id="logoUpload" class="btn btn-default" />
                                    <input type="hidden" name="logoID" id="logoID" value="1" /> <br />
                                    <input type="submit" value="Upload Image" name="submit" class="btn btn-primary" />
                                </div> <!-- /controls -->

                            </div> <!-- /control-group -->
                        </form>

                    </div>

                </div>

            </div>
        </div>

    </section><!-- /.content -->
</div><!-- /.content-wrapper -->
<?php
geoip_close($gi);
geoip_close($giv6);
?>
