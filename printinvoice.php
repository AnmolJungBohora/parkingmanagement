<?php
session_start();
error_reporting(0);
include('base/databaseconnection.php');
?>

<link rel="stylesheet" href="printinvoice.css">

<?php
    $cid=$_GET['viewid'];
    $ret=mysqli_query($con,"SELECT * from parkingdetails where ID='$cid'");
    $cnt=1;
    while ($row=mysqli_fetch_array($ret)) {

    ?> 
<section>
  <div class="invoice">
    <div class="top_line"></div>
    <div class="header">
      <div class="i_row">
        <div class="i_logo">
          <p>PMS</p>
        </div>
        <img src="img/stamp.png" alt="Stamp Image" style="height: 100px; width: auto;">
        <div class="i_title">
          <h2>INVOICE</h2>
          <p class="p_title text_right">
          <?php 
            $datetime = $row['vehicletaken'];
            $date_only = date("Y-m-d", strtotime($datetime));
            echo $date_only;
        ?>
          </p>
        </div>
      </div>
      <div class="i_row">
        <div class="i_number">
        <?php
            $invoice_query = mysqli_query($con, "SELECT invoicenumber FROM invoice WHERE pid='$cid'");
            if ($invoice_query) {
                $invoice_row = mysqli_fetch_assoc($invoice_query);
                $invoice_number = $invoice_row['invoicenumber'];
                echo "<p class='p_title'>INVOICE NO: $invoice_number</p>";
            }
        ?>
        </div>
        <div class="i_address text_right">
          <p>TO</p>
          <p class="p_title">
          <?php echo $row['ownername']; ?> <br />
            <span><?php echo $row['ownernumber']; ?></span><br />
            <span></span>
          </p>
        </div>
      </div>
    </div>
    <div class="body">


                  <table class="table">
                      <tr class="tr">
                          <th class="th">Registration Number</th>
                          <td class="td"><?php echo $row['registrationnumber']; ?></td>
                          <th class="th">Brand Name</th>
                          <td class="td"><?php echo $row['vehiclebrand']; ?></td>
                      </tr>
                      <tr class="tr">
                          <th class="th">Category</th>
                          <td class="td"><?php echo $row['vehiclecategory']; ?></td>
                          <th class="th">Vehicle Owner Name</th>
                          <td class="td"><?php echo $row['ownername']; ?></td>
                      </tr>
                      <tr class="tr">
                          <th class="th">Vehicle Owner Contact Number</th>
                          <td class="td"><?php echo $row['ownernumber']; ?></td>
                          <th class="th">Parking Number</th>
                          <td class="td">PA-<?php echo $row['parkingnumber']; ?></td>
                      </tr>
                      <tr class="tr">
                          <th class="th">Vehicle Parked Time</th>
                          <td class="td"><?php echo $row['parkedtime']; ?></td>
                          <th class="th">Current Status</th>
                          <td class="td"><?php echo ($row['status'] == "") ? "Vehicle Parked" : (($row['status'] == "Out") ? "Vehicle Out" : ""); ?></td>
                      </tr>
                      <tr class="tr">
                          <th class="th">Vehicle Out Time</th>
                          <td class="td"><?php echo $row['vehicletaken']; ?></td>
                          <th class="th">Operated By</th>
                          <td class="td">
                          <?php
                              $user_query = mysqli_query($con, "SELECT a.firstname, a.lastname FROM parkingdetails p JOIN admin a ON a.ID = p.adminid where p.ID='$cid'");
                              if ($user_query) {
                                if (mysqli_num_rows($user_query) > 0) {
                                  $user_row = mysqli_fetch_assoc($user_query);
                                  $first_name = $user_row['firstname'];
                                  $last_name = $user_row['lastname'];
                                  echo "$first_name $last_name";
                              }
                            } 
                          ?>
                          </td>
                      </tr>
                      <tr class="tr">
                          <th class="th" style="background:#007bff;color:White;">Total Charge</th>
                          <td colspan="3" class="td" style="background:#007bff;color:White;">Rs. <?php echo $row['parkingcharge']; ?></td>
                      </tr>
                  </table>

                  <?php } ?>
    </div>
    <div class="bottom_line"></div>
  </div>
</section>