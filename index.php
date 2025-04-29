<?php
session_start();
error_reporting(0);
include('base/databaseconnection.php');

if(isset($_POST['login']))
  {
    $adminuser=$_POST['username'];
    $password=md5($_POST['password']);
    $query=mysqli_query($con,"SELECT ID from admin where  (username='$adminuser' OR email='$adminuser') && password='$password' ");
    $ret=mysqli_fetch_array($query);
    if($ret>0){
      $_SESSION['vpmsaid']=$ret['ID'];
     header('location:dashboard.php');
    }
    else{
    $msg="Invalid Username and Password !!";
    }
  }
?>

<DOCTYPE html>
    <html lang="en">
        <head>
            <meta charset="utf-8">
            <meta http-equiv="X-UA-Compatible" content="IE=edge">
            <meta name="viewport" content="width=device-width, initial-scale=1">
            <title>Login</title>
            <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css" integrity="sha384-xOolHFLEh07PJGoPkLv1IbcEPTNtaed2xpHsD9ESMhqIYd0nLMwNLD69Npy4HI+N" crossorigin="anonymous">
            
            <link rel="stylesheet" href="login.css" type="text/css" />
            <style>
                .error-message {
                color: red;
                font-size: 1em;
            }
             </style>   
        </head>
        <body>
            <div class="center">
                <h1>Parking Management System</h1>
                <form method="POST" onsubmit="return validateForm()">

                    <div class="txt_field">
                        <input type="text" id = 'username' name='username' >
                        <span></span>
                        <label>Username / Email</label>
                    </div>
                    <div class="error-message" id="username-error"></div>
                    <div class="txt_field">
                        <input type="password" id = 'password' name='password'>
                        <span></span>
                        <label>Password</label>
                    </div>
                    <div class="error-message" id="password-error"></div>
                
                    <div class="icheck">
                        <input type="checkbox" id="remember">
                        <label>Remember Me</label>
                    </div>
                            
                    <input type="submit" value="Login" name="login">
                   
                </form>
                <div class="pass" style='text-align:center;'>
                    <a href="forgotpassword.php">Forgot Password?</a>
                </div>
            </div>
    <script src="js/jquery-1.11.1.min.js"></script>
	<script src="js/bootstrap.min.js"></script>
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

    <?php if ($msg): ?>
        <script>
            alertify.set('notifier','position', 'top-right');
            var messageText = '<span style="font-size: 24px;"><?php echo htmlentities($msg); ?></span>';
            alertify.error(messageText);
        </script>
    <?php endif; ?>

        
    <?php if(isset($_SESSION['success_msg']) || isset($_SESSION['error_msg'])): ?>
        <script>
            alertify.set('notifier','position', 'top-right');
            <?php if(isset($_SESSION['success_msg'])): ?>
                var successMsg = '<?php echo addslashes($_SESSION['success_msg']); ?>';
                alertify.success('<span style="font-size: 24px; display: inline-block; margin-left: 25px;">' + successMsg + '</span>');
                <?php unset($_SESSION['success_msg']); ?>
            <?php endif; ?>
            <?php if(isset($_SESSION['error_msg'])): ?>
                var errorMsg = '<?php echo addslashes($_SESSION['error_msg']); ?>';
                alertify.error('<span style="font-size: 24px; display: inline-block; margin-left: 25px;">' + errorMsg + '</span>');
                <?php unset($_SESSION['error_msg']); ?>
            <?php endif; ?>
        </script>
    <?php endif; ?>
    <script>
        function validateForm() {
            var fields = ['username', 'password'];
            var labels = ['Username / Email', 'Password'];
            var isValid = true;
            fields.forEach(function(field,index) {
                var value = document.getElementById(field).value.trim();
                if (value === '') {
                    isValid = false;
                    var errorElement = document.getElementById(field + '-error');
                    errorElement.innerText = labels[index] + ' cannot be empty.';
                } else {
                    var errorElement = document.getElementById(field + '-error');
                    errorElement.innerText = '';
                }
            });
            return isValid;
        }
    </script>
        </body>
    </html>
    