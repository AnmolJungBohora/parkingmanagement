
<?php
session_start();
$msg="";
include('base/databaseconnection.php');
if(isset($_REQUEST['resetpwd']))
{
  $email = $_REQUEST['email'];
  $pwd = md5($_REQUEST['password']);
  $cpwd = md5($_REQUEST['confirmpassword']);
  if($pwd == $cpwd)
  {
    $reset_pwd = mysqli_query($con,"update admin set password='$pwd' where email='$email'");
    if($reset_pwd>0)
    {
        $_SESSION['success_msg'] = "Password successfully updated."; 
        header('location:index.php'); 
        exit();
    }
    else
    {
        $_SESSION['error_msg'] = "Error while uploading password."; 
        header('location:index.php'); 
        exit(); 
    }
  }
  else
  {
    $msg = "Password and Confirm Password do not match !!";
    $class = "error";
  }
}

if($_GET['secret'])
{
  $email = base64_decode($_GET['secret']);
  $check_details = mysqli_query($con,"select email from admin where email='$email'");
  $res = mysqli_num_rows($check_details);
  if($res>0)
    { ?>
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
                .error {
                    background-color: red;
                    color: white;
                    font-size:21px;
                    text-align:center;
                }
                .error-message {
                color: red;
                font-size: 1em;
                margin-bottom: 15px;
            }
            </style>
        </head>
        <body>
            <div class="center">
                <h1>Reset Password</h1>
                <form id="validate_form" method="POST" onsubmit="return validateForm()" >

                <p class="<?php echo $class; ?>">
                    <?php echo $msg; ?>
                </p>

                <input type="hidden" name="email" value="<?php echo $email; ?>"/>
                    <div class="txt_field">
                        <input type="password" id= 'password' name='password' data-parsley-type="password" data-parsley-trigger="keyup">
                        <span></span>
                        <label>New Password</label>
                    </div>
                    <div class="error-message" id="password-error"></div>
                    <div class="txt_field">
                        <input type="password" id= 'confirmpassword' name='confirmpassword' data-parsley-type="confirmpassword" data-parsley-trigger="keyup">
                        <span></span>
                        <label>Confirm Password</label>
                    </div>                    
                    <div class="error-message" id="confirmpassword-error"></div>   
                    <input type="submit" value="Reset Password" name="resetpwd">
                </form>
            </div>
            <script>
            function validateForm() {
            var fields = ['password','confirmpassword'];
            var labels = ['Password','Confirm Password'];
            var isValid = true;
            var passwordPattern = /^(?=.[a-z])(?=.[A-Z])(?=.*\d).{8,}$/;

            fields.forEach(function(field,index) {
                var value = document.getElementById(field).value.trim();
                if (value === '') {
                    isValid = false;
                    var errorElement = document.getElementById(field + '-error');
                    errorElement.innerText = labels[index] + ' cannot be empty.';
                } else if (field === 'password' && !passwordPattern.test(value)) {
                    isValid = false;
                    var errorElement = document.getElementById('password-error');
                    errorElement.innerText = 'Password must contain at least one lowercase letter, one uppercase letter, one number, and be at least 8 characters long.';
                }else {
                    var errorElement = document.getElementById(field + '-error');
                    errorElement.innerText = '';
                }
            });
            return isValid;
         }
            </script>
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

            <?php } }?>
            
        </body>
    </html>
    