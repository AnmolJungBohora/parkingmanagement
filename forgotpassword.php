
<?php
    $msg = "";
    include('base/databaseconnection.php');
    if(isset($_REQUEST['resetpassword']))
    {
    $email = $_REQUEST['email'];
    $check_email = mysqli_query($con,"select email from admin where email='$email'");
    $res = mysqli_num_rows($check_email);
    if($res>0)
    {
        $message = '<div>
        <p><b>Hello!</b></p>
        <p>You are recieving this email because we recieved a password reset request for your account.</p>
        <br>
        <p><button class="btn btn-primary"><a href="http://localhost/pms/resetpassword.php?secret='.base64_encode($email).'">Reset Password</a></button></p>
        <br>
        <p>If you did not request a password reset, no further action is required.</p>
        </div>';

        include("smtp/class.phpmailer.php");
        include("smtp/class.smtp.php");
        $email = $email; 
        $mail = new PHPMailer;
        $mail->IsSMTP();
        $mail->SMTPAuth = true;                 
        $mail->SMTPSecure = "tls";      
        $mail->Host = 'smtp.gmail.com';
        $mail->Port = 587; 
        $mail->Username = "noreplypms2@gmail.com";   
        $mail->Password = "qdhysdunwlxnzlbn";   
        $mail->FromName = "PMS";
        $mail->AddAddress($email);
        $mail->Subject = "Reset Password";
        $mail->isHTML( TRUE );
        $mail->Body =$message;
        if($mail->send())
        {
        $msg = "Password reset link has been sent to your email address !!";
        $class = "success";
        }
        }
        else
        {
        $msg = "User not found with that email address";
        $class = "error"; 
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
                .success {
                    background-color: green;
                    color: white;
                    font-size:21px;
                    text-align:center;
                }
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
                <h1>PMS</h1>
                <form method="POST" onsubmit="return validateForm()">
                <p class="<?php echo $class; ?>">
                    <?php echo $msg; ?>
                </p>
                    <div class="txt_field">
                        <input type="text" id= 'email' name='email' data-parsley-type="email" data-parsley-trigger="keyup">
                        <span></span>
                        <label>Email</label>
                    </div>
                    <div class="error-message" id="email-error"></div>
                    <div style="display: flex;">
                        <input style="background:green;margin-right:20px;"type="submit" value="Submit" name="resetpassword">
                        <input type="submit" value="Back" onclick="window.location.href='index.php';">
                    </div>
                </form>
                
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

    <script>
            function validateForm() {
            var fields = ['email'];
            var labels = ['Email'];
            var isValid = true;
            var emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;

            fields.forEach(function(field,index) {
                var value = document.getElementById(field).value.trim();
                if (value === '') {
                    isValid = false;
                    var errorElement = document.getElementById(field + '-error');
                    errorElement.innerText = labels[index] + ' cannot be empty.';
                }else if (field === 'email' && !emailRegex.test(value)) {
                    isValid = false;
                    var errorElement = document.getElementById(field + '-error');
                    errorElement.innerText = 'Enter a valid email address.';
                }else {
                    var errorElement = document.getElementById(field + '-error');
                    errorElement.innerText = '';
                }
            });
            return isValid;
        }
    </script>

        </body>
    </html>
    