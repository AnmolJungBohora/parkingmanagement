
<?php
    session_start();
    error_reporting(0);
    include('base/databaseconnection.php');
    if (strlen($_SESSION['vpmsaid']==0)) {
        header('location:logout.php');
        } else {
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width,initial-scale=1,maximum-scale=1">
    <title>PMS</title>
    <link rel="stylesheet" href="style.css">

	<link href="css/font-awesome.min.css" rel="stylesheet">
    <link href="css/datatable.css" rel="stylesheet">
	<link href="css/datepicker3.css" rel="stylesheet">
    <link rel="stylesheet" href="https://maxst.icons8.com/vue-static/landings/line-awesome/line-awesome/1.3.0/css/line-awesome.min.css">

    <style>
        .alert {
            padding: 15px;
            margin-top: 20px;
            margin-bottom: 20px;
            border: 1px solid transparent;
            border-radius: 4px;
        }

        .alert.bg-info {
            background-color: #d1ecf1;
            border-color: #bee5eb;
            color: #0c5460;
        }

        .alert .las {
            margin-right: 5px;
            font-size: 18px; /* Adjust size as needed */
        }

        .alert b {
            font-weight: bold;
        }

    </style>

</head>
<body>
    <?php
    $page="reports";
    include 'sidebar.php'
    ?>
    
    
    <div class="main-content">
        
       
        
        
        <main>
            
            <div class="page-header">
                <h1>View Reports</h1>
                <small>Home / View Reports</small>
            </div>
            <?php
                        $fdate=$_POST['fromdate'];
                        $tdate=$_POST['todate'];
                        ?>
            <div class="content-main">
                <div class="main">
            
                    <div class="row">
                            <div class="col-lg-12">
                                <div class="panel panel-default">
                                    <div class="panel-heading"style="font-size:20px;font-weight:bold;">Generate Reports
                                    <a href="generatepdf.php?fromdate=<?php echo $fdate; ?>&todate=<?php echo $tdate; ?>" class="btn btn-primary" style="float:right;">Generate Report in PDF</a>
                                    </div>
                                    <div class="panel-body">
                                    <table id="example" class="table" style="width:100%">
                         
                        <div class="alert bg-info" role="alert"> <em class="las la-file">&nbsp;</em>
                            Displaying reports from <b> <?php echo $fdate?> </b> to <b> <?php echo $tdate?> </b>
                        </div>
                    <thead>
                        <tr>
                            <th>S.N</th>
                            <th>Parking Number</th>
                            <th>Brand</th>
                            <th>Category</th>
                            <th>Vehicle Number</th>
                            <th>Vehicle's Owner</th>
                            <th>Total cost</th>
                            <th>Action</th>
                        
                        </tr>
                    </thead>
                    <tbody>
                    <?php
                        $ret=mysqli_query($con,"SELECT * FROM parkingdetails WHERE date(parkedtime) between '$fdate' and '$tdate'");
                        $cnt=1;
                        while ($row=mysqli_fetch_array($ret)) {

                        ?>
               
                        <tr>
            
                        <td><?php echo $cnt;?></td>
                             
                        <td><?php  echo 'PA-'.$row['parkingnumber'];?></td>
            
                        <td><?php  echo $row['vehiclecategory'];?></td>
                        <td><?php  echo $row['vehiclebrand'];?></td>
                        <td><?php  echo $row['registrationnumber'];?></td>
                        <td><?php  echo $row['ownername'];?></td>
                        <td><?php  echo 'Rs. '. $row['parkingcharge'];?></td>

                        <td><a href="managevehicleout.php?viewid=<?php echo $row['ID'];?>" target="_blank"> <button class="btn btn-success btn-sm" style="background:blue;color:white;">View Detail</button> </a>
                        </td>
                        </tr>
                        <?php $cnt=$cnt+1;}?>
            
             
                    
                    </tbody>
            
                </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
            
        </main>
        
    </div>

    <script src="js/jquery-1.11.1.min.js"></script>
	<script src="js/bootstrap.min.js"></script>
	<script src="js/chart.min.js"></script>
	<script src="js/chart-data.js"></script>
	<script src="js/easypiechart.js"></script>
	<script src="js/easypiechart-data.js"></script>
	<script src="js/jquery.dataTables.min.js"></script>
    <script src="js/dataTables.bootstrap4.min.js"></script>
	<script src="js/bootstrap-datepicker.js"></script>
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

    <script>
        $(document).ready(function() {
    $('#example').DataTable();
} );
    </script>

</body>
</html>

<?php }  ?>