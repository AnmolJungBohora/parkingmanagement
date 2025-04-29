<?php


session_start();
error_reporting(0);


if(isset($_GET['editid'])){
$id=$_GET['editid'];

include('base/databaseconnection.php');


$qry="DELETE from vehiclecategory where id=$id";
$result=mysqli_query($con,$qry);

if($result){
    $_SESSION['success_msg'] = "Category has been deleted."; 
    header('location:vehiclecategory.php'); 
    exit(); 

}else{
    $_SESSION['error_msg'] = "Something Went Wrong. Please try again"; 
    header('location:vehiclecategory.php'); 
    exit(); 
}
}
?>

