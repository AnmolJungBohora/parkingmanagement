<?php
    session_start();
    error_reporting(0);
    include('base/databaseconnection.php');

    if (strlen($_SESSION['vpmsaid']==0)) {
    header('location:logout.php');
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
  background: #34425A;
  margin: -30px;
  text-align: center;
  color: white;
  font-size: 19px;
  margin-bottom: 35px;
  padding: 10px;
  
  
}

.td , .th{
 padding: 15px 20px;
 text-align: left;
 

}
.th{
 font-weight: bold;

}
.tr{
 width: 80%;
 background-color: #fafafa;
}
.tr:nth-child(even){
 background-color: #eeeeee;
}

.btn-container {
  display: flex;
  justify-content: center; 
  align-items: center; 
}

.btn{
  background: green;
  border: 1px solid #1598d4;
  padding: 10px;
  font-size: 16px;
  letter-spacing: 1px;
  border-radius: 3px;
  cursor: pointer;
  color: #fff;
  margin-top:20px;
}


  </style>

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
                <h1>Outgoing Vehicle Detail</h1>
                <small>Home / Outgoing Vehicle Detail</small>
            </div>
            <div class="content-main">
              <div class="wrapper">

		
                <div class="form_container">
                  <form name="form" method="POST">
                    <div class="heading">
                    <h2>Outgoing Vehicle Detail</h2>
                  </div>


                  <?php
                    $cid=$_GET['viewid'];
                    $ret=mysqli_query($con,"SELECT * from parkingdetails where ID='$cid'");
                    $cnt=1;
                    while ($row=mysqli_fetch_array($ret)) {

                    ?> 

                  <table class="table">
                      <tr class="tr">
                          <th class="th">Registration Number</th>
                          <td class="td"><?php echo $row['registrationnumber']; ?></td>
                          <th class="th">Brand Name</th>
                          <td class="td"><?php echo $row['vehiclebrand']; ?></td>
                      </tr>
                      <tr class="tr">
                          <th class="th">Category</th>
                          <td class="td"><?php echo $row['vehiclecategory']; ?></td>
                          <th class="th">Vehicle Owner Name</th>
                          <td class="td"><?php echo $row['ownername']; ?></td>
                      </tr>
                      <tr class="tr">
                          <th class="th">Vehicle Owner Contact Number</th>
                          <td class="td"><?php echo $row['ownernumber']; ?></td>
                          <th class="th">Parking Number</th>
                          <td class="td">PA-<?php echo $row['parkingnumber']; ?></td>
                      </tr>
                      <tr class="tr">
                          <th class="th">Vehicle Parked Time</th>
                          <td class="td"><?php echo $row['parkedtime']; ?></td>
                          <th class="th">Vehicle Out Time</th>
                          <td class="td"><?php echo $row['vehicletaken']; ?></td>
                      </tr>
                      <tr class="tr">
                          <th class="th">Current Status</th>
                          <td class="td"><?php echo ($row['status'] == "") ? "Vehicle Parked" : (($row['status'] == "Out") ? "Vehicle Out" : ""); ?></td>
                          <th class="th">Operated By</th>
                          <td class="td">
                          <?php
                              $user_query = mysqli_query($con, "SELECT a.firstname, a.lastname FROM parkingdetails p JOIN admin a ON a.ID = p.adminid where p.ID='$cid'");
                              if ($user_query) {
                                if (mysqli_num_rows($user_query) > 0) {
                                  $user_row = mysqli_fetch_assoc($user_query);
                                  $first_name = $user_row['firstname'];
                                  $last_name = $user_row['lastname'];
                                  echo "$first_name $last_name";
                              }
                            } 
                          ?>
                          </td>
                      </tr>
                      <tr class="tr">
                          <th class="th">Total Charge</th>
                          <td colspan="3" class="td">Rs. <?php echo $row['parkingcharge']; ?></td>
                      </tr>
                  </table>
           
                  <?php } ?>

                  <div class="btn-container">
                  <a href="#" onclick="openPrintView();" class="btn">Print Bill</a>
                  </div>
                  </form>
                </div>
                </div>
        </div>
        </main>
        
    </div>


    <script>
function openPrintView() {
    var printWindow = window.open('printinvoice.php?viewid=<?php echo $cid;?>', '_blank');
    printWindow.onload = function() {
        printWindow.print();
    };
}
</script> 
</body>
</html>

