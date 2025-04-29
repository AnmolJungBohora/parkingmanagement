<?php
    session_start();
    error_reporting(0);
    include('base/databaseconnection.php');
    if (strlen($_SESSION['vpmsaid']==0)) {
        header('location:logout.php');
        } else {

          $admin_id = $_GET['editid']; 
          $sql = "SELECT * FROM admin WHERE ID = '$admin_id'";
          $result = mysqli_query($con, $sql);
          $admin_data = mysqli_fetch_assoc($result);

            if(isset($_POST['editadmin']))
    {
        $firstname=$_POST['firstname'];
        $lastname=$_POST['lastname'];
        $phonenumber=$_POST['phonenumber'];
        $address=$_POST['address'];
        $username=$_POST['username'];
        $email=$_POST['email'];
        $password=md5($_POST['password']);
        $admin_type = $_POST['admin_type'];
        $eid=$_GET['editid'];
        

        $existing_username = $admin_data['username'];
        $existing_email = $admin_data['email'];
        $existing_phonenumber = $admin_data['phonenumber'];

        if ($username !== $existing_username) {
            $check_username_query = mysqli_query($con, "SELECT * FROM admin WHERE username = '$username'");
            if (mysqli_num_rows($check_username_query) > 0) {
                $_SESSION['username_error'] = "Username already exists.";
                $_SESSION['existing_username'] = $username;
            }
        }

        if ($email !== $existing_email) {
          $check_email_query = mysqli_query($con, "SELECT * FROM admin WHERE email = '$email'");
          if (mysqli_num_rows($check_email_query) > 0) {
              $_SESSION['email_error'] = "Email already exists.";
              $_SESSION['existing_email'] = $email;
          }
        }

        if ($phonenumber !== $existing_phonenumber) {
            $check_phonenumber_query = mysqli_query($con, "SELECT * FROM admin WHERE phonenumber = '$phonenumber'");
            if (mysqli_num_rows($check_phonenumber_query) > 0) {
                $_SESSION['phonenumber_error'] = "Phone Number already exists.";
                $_SESSION['existing_phonenumber'] = $phonenumber;
            }
        }

        $query=mysqli_query($con, "UPDATE admin set firstname='$firstname',lastname='$lastname',phonenumber='$phonenumber',address='$address',username='$username',email='$email',admintype='$admin_type' where ID='$eid'");
        if ($query) {
          $_SESSION['success_msg'] = "Admin Details has been updated."; 
          header('location:manageadmin.php'); 
          exit(); 
        } else {
            $_SESSION['error_msg'] = "Something Went Wrong. Please try again"; 
            header('location:manageadmin.php'); 
            exit(); 
        }

    
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
.wrapper .form_container{
  margin-bottom: 25px;
}



.form_container form .row{
  display: flex;
  flex-wrap: wrap;
  gap:15px;
}

.form_container form .row .col{
  flex:1 1 250px;
}

.form_container form .row .col {
  font-size: 20px;
  color:#333;
  padding-bottom: 5px;

}

.form_container form .row .col .inputBox{
  margin:15px 0;
}

.form_container form .row .col .inputBox span{
  margin-bottom: 10px;
  display: block;
  font-weight:bold;
  font-size:17px;
}

.form_container form .row .col .inputBox input{
  width: 100%;
  border:1px solid #ccc;
  padding:10px 15px;
  font-size: 15px;
  text-transform: none;
}

.form_container form .row .col .inputBox input:focus{
  border:1px solid #000;
}



.form_container form .submit-btn{
  width: 100%;
  padding:12px;
  font-size: 17px;
  background: #337ab7;
  border: 1px solid #1598d4;
  color:#fff;
  margin-top: 5px;
  cursor: pointer;
}

input[type="radio"] {
        display: none;
    }

    /* Style for the custom radio buttons */
    .radio-wrapper {
        display: inline-block;
        position: relative;
        padding-left: 25px;
        margin-right: 15px;
        cursor: pointer;
    }

    /* Style for the radio button circle */
    .radio-wrapper .radio-circle {
        position: absolute;
        top: 50%;
        left: 0;
        transform: translateY(-50%);
        width: 20px;
        height: 20px;
        border: 2px solid #aaa;
        border-radius: 50%;
        background-color: #fff;
    }

    /* Style for the radio button circle when selected */
    .radio-wrapper input[type="radio"]:checked + .radio-circle::after {
        content: "";
        display: block;
        width: 14px;
        height: 14px;
        border-radius: 50%;
        background-color: #555;
        position: absolute;
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%);
    }

    /* Style for the radio button label */
    .radio-label {
        font-size: 17px;
    }
    .error-message {
            color: red;
            font-size: 0.8em;
            margin-top:10px;
        }
  </style>
</head>
<body>
<?php
    $page="editadmin";
    include 'sidebar.php'
    ?>
    
    
    <div class="main-content">
        
       
        
        
        <main>
            
            <div class="page-header">
                <h1>Edit Admin</h1>
                <small>Home / Edit Admin</small>
            </div>
            <div class="content-main">
              <div class="wrapper">

		
                <div class="form_container">
                  <form name="form" method="POST" onsubmit="return validateForm()">
                  <?php
                      $cid=$_GET['editid'];
                      $ret=mysqli_query($con,"SELECT * from  admin where ID='$cid'");
                      $cnt=1;
                      while ($row=mysqli_fetch_array($ret)) {

                    ?>  
                    <div class="heading">
                    <h2>Update Admin Details</h2>
                  </div>
                  

<div class="row">

    <div class="col">


        <div class="inputBox">
            <span>First Name :</span>
            <input type="text" id="firstname" name="firstname" value="<?php  echo $row['firstname'];?>">
            <div class="error-message" id="firstname-error"></div>
        </div>
        <div class="inputBox">
            <span>Phone Number :</span>
            <input type="text" id="phonenumber" name="phonenumber" value="<?php  echo $row['phonenumber'];?>">
            <div class="error-message" id="phonenumber-error"></div>
        </div>
        <div class="inputBox">
            <span>Username :</span>
            <input type="text" id="username" name="username" value="<?php  echo $row['username'];?>">
            <div class="error-message" id="username-error"></div>
        </div>
        <div class="inputBox">
            <span>Admin Type :</span>
            <label class="radio-wrapper radio-label">
                <input type="radio" name="admin_type" value=0 <?php if($row['admintype'] == 0) echo "checked"; ?>>
                <span class="radio-circle"></span>
                Admin
            </label>
            <label class="radio-wrapper radio-label">
                <input type="radio" name="admin_type" value=1 <?php if($row['admintype'] == 1) echo "checked"; ?>>
                <span class="radio-circle"></span>
                Super Admin
            </label>
        </div>

    </div>

    <div class="col">
        <div class="inputBox">
            <span>Last Name :</span>
            <input type="text" id="lastname" name="lastname" value="<?php  echo $row['lastname'];?>">
            <div class="error-message" id="lastname-error"></div>
        </div>
        <div class="inputBox">
            <span>Address :</span>
            <input type="text" id="address" name="address" value="<?php  echo $row['address'];?>">
            <div class="error-message" id="address-error"></div>
        </div>
        <div class="inputBox">
            <span>Email :</span>
            <input type="email" id="email" name="email" value="<?php  echo $row['email'];?>">
            <div class="error-message" id="email-error"></div>
        </div>
    </div>

</div>
<?php }?>
<input type="submit" value="Update" class="submit-btn" name="editadmin">


                  </form>
                </div>
                </div>
        </div>
        </main>
        
    </div>

    <script>
        function validateForm() {
            var fields = ['firstname', 'phonenumber', 'username', 'lastname', 'address', 'email'];
            var labels = ['First Name', 'Phone Number', 'Username', 'Last Name', 'Address', 'Email'];
            var isValid = true;
            var phoneRegex = /^\d{10}$/; 
            var emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;

            fields.forEach(function(field,index) {
                var value = document.getElementById(field).value.trim();
                if (value === '') {
                    isValid = false;
                    var errorElement = document.getElementById(field + '-error');
                    errorElement.innerText = labels[index] + ' cannot be empty.';
                } else if (field === 'phonenumber' && !phoneRegex.test(value)) {
                    isValid = false;
                    var errorElement = document.getElementById(field + '-error');
                    errorElement.innerText = 'Please enter a valid phone number i.e. 98XXXXXXXX';
                }else if (field === 'email' && !emailRegex.test(value)) {
                    isValid = false;
                    var errorElement = document.getElementById(field + '-error');
                    errorElement.innerText = 'Enter a valid email address.';
                }else {
                    var errorElement = document.getElementById(field + '-error');
                    errorElement.innerText = '';
                }
            });

            // Display error messages for username and email
        var usernameError = "<?php echo isset($_SESSION['username_error']) ? $_SESSION['username_error'] : '' ?>";
        var existingUsername = "<?php echo isset($_SESSION['existing_username']) ? $_SESSION['existing_username'] : '' ?>";

        var emailError = "<?php echo isset($_SESSION['email_error']) ? $_SESSION['email_error'] : '' ?>";
        var existingEmail = "<?php echo isset($_SESSION['existing_email']) ? $_SESSION['existing_email'] : '' ?>";

        var phonenumberError = "<?php echo isset($_SESSION['phonenumber_error']) ? $_SESSION['phonenumber_error'] : '' ?>";
        var existingNumber = "<?php echo isset($_SESSION['existing_phonenumber']) ? $_SESSION['existing_phonenumber'] : '' ?>";

        if (usernameError !== '' && document.getElementById('username').value === existingUsername) {
            isValid = false;
            document.getElementById('username-error').innerText = usernameError;
            
        }

        if (emailError !== '' && document.getElementById('email').value === existingEmail) {
            isValid = false;
            document.getElementById('email-error').innerText = emailError;
            
        }

        if (phonenumberError !== '' && document.getElementById('phonenumber').value === existingNumber) {
            isValid = false;
            document.getElementById('phonenumber-error').innerText = phonenumberError;
            
        }

            return isValid;
        }
    </script>

</body>
</html>

<?php }  ?>