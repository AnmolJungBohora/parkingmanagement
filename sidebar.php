<?php
session_start();
error_reporting(0);
include('base/databaseconnection.php');

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width,initial-scale=1,maximum-scale=1">
    <title>PMS</title>
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="https://maxst.icons8.com/vue-static/landings/line-awesome/line-awesome/1.3.0/css/line-awesome.min.css">
    <script type="module" src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.esm.js"></script>
    <script nomodule src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.js"></script>

    <script src="//cdn.jsdelivr.net/npm/alertifyjs@1.13.1/build/alertify.min.js"></script>

    <!-- CSS -->
    <link rel="stylesheet" href="//cdn.jsdelivr.net/npm/alertifyjs@1.13.1/build/css/alertify.min.css"/>
    <!-- Default theme -->
    <link rel="stylesheet" href="//cdn.jsdelivr.net/npm/alertifyjs@1.13.1/build/css/themes/default.min.css"/>
    <!-- Semantic UI theme -->
    <link rel="stylesheet" href="//cdn.jsdelivr.net/npm/alertifyjs@1.13.1/build/css/themes/semantic.min.css"/>
    <!-- Bootstrap theme -->
    <link rel="stylesheet" href="//cdn.jsdelivr.net/npm/alertifyjs@1.13.1/build/css/themes/bootstrap.min.css"/>

    <link rel="stylesheet" href="//cdn.jsdelivr.net/npm/alertifyjs@1.13.1/build/css/alertify.rtl.min.css"/>
    <!-- Default theme -->
    <link rel="stylesheet" href="//cdn.jsdelivr.net/npm/alertifyjs@1.13.1/build/css/themes/default.rtl.min.css"/>
    <!-- Semantic UI theme -->
    <link rel="stylesheet" href="//cdn.jsdelivr.net/npm/alertifyjs@1.13.1/build/css/themes/semantic.rtl.min.css"/>
    <!-- Bootstrap theme -->
    <link rel="stylesheet" href="//cdn.jsdelivr.net/npm/alertifyjs@1.13.1/build/css/themes/bootstrap.rtl.min.css"/>

    <style>
        .dropdown {
            position: relative;
            display: inline-block;
            top: 0;
            left: 0;
        }

        .dropdown-content {
            display: none;
            position: absolute;
            min-width: 190px;
            box-shadow: 0 8px 16px 0 rgba(0,0,0,0.2);
            z-index: 1;
            left: -100px;
        }

        .dropdown:hover .dropdown-content {
            display: block;
        }

        .dropdown-content a {
            color: black;
            padding: 12px 16px;
            text-decoration: none;
            display: block;
            background:#ADD1E5;
        }

        .dropdown-content a:hover {
            background-color: #f1f1f1;
        }

        .dropdown-content a i {
            font-size: 18px;
            vertical-align: middle;
        }

        .bg-img {
            cursor: pointer;
        } 
        </style>

    </head>
<body>
   <input type="checkbox" id="menu-toggle">
    <div class="sidebar">
        <div class="side-content">
            <div class="profile">
                <div class="profile-img bg-img" style="background-image: url(img/person.png)"></div>
                <?php
                    $adminid=$_SESSION['vpmsaid'];
                    $ret=mysqli_query($con,"SELECT * from admin where ID='$adminid'");
                    $cnt=1;
                    while ($row=mysqli_fetch_array($ret)) {
                        $admintype = $row['admintype'];
                ?>
                <h4><?php  echo $row['firstname'];?> <?php  echo $row['lastname'];?></h4>
                <?php } ?>
                <small>Admin</small>
            </div>

            <div class="side-menu">
                <ul>
                    <li class="<?php if($page=="dashboard") {echo "active";}?>">
                       <a href="dashboard.php">
                            <span class="las la-home"></span>
                            <small>Dashboard</small>
                        </a>
                    </li>
                    <li class="<?php if($page=="vehiclecategory") {echo "active";}?>">
                       <a href="vehiclecategory.php">
                            <span class="las la-list"></span>
                            <small>Vehicle Category</small>
                        </a>
                    </li>
                    <li class="<?php if($page=="vehicleentry") {echo "active";}?>">
                       <a href="vehicleentry.php">
                            <span class="las la-car"></span>
                            <small>Vehicle Entry</small>
                        </a>
                    </li>
                    <li class="<?php if($page=="vehiclein") {echo "active";}?>">
                       <a href="vehiclein.php">
                            <span class="las la-download"></span>
                            <small>Vehicle In</small>
                        </a>
                    </li>
                    <li class="<?php if($page=="vehicleout") {echo "active";}?>">
                       <a href="vehicleout.php">
                            <span class="las la-sign-out-alt"></span>
                            <small>Vehicle Out</small>
                        </a>
                    </li>
                    <li class="<?php if($page=="reports") {echo "active";}?>">
                       <a href="reports.php">
                            <span class="las la-file"></span>
                            <small>View Reports</small>
                        </a>
                    </li>
                    <?php if($admintype == true): ?>
                        <li class="<?php if($page=="manageadmin") {echo "active";}?>">
                        <a href="manageadmin.php">
                                <span class="las la-user-alt"></span>
                                <small>Manage Admins</small>
                            </a>
                        </li>
                    <?php endif; ?>

                </ul>
            </div>
        </div>
    </div>
    
    <div class="main-content">
        
        <header>
            <div class="header-content">
                <label for="menu-toggle">
                    <span class="las la-bars"></span>
                </label>
                
                <div class="header-menu">
                    <div class="user">
                    <div class="dropdown">
                        <div class="bg-img" style="background-image: url(img/person.png)"></div>
                        <div class="dropdown-content">
                            <a href="profile.php"><i class="las la-user"></i> Profile</a>
                            <a href="changepassword.php"><i class="las la-key"></i> Change Password</a>
                            <a href="logout.php"><i class="las la-power-off"></i> Log out</a>
                        </div>
                        </div>
                        <li>
                            <a href="logout.php" style="color:grey;">
                        <span class="las la-power-off"></span>
                        <span>Logout</span>
                        </a>
                        <li>
                    </div>
                </div>
            </div>
        </header>
        
        
        
        
    </div>
</body>
</html>