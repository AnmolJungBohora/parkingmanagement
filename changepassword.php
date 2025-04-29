<?php
    session_start();
    error_reporting(0);
    include('base/databaseconnection.php');

    if (strlen($_SESSION['vpmsaid']==0)) {
    header('location:logout.php');
    } else {
      
    if(isset($_POST['changepassword'])){
        $adminid=$_SESSION['vpmsaid'];
        $currentpassword = md5($_REQUEST['currentpassword']);
        $pwd = md5($_REQUEST['password']);
        $cpwd = md5($_REQUEST['confirmpassword']);

        $query=mysqli_query($con,"SELECT ID from admin where ID='$adminid' and   password='$currentpassword'");
        $row=mysqli_fetch_array($query);

        if($row>0){
          if($pwd === $cpwd) {
            $ret=mysqli_query($con,"update admin set password='$pwd' where ID='$adminid'");
            $_SESSION['success_msg'] = "Password successfully updated."; 
            header('location:index.php'); 
            exit();
          } else {
              $msg= "New password and confirm password did not match !!";
          }
        } else {
        $msg="Your existing password is wrong !!"; } 

    } 
?>

<!DOCTYPE html>
<html lang="en">
<head>
 
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>PMS</title>
 
  <style>
 @import url('https://fonts.googleapis.com/css?family=Josefin+Sans:300,400,700&display=swap');

.wrapper{
  max-width: 1200px;
  width: 100%;
  margin: 10px auto 0;
  padding: 10px;

}

.wrapper .form_container{
  background: #fff;
  padding: 30px;
  box-shadow: 1px 1px 15px rgba(0, 0, 0, 0.15);
  border-radius: 3px;
}
.heading{
  background: grey;
  margin: -30px;
  text-align: center;
  color: white;
  font-size: 19px;
  margin-bottom: 35px;
  padding: 10px;
  
  
}
.wrapper .form_container .form_item{
  margin-bottom: 25px;
}




.wrapper .form_container .form_item label{
  display: block;
  margin-bottom: 5px;
}

.form_item input[type="password"],
.form_item select{
  width: 100%;
  padding: 10px;
  font-size: 16px;
  border: 1px solid #dadce0;
  border-radius: 3px;
}

.form_item input[type="password"]:focus{
  border-color: #6271f0;
}

.btn input[type="submit"]{
  background: green;
  border: 1px solid #1598d4;
  padding: 10px;
  width: 100%;
  font-size: 16px;
  letter-spacing: 1px;
  border-radius: 3px;
  cursor: pointer;
  color: #fff;
}
textarea {
    width: 100%;
    height: 150px;
    padding: 10px;
    border: 1px solid #ccc;
    border-radius: 5px;
    background-color: #f7f7f7;
    font-size: 16px;
    resize: vertical; /* Allow vertical resizing */
}
.error-message {
            color: red;
            font-size: 1em;
            margin-top:10px;
        }
  </style>

    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="https://maxst.icons8.com/vue-static/landings/line-awesome/line-awesome/1.3.0/css/line-awesome.min.css">
    <script type="module" src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.esm.js"></script>
                <script nomodule src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.js"></script>
</head>
<body>
<?php
    $page="managevehiclein";
    include 'sidebar.php'
    ?>
    
    
    <div class="main-content">
        
        
        <main>
            
            <div class="page-header">
                <h1>Change Password</h1>
                <small>Home / Change Password</small>
            </div>
            <div class="content-main">
              <div class="wrapper">

		
                <div class="form_container">
                  <form name="form" method="POST" onsubmit="return validateForm()">
                    <div class="heading">
                    <h2>Change Password</h2>
                  </div>

                  <?php
                    $adminid=$_SESSION['vpmsaid'];
                    $ret=mysqli_query($con,"SELECT * from admin where ID='$adminid'");
                    $cnt=1;
                    while ($row=mysqli_fetch_array($ret)) {

                    ?> 

                  <div class="form_wrap">
                    <div class="form_item">
                      <label>Existing Password</label>
                      <input type="password" id="currentpassword" name="currentpassword">
                      <div class="error-message" id="currentpassword-error"></div>
                    </div>
                  </div>
                  <div class="form_wrap">
                    <div class="form_item">
                      <label>New Password</label>
                      <input type="password" id="password" name="password">
                      <div class="error-message" id="password-error"></div>
                    </div>
                  </div>
                  <div class="form_wrap">
                    <div class="form_item">
                      <label>Confirm Password</label>
                      <input type="password" id="confirmpassword" name="confirmpassword">
                      <div class="error-message" id="confirmpassword-error"></div>
                    </div>
                  </div>
                  

                  <?php } ?>

                  <div class="btn">
                    <input type="submit" value="Make Changes" name="changepassword">
                  </div>
                  </form>
                </div>
                </div>
        </div>
        </main>
        
    </div>

    <?php if ($msg): ?>
        <script>
            alertify.set('notifier','position', 'top-right');
            var messageText = '<span style="font-size: 24px;"><?php echo htmlentities($msg); ?></span>';
            alertify.error(messageText);
        </script>
    <?php endif; ?>
    <script>
        function validateForm() {
            var fields = ['currentpassword', 'password','confirmpassword'];
            var labels = ['Existing Password', 'Password','Confirm Password'];
            var isValid = true;
            var passwordPattern = /^(?=.*[a-z])(?=.*[A-Z])(?=.*\d).{8,}$/;

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
</body>
</html>

<?php }  ?>