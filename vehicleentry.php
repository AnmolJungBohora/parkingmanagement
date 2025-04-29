<?php
	session_start();
	error_reporting(0);
	include('base/databaseconnection.php');
	if (strlen($_SESSION['vpmsaid']==0)) {
	header('location:logout.php');
	} else {

	if(isset($_POST['vehicleentry'])) {
		$parkingnumber=mt_rand(10000, 99999);
		$category=$_POST['category'];
		$brand=$_POST['brand'];
		$registrationno=$_POST['registrationno'];
		$ownername=$_POST['ownername'];
		$ownerno=$_POST['ownerno'];
		$parkedtime=$_POST['parkedtime'];
    $adminid=$_SESSION['vpmsaid'];

		$query=mysqli_query($con, "INSERT into parkingdetails(parkingnumber,vehiclecategory,vehiclebrand,registrationnumber,ownername,ownernumber,adminid) value('$parkingnumber','$category','$brand','$registrationno','$ownername','$ownerno','$adminid')");
		if ($query) {
      $_SESSION['success_msg'] = "Parking details has been uploaded."; 
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
  background: #337ab7;
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
    $page="vehicleentry";
    include 'sidebar.php'
    ?>
    
    
    <div class="main-content">
        
       
        
        
        <main>
            
            <div class="page-header">
                <h1>Vehicle Entry</h1>
                <small>Home / Vehicle Entry</small>
            </div>
            <div class="content-main">
              <div class="wrapper">

		
                <div class="form_container">
                  <form name="form" method="POST" onsubmit="return validateForm()">
                    <div class="heading">
                    <h2>Vehicle Entry</h2>
                  </div>
                  
                  <div class="form_wrap">
                    <div class="form_item">
                      <label>Registration Number</label>
                      <input type="text" id="registrationno" name="registrationno">
                      <div class="error-message" id="registrationno-error"></div>
                    </div>
                  </div>
                  <div class="form_wrap">
                    <div class="form_item">
                      <label>Company Name</label>
                      <input type="text" id="brand" name="brand">
                      <div class="error-message" id="brand-error"></div>
                    </div>
                  </div>
                  <div class="form_wrap">
                    <div class="form_item">
                      <label>Category</label>
                      <select class="form-control" name="category" id="category">
                      <option value="0">Select Category</option>
                      <?php $query=mysqli_query($con,"select * from vehiclecategory");
                        while($row=mysqli_fetch_array($query))
                        {
                        ?>    
                        <option value="<?php echo $row['category'];?>"><?php echo $row['category'];?></option>
                      <?php } ?> 
										</select>
                    <div class="error-message" id="category-error"></div>
                    </div>
                  </div>
                  <div class="form_wrap">
                    <div class="form_item">
                      <label>Owner Name</label>
                      <input type="text" id="ownername" name="ownername">
                      <div class="error-message" id="ownername-error"></div>
                    </div>
                  </div>
                  <div class="form_wrap">
                    <div class="form_item">
                      <label>Owner Contact Number</label>
                      <input type="text" id="ownerno" name="ownerno" >
                      <div class="error-message" id="ownerno-error"></div>
                    </div>
                  </div>
            
                  <div class="btn">
                    <input type="submit" value="Add" name="vehicleentry">
                  </div>
                  </form>
                </div>
                </div>
        </div>
        </main>
        
    </div>

    <script>
        function validateForm() {
            var fields = ['registrationno', 'brand','category', 'ownername', 'ownerno'];
            var labels = ['Registration Number', 'Brand','Category','Owner Name','Owner Number'];
            var isValid = true;
            var phoneRegex = /^\d{10}$/; 


            fields.forEach(function(field,index) {
                var value = document.getElementById(field).value.trim();
                if (value === '') {
                    isValid = false;
                    var errorElement = document.getElementById(field + '-error');
                    errorElement.innerText = labels[index] + ' cannot be empty.';
                } else if (field === 'category' && value === '0') {
                    isValid = false;
                    var categoryErrorElement = document.getElementById(field + '-error');
                    categoryErrorElement.innerText = 'Please select a category.';
                } else if (field === 'ownerno' && !phoneRegex.test(value)) {
                    isValid = false;
                    var errorElement = document.getElementById(field + '-error');
                    errorElement.innerText = 'Please enter a valid phone number i.e. 98XXXXXXXX';
                } else {
                    var errorElement = document.getElementById(field + '-error');
                    errorElement.innerText = '';
                }
            });
            return isValid;
        }
    </script>

  	<script src="js/jquery-1.11.1.min.js"></script>
    <script src="js/bootstrap.min.js"></script>
    <script src="js/chart.min.js"></script>
    <script src="js/chart-data.js"></script>
    <script src="js/easypiechart.js"></script>
    <script src="js/easypiechart-data.js"></script>
    <script src="js/bootstrap-datepicker.js"></script>
    <script src="js/custom.js"></script>
    <script>
      window.onload = function () {
      var chart1 = document.getElementById("line-chart").getContext("2d");
      window.myLine = new Chart(chart1).Line(lineChartData, {
      responsive: true,
      scaleLineColor: "rgba(0,0,0,.2)",
      scaleGridLineColor: "rgba(0,0,0,.05)",
      scaleFontColor: "#c5c7cc"
      });
  };
    </script>

</body>
</html>

<?php }  ?>