<?php


session_start();
error_reporting(0);


if(isset($_GET['deleteid'])){
$id=$_GET['deleteid'];

include('base/databaseconnection.php');


$qry="DELETE from admin where id=$id";
$result=mysqli_query($con,$qry);

if($result){
    $_SESSION['success_msg'] = "Admin has been deleted."; 
    header('location:manageadmin.php'); 
    exit(); 

}else{
    $_SESSION['error_msg'] = "Something Went Wrong. Please try again"; 
    header('location:manageadmin.php'); 
    exit(); 
}
}
?>

