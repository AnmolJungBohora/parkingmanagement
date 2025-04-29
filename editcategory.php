
<?php
    session_start();
    error_reporting(0);

    include('base/databaseconnection.php');
    if (strlen($_SESSION['vpmsaid']==0)) {
    header('location:logout.php');
    } else{

    if(isset($_POST['editcategory']))
    {
        $aid=$_SESSION['vpmsaid'];
        $category=$_POST['category'];
        $desc=$_POST['sdescription'];
        $eid=$_GET['editid'];
    
        $query=mysqli_query($con, "UPDATE vehiclecategory set category='$category', description='$desc' where ID='$eid'");
        if ($query) {
          $_SESSION['success_msg'] = "Category has been updated."; 
          header('location:vehiclecategory.php'); 
          exit(); 
        } else {
            $_SESSION['error_msg'] = "Something Went Wrong. Please try again"; 
            header('location:vehiclecategory.php'); 
            exit(); 
        }

    }
  ?>


<!DOCTYPE html>
<html lang="en">
<head>
 
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>PMS</title>
  <script src="//cdn.jsdelivr.net/npm/alertifyjs@1.13.1/build/alertify.min.js"></script>
  <style>
 @import url('https://fonts.googleapis.com/css?family=Josefin+Sans:300,400,700&display=swap');

.wrapper{
  max-width: 450px;
  width: 100%;
  margin: 30px auto 0;
  padding: 10px;

}

.wrapper .form_container{
  background: #fff;
  padding: 30px;
  box-shadow: 1px 1px 15px rgba(0, 0, 0, 0.15);
  border-radius: 3px;
}
.heading{
  background: grey;
  margin: -30px;
  text-align: center;
  color: white;
  font-size: 19px;
  margin-bottom: 35px;
  padding: 10px;
  
  
}
.wrapper .form_container .form_item{
  margin-bottom: 25px;
}




.wrapper .form_container .form_item label{
  display: block;
  margin-bottom: 5px;
}

.form_item input[type="text"],
.form_item select{
  width: 100%;
  padding: 10px;
  font-size: 16px;
  border: 1px solid #dadce0;
  border-radius: 3px;
}

.form_item input[type="text"]:focus{
  border-color: #6271f0;
}

.btn input[type="submit"]{
  background: #337ab7;
  border: 1px solid #1598d4;
  padding: 10px;
  width: 100%;
  font-size: 16px;
  letter-spacing: 1px;
  border-radius: 3px;
  cursor: pointer;
  color: #fff;
}
textarea {
    width: 100%;
    height: 150px;
    padding: 10px;
    border: 1px solid #ccc;
    border-radius: 5px;
    background-color: #f7f7f7;
    font-size: 16px;
    resize: vertical; 
}
.error-message {
            color: red;
            font-size: 1em;
            margin-top:10px;
        }

  </style>

    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="https://maxst.icons8.com/vue-static/landings/line-awesome/line-awesome/1.3.0/css/line-awesome.min.css">
    <script type="module" src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.esm.js"></script>
                <script nomodule src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.js"></script>
</head>
<body>

<?php
    $page="addcategory";
    include 'sidebar.php'
    ?>
    
    <div class="main-content">
        
        

        
        <main>
            
            <div class="page-header">
                <h1>Add Category</h1>
                <small>Home / Add Category</small>
            </div>
            <div class="content-main">
              <div class="wrapper">

             
		
                <div class="form_container">
                  <form name="form" method="POST" onsubmit="return validateForm()">
                    <div class="heading">
                    <h2>Add Category</h2>
                  </div>
                  

                    <?php
                      $cid=$_GET['editid'];
                      $ret=mysqli_query($con,"SELECT * from  vehiclecategory where ID='$cid'");
                      $cnt=1;
                      while ($row=mysqli_fetch_array($ret)) {

                    ?>  


                  <div class="form_wrap">
                    <div class="form_item">
                      <label>Category Name</label>
                      <input type="text" id="category" name="category" value="<?php  echo $row['category'];?>">
                      <div class="error-message" id="category-error"></div>
                    </div>
                  </div>
                  <div class="form_wrap">
                    <div class="form_item">
                      <label>Description</label>
                      <textarea id="sdescription" name="sdescription"><?php echo $row['description']; ?></textarea>
                      <div class="error-message" id="sdescription-error"></div>
                    </div>
                  </div>
                  
                  <?php }?>

                  <div class="btn">
                    <input type="submit" value="Save Changes" name="editcategory">
                  </div>
                  </form>
                </div>
                </div>
        </div>
        </main>
        
    </div>

    <script>
        function validateForm() {
            var fields = ['category', 'sdescription'];
            var labels = ['Vehicle Category', 'Description'];
            var isValid = true;
            fields.forEach(function(field,index) {
                var value = document.getElementById(field).value.trim();
                if (value === '') {
                    isValid = false;
                    var errorElement = document.getElementById(field + '-error');
                    errorElement.innerText = labels[index] + ' cannot be empty.';
                } else {
                    var errorElement = document.getElementById(field + '-error');
                    errorElement.innerText = '';
                }
            });
            return isValid;
        }
    </script>

</body>
</html>

<?php }  ?>