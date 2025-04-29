<?php
    session_start();
    error_reporting(0);
    include('base/databaseconnection.php');

    if (strlen($_SESSION['vpmsaid']==0)) {
    header('location:logout.php');
    } else {

    if(isset($_POST['updatedata'])){
        $cid=$_SESSION['vpmsaid'];
        $firstname=$_POST['firstname'];
        $lastname=$_POST['lastname'];
        $phonenumber=$_POST['phonenumber'];
        $address=$_POST['address'];


        $check_phonenumber_query = mysqli_query($con, "SELECT * FROM admin WHERE phonenumber = '$phonenumber'");
        if(mysqli_num_rows($check_phonenumber_query) > 0) {
            $_SESSION['phonenumber_error'] = "Phone Number already exists.";
            $_SESSION['existing_phonenumber'] = $phonenumber;
        }

    
        $query=mysqli_query($con, "UPDATE admin set firstname='$firstname',lastname='$lastname',phonenumber='$phonenumber', address='$address' where ID='$cid'");
        if ($query) {
          $_SESSION['success_msg'] = "Profile updated successfully."; 
          header('location:dashboard.php'); 
          exit(); 
        } else {
          $_SESSION['error_msg'] = "Something Went Wrong. Please try again"; 
          header('location:dashboard.php'); 
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
.wrapper .form_container .form_item{
  margin-bottom: 25px;
}




.wrapper .form_container .form_item label{
  display: block;
  margin-bottom: 5px;
}

.form_item input[type="text"],
.form_item select{
  width: 100%;
  padding: 10px;
  font-size: 16px;
  border: 1px solid #dadce0;
  border-radius: 3px;
}

.form_item input[type="text"]:focus{
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
    resize: vertical; 
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
    $page="profile";
    include 'sidebar.php'
    ?>
    
    
    <div class="main-content">
        
        
        <main>
            
            <div class="page-header">
                <h1>Profile</h1>
                <small>Home / Profile</small>
            </div>
            <div class="content-main">
              <div class="wrapper">

		
                <div class="form_container">
                  <form name="form" method="POST" onsubmit="return validateForm()">
                    <div class="heading">
                    <h2>Profile</h2>
                  </div>
                  

                  <?php
                    $cid=$_SESSION['vpmsaid'];
                    $ret=mysqli_query($con,"SELECT * from admin where ID='$cid'");
                    $cnt=1;
                    while ($row=mysqli_fetch_array($ret)) {

                    ?> 

                  <div class="form_wrap">
                    <div class="form_item">
                      <label>First Name</label>
                      <input type="text" value="<?php  echo $row['firstname'];?>" id="firstname" name="firstname">
                      <div class="error-message" id="firstname-error"></div>
                    </div>
                  </div>
                  <div class="form_wrap">
                    <div class="form_item">
                      <label>Last Name</label>
                      <input type="text" value="<?php  echo $row['lastname'];?>" id="lastname" name="lastname">
                      <div class="error-message" id="lastname-error"></div>
                    </div>
                  </div>
                  <div class="form_wrap">
                    <div class="form_item">
                      <label>Username</label>
                      <input type="text" value="<?php  echo $row['username'];?>" id="username" name="username" style="background:#DEDEDE;" readonly>
                      <div class="error-message" id="username-error"></div>
                    </div>
                  </div>
                  <div class="form_wrap">
                    <div class="form_item">
                      <label>Email</label>
                      <input type="text" value="<?php  echo $row['email'];?>" id="email" name="email" readonly style="background:#DEDEDE;">
                      <div class="error-message" id="email-error"></div>
                    </div>
                  </div>
                  <div class="form_wrap">
                    <div class="form_item">
                      <label>Phone Number</label>
                      <input type="text" value="<?php  echo $row['phonenumber'];?>" id="phonenumber" name="phonenumber">
                      <div class="error-message" id="phonenumber-error"></div>
                    </div>
                  </div>
                  <div class="form_wrap">
                    <div class="form_item">
                      <label>Address</label>
                      <input type="text" value="<?php  echo $row['address'];?>" id="address" name="address">
                      <div class="error-message" id="address-error"></div>
                    </div>
                  </div>

                  <?php } ?>

                  <div class="btn">
                    <input type="submit" value="Make Changes" name="updatedata">
                  </div>
                  </form>
                </div>
                </div>
        </div>
        </main>
        
    </div>

    <script>
        function validateForm() {
            var fields = ['firstname', 'lastname', 'username','email', 'phonenumber','address'];
            var labels = ['First Name', 'Lastname','Username', 'Email','Phone Number', 'Address'];
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

            var phonenumberError = "<?php echo isset($_SESSION['phonenumber_error']) ? $_SESSION['phonenumber_error'] : '' ?>";
            var existingNumber = "<?php echo isset($_SESSION['existing_phonenumber']) ? $_SESSION['existing_phonenumber'] : '' ?>";

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