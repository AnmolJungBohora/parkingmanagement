<?php
    session_start();
    error_reporting(0);
    include('base/databaseconnection.php');
    if (strlen($_SESSION['vpmsaid']==0)) {
        header('location:logout.php');
        } else {
?>

<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>PMS</title>
    <style>
        .panel {
            border: 1px solid #ddd;
            border-radius: 4px;
            margin-bottom: 20px;
        }

        .panel-heading {
            background-color: #f5f5f5;
            border-bottom: 1px solid #ddd;
            padding: 10px 15px;
            border-radius: 3px 3px 0 0;
        }

        .panel-body {
            padding: 15px;
        }

        .form-row {
            display: flex;
            flex-wrap: wrap;
            justify-content: space-between; 
        }

        .form-group {
            width: 49%; 
        }

        .form-group label {
            margin-bottom: 5px;
            font-weight:bold;
        }

        .form-control {
            width: calc(100% - 10px); 
            padding: 8px 14px;
            font-size: 16px;
            line-height: 1.8;
            color: #555;
            background-color: #fff;
            border: 1px solid #ccc;
            border-radius: 4px;
        }

        .text-center {
            text-align: center;
            margin-top:10px;
            margin-bottom:25px;
        }
        .error-message {
            color: red;
            font-size: 1em;
            margin-top:10px;
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
            
            <div class="content-main">	
                <div class="panel panel-default">
                    <div class="panel-heading">Parking Reports</div>
                        <form method="POST" enctype="multipart/form-data" name="datereports" action="generatereports.php" onsubmit="return validateForm()">
                            <div class="panel-body">
                                <?php if($msg)
                                    echo "<div class='alert bg-danger' role='alert'>
                                    <em class='fa fa-lg fa-warning'>&nbsp;</em> 
                                    $msg
                                    <a href='#' class='pull-right'>
                                    <em class='fa fa-lg fa-close'>
                                    </em></a></div>" 
                                ?> 
                                <div class="form-row">
                                    <div class="form-group">
                                        <label for="fromdate">From</label>
                                        <input class="form-control" type="date" name="fromdate" id="fromdate">
                                        <div class="error-message" id="fromdate-error"></div>
                                    </div>
                                    <div class="form-group">
                                        <label for="todate">To</label>
                                        <input class="form-control" type="date" name="todate" id="todate">
                                        <div class="error-message" id="todate-error"></div>
                                    </div>
                                </div>
                            </div>
                            <div class="text-center">
                                <button type="submit" class="btn btn-primary" name="submit">Generate Report</button>
                            </div>
                        </form>
                    </div>
		        </div>
            </div>
		</main>
    </div>
    <script>
    function validateForm() {
        var fields = ['fromdate', 'todate'];
        var labels = ['From Date', 'To Date'];
        var isValid = true;
        var currentDate = new Date();
        fields.forEach(function(field, index) {
            var value = document.getElementById(field).value.trim();
            if (value === '') {
                isValid = false;
                var errorElement = document.getElementById(field + '-error');
                errorElement.innerText = labels[index] + ' cannot be empty.';
            } else {
                var selectedDate = new Date(value);
                if (selectedDate > currentDate) {
                    isValid = false;
                    var errorElement = document.getElementById(field + '-error');
                    errorElement.innerText = labels[index] + ' cannot be a future date.';
                } else {
                    var errorElement = document.getElementById(field + '-error');
                    errorElement.innerText = '';
                }
            }
        });
        return isValid;
    }
</script>

</body>
</html>

<?php }  ?>