<?php
    session_start();
    error_reporting(0);
    include('base/databaseconnection.php');

    if (strlen($_SESSION['vpmsaid']==0)) {
    header('location:logout.php');
    } else {

    if(isset($_POST['updatedata'])){
        $cid=$_GET['updateid'];
        $remarks=$_POST['remarks'];
        $status=$_POST['status'];

        date_default_timezone_set('Asia/Kathmandu');
        // Retrieve the current time
        $currentTime = date('Y-m-d H:i:s');
        
        // Fetch parked time from database
        $query = mysqli_query($con, "SELECT parkedtime FROM parkingdetails WHERE ID='$cid'");
        $row = mysqli_fetch_array($query);
        $parkedTime = $row['parkedtime'];

        // Calculate time difference
        $parkedTimestamp = strtotime($parkedTime);
        $currentTimestamp = strtotime($currentTime);
        $timeDifference = $currentTimestamp - $parkedTimestamp;

        // Calculate hours parked
        $hoursParked = round($timeDifference / (60 * 60));


        $totalCharge = 100 + ($hoursParked * 50);

       
        // Update database with total charge
        $invoice = mt_rand(100000, 999999);
        $insert_query = mysqli_query($con, "INSERT INTO invoice (invoicenumber, pid) VALUES ('$invoice','$cid')");
        
        if ($insert_query) {
          $query=mysqli_query($con, "UPDATE parkingdetails set remarks='$remarks',status='$status',parkingcharge='$totalCharge' where ID='$cid'");
          if ($query) {
            $_SESSION['success_msg'] = "Vehicle taken out from parking."; 
            header('location:vehiclein.php'); 
            exit(); 
          } else {
            $_SESSION['error_msg'] = "Something Went Wrong. Please try again"; 
            header('location:vehiclein.php'); 
            exit(); 
          }
        }else {
            $_SESSION['error_msg'] = "Failed to generate invoice."; 
            header('location:vehiclein.php'); 
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
    resize: vertical; /* Allow vertical resizing */
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
                <h1>Manage Parked Vehicle</h1>
                <small>Home / Manage Parked Vehicle</small>
            </div>
            <div class="content-main">
              <div class="wrapper">

		
                <div class="form_container">
                  <form name="form" method="POST">
                    <div class="heading">
                    <h2>Manage Parked Vehicle</h2>
                  </div>
                  
                  <?php if($msg)
                    echo "<div class='alert bg-info ' role='alert' style='background:#54B4D3;color:white;font-size:25px;margin-bottom:20px;'>
                    <em class='fa fa-lg fa-warning'>&nbsp;</em> 
                    $msg
                    <a href='#' class='pull-right'>
                    <em class='fa fa-lg fa-close'>
                    </em></a></div>" ?> 

                  <?php
                    $cid=$_GET['updateid'];
                    $ret=mysqli_query($con,"SELECT * from parkingdetails where ID='$cid'");
                    $cnt=1;
                    while ($row=mysqli_fetch_array($ret)) {

                    ?> 

                  <div class="form_wrap">
                    <div class="form_item">
                      <label>Registration Number</label>
                      <input type="text" value="<?php  echo $row['registrationnumber'];?>" id="registrationnumber" name="registrationnumber" readonly style="background:#DEDEDE;">
                      
                    </div>
                  </div>
                  <div class="form_wrap">
                    <div class="form_item">
                      <label>Company Name</label>
                      <input type="text" value="<?php  echo $row['vehiclebrand'];?>" id="vehiclebrand" name="vehiclebrand" readonly style="background:#DEDEDE;">
                      
                    </div>
                  </div>
                  <div class="form_wrap">
                    <div class="form_item">
                      <label>Category</label>
                      <input type="text" value="<?php  echo $row['vehiclecategory'];?>" id="vehiclecategory" name="vehiclecategory" readonly style="background:#DEDEDE;">
                      
                    </div>
                  </div>
                  <div class="form_wrap">
                    <div class="form_item">
                      <label>Vehicle Owner Name</label>
                      <input type="text" value="<?php  echo $row['ownername'];?>" id="ownername" name="ownername" readonly style="background:#DEDEDE;">
                      
                    </div>
                  </div>
                  <div class="form_wrap">
                    <div class="form_item">
                      <label>Vehicle Owner Contact Number</label>
                      <input type="text" value="<?php  echo $row['ownernumber'];?>" id="ownernumber" name="ownernumber" readonly style="background:#DEDEDE;">
                      
                    </div>
                  </div>
                  <div class="form_wrap">
                    <div class="form_item">
                      <label>Parking Number</label>
                      <input type="text" value="<?php  echo $row['parkingnumber'];?>" id="parkingnumber" name="parkingnumber" readonly style="background:#DEDEDE;">
                      
                    </div>
                  </div>
                  <div class="form_wrap">
                    <div class="form_item">
                      <label>Vehicle Parked Time</label>
                      <input type="text" value="<?php  echo $row['parkedtime'];?>" id="parkedtime" name="parkedtime" readonly style="background:#DEDEDE;">
                      
                    </div>
                  </div>
                  <div class="form_wrap">
                    <div class="form_item">
                      <label>Current Status</label>
                      <input type="text" value="<?php if($row['status']==""){ echo "Vehicle Parked"; } if($row['status']=="Out"){echo "Vehicle out";} ;?>" id="currentstatus" name="currentstatus" readonly style="background:#DEDEDE;">
                      
                    </div>
                  </div>
                  
                  <div class="form_wrap">
                    <div class="form_item">
                      <label>Status</label>
                      <select name="status" class="form-control" required="true" >
                        <option value="Out">Outgoing Vehicle</option>
                      </select>
      
                    </div>
                  </div>
                  <div class="form_wrap">
                    <div class="form_item">
                      <label>Remarks</label>
                      <input type="text" id="remarks" name="remarks">
                      
                    </div>
                  </div>


                  <?php } ?>

                  <div class="btn">
                    <input type="submit" value="Submit for Outgoing" name="updatedata">
                  </div>
                  </form>
                </div>
                </div>
        </div>
        </main>
        
    </div>


    
</body>
</html>

<?php }  ?>