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
</head>
<body>
    
    <?php
    $page="vehiclecategory";
    include 'sidebar.php'
    ?>
    
    <div class="main-content">
        
        <main>
            
            <div class="page-header">
                <h1>Vehicle Category</h1>
                <small>Home / Vehicle Category</small>
            </div>
            
            <div class="content-main">
                <div class="main">
            
                    <div class="row">
                            <div class="col-lg-12">
                                <div class="panel panel-default">
                                    <div class="panel-heading"style="font-size:20px;font-weight:bold;">Vehicle Categories <a href="addcategory.php" type="button" class="btn btn-sm btn-primary" style="float:right;">Add New Vehicle Category</a>
                                    
                                    </div>
                                    <div class="panel-body">
                                    <table id="example" class="table" style="width:100%">
                                    
                    <thead>
                        <tr>
                            <th>S.N</th>
                            <th>Vehicle Category</th>
                            <th>Published On</th>
                            <th>Actions</th>
            
                        </tr>
                    </thead>
                    <tbody>
                    <?php
                        $ret=mysqli_query($con,"SELECT * from  vehiclecategory");
                        $cnt=1;
                        while ($row=mysqli_fetch_array($ret)) {

                    ?>
               
                        <tr>
            
                        <td><?php echo $cnt;?></td>
                             
                        <td><?php  echo $row['category'];?></td>
            
                        <td><?php  echo $row['created_at'];?></td>
                        
                        <td><a href="editcategory.php?editid=<?php echo $row['ID'];?>"> <button class="btn btn-success btn-sm" style="color:white;background:blue;"><span class="las la-pencil-alt"></span></button> </a>
                        <a href="deletecategory.php?editid=<?php echo $row['ID'];?>"> <button class="btn btn-danger btn-sm" style="color:white;background:red;"><span class="las la-trash"></span></button> </a>
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



</body>
</html>

<?php }  ?>