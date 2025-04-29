<?php

    include './base/databaseconnection.php';

    $query3=mysqli_query($con,"SELECT ID from parkingdetails");
    $count_parkings=mysqli_num_rows($query3);

    echo $count_parkings
 ?>