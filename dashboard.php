<?php
    include('base/databaseconnection.php');
    $query = "SELECT vehiclecategory FROM parkingdetails";
    $result = mysqli_query($con, $query);

    $categoryCounts = array();

    while ($row = mysqli_fetch_assoc($result)) {
        $category = $row['vehiclecategory'];
        if (isset($categoryCounts[$category])) {
            $categoryCounts[$category]++;
        } else {
            $categoryCounts[$category] = 1;
        }
    }


    $categoryLabels = array_keys($categoryCounts);
    $categoryData = array_values($categoryCounts);
    ?>


<DOCTYPE html>
    <html lang="en">
        <head>
            <meta charset="utf-8">
            <meta http-equiv="X-UA-Compatible" content="IE=edge">
            <meta name="viewport" content="width=device-width, initial-scale=1">
            <title>Dashboard</title>
            <style>
                .MainCard {
                    width: 100%;
                    padding: 0 20px;
                    display: grid;
                    grid-template-columns: repeat(4, 1fr);
                    grid-gap: 20px;
                  }
                  .MainCard .Card {
                    display: flex;
                    justify-content: space-between;
                    align-items: center;
                    padding: 20px;
                    background: #fff;
                    border-radius: 10px;
                    box-shadow: 0 4px 8px 0 rgba(0, 0, 0, 0.9);
                    transition: 0.2s;
                  }
                  .Card:hover {
                    background: #9d9d9d;
                    color: #fff;
                    cursor: pointer;
                  }
                  .Card .num {
                    color: #2c2c56;
                    font-size: 35px;
                    font-weight: 500;
                  }
                  .Card .name {
                    font-weight: 600;
                    font-size: 20px;
                    color: black;
                  }
                  .Card:hover .name {
                    color: #fff;
                  }
                  .Card .icon  {
                    color:#2c2c56;
                    font-size: 45px;
                  }
                  
                  .MainChart {
                    display: grid;
                    grid-template-columns:  2fr 1fr;
                    grid-gap: 20px;
                    width: 100%;
                    padding: 20px;
                    padding-top: 0;
                  }
                  .MainChart .Chart {
                    background: #fff;
                    box-shadow: 0 4px 8px 0 rgba(0, 0, 0, 0.9);
                    padding: 20px;
                    border-radius: 10px;
                    width: 100%;
                  }
                  .MainChart .Chart h1 {
                    text-align: center;
                    font-weight:bold;
                    color: #333;
                    margin-bottom: 10px;
                    font-size: 20px;
                  }
                 
            
                  .card-header-ne {
                      position: relative;
                      display: flex;
                      align-items: center;
                      justify-content: space-between;
                      
                  }
            
                  .card-header-ne .title {
                      vertical-align: middle;
                  }
                   
                  .date-wrapper {
                      display: flex;
                      align-items: center;
                      padding: 8px 16px;
                      font-size: 12px;
                      color: #6c757d;
                      background:#efeff5;
                      }
                      
                      .date-wrapper ion-icon {
                      margin-right: 8px;
                      }
                    .bg-white {
                    background-color: white;
                    }
            
                    .border {
                    border: 1px solid #ccc;
                    }
            
                </style>


                <script type="module" src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.esm.js"></script>
                <script nomodule src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.js"></script>
        </head>
        <body>

        <?php
        $page="dashboard";
		include 'sidebar.php'
		?>
<div class="main-content">
        <main>
            
            <div class="page-header">
                <h1>Dashboard</h1>
                <small>Home / Dashboard</small>
            </div>
            <div class="content-main">
            <div class="MainCard">

                <div class="Card">
                    <div class="content">
                        <div class="num"><?php include 'dashboarddetail/totalvehiclesparked.php'?></div>
                        <div class="name">Total Vehicle Parked</div>
                    </div>
                    <div class="icon">
                        <ion-icon name="car-sport-sharp"></ion-icon>
                    </div>
                </div>
        
                <div class="Card">
                    <div class="content">
                        <div class="num"><?php include 'dashboarddetail/totalvehiclein.php'?></div>
                        <div class="name">Vehicles In</div>
                    </div>
                    <div class="icon">
                        <ion-icon name="download-sharp"></ion-icon>
                    </div>
                </div>
        
                <div class="Card">
                    <div class="content">
                        <div class="num"><?php include 'dashboarddetail/totalvehicleout.php'?></div>
                        <div class="name">Vehicles Out</div>
                    </div>
                    <div class="icon">
                        <ion-icon name="log-out-sharp"></ion-icon>
                    </div>
                </div>
        
        
                <div class="Card">
                    <div class="content">
                        <div class="num"><?php include 'dashboarddetail/last24hrsparkedvehicle.php'?></div>
                        <div class="name">Parking done in 24 hrs</div>
                    </div>
                    <div class="icon">
                        <ion-icon name="time-sharp"></ion-icon>
                    </div>
                </div>
        
        
        
        
            </div><br/><br/>
        
        
        
            <div class="MainChart">
        
                <div class="Chart">
                    <h1>Vehicle Category</h1>
                    <div>
                        <canvas  id="myChart" height="160" ></canvas>
                    </div>
                </div>
         
        
            </div>
        </div>
        </main>
                </div>

                
                <script src='https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.2.2/Chart.min.js'></script>        
        <script>
            var categoryLabels = <?php echo json_encode($categoryLabels); ?>;
            var categoryData = <?php echo json_encode($categoryData); ?>;


            var ctx = document.getElementById('myChart').getContext('2d');


            var myChart = new Chart(ctx, {
                type: 'bar',
                data: {
                    labels: categoryLabels, 
                    datasets: [{
                        label: 'Category Count',
                        data: categoryData, 
                        backgroundColor: 'rgba(54, 162, 235, 0.2)',
                        borderColor: 'rgba(54, 162, 235, 1)',
                        borderWidth: 1
                    }]
                },
                options: {
                    scales: {
                        yAxes: [{
                            ticks: {
                                beginAtZero: true
                            }
                        }]
                    }
                }
            });
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
    