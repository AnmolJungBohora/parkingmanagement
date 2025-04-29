<?php

    include './base/databaseconnection.php';

    $query=mysqli_query($con,"SELECT ID from parkingdetails where date(parkedtime)=CURDATE();");
    $count_parkings=mysqli_num_rows($query);

    echo $count_parkings
 ?>