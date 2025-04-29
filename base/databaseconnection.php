<?php
    $con=mysqli_connect("localhost", "root", "", "pms-db");
    if(mysqli_connect_errno()){
    echo "Connection Fail".mysqli_connect_error();
    }
  ?>