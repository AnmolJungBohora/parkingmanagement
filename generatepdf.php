<?php
require('pdf/fpdf.php');
require('base/databaseconnection.php'); // Include your database connection file

if(isset($_GET['fromdate']) && isset($_GET['todate'])) {
    $fromDate = $_GET['fromdate'];
    $toDate = $_GET['todate'];

    // Create a new PDF instance
    $pdf = new FPDF();
    $pdf->AddPage();

    $pdf->Image('img/logo.png',10,10,30);

    // Set font
    $pdf->SetFont('Arial','B',18);

    // Add title
    $pdf->Cell(0,10,'Parking Report',0,1,'C');

    // Add date range
    $pdf->SetFont('Arial','B',14);
    $pdf->SetTextColor(0, 0, 255);
    $pdf->Cell(0,10,'Displaying reports from ' . $fromDate . ' to ' . $toDate,0,1,'C');
    $pdf->Ln(10); // Add a line break
    $pdf->SetTextColor(0, 0, 0);

    // Fetch data from database
    $result = mysqli_query($con, "SELECT * FROM parkingdetails WHERE DATE(parkedtime) BETWEEN '$fromDate' AND '$toDate'");
    
    // Add table headers
    $pdf->SetFillColor(200, 200, 200); // Set background color
    $pdf->SetFont('Arial','B',12);
    $pdf->Cell(11,10,'S.N.',1,0,'C',true);
    $pdf->Cell(36,10,'Parking Number',1,0,'C',true);
    $pdf->Cell(25,10,'Brand',1,0,'C',true);
    $pdf->Cell(30,10,'Category',1,0,'C',true);
    $pdf->Cell(35,10,'Vehicle Number',1,0,'C',true);
    $pdf->Cell(38,10,"Vehicle's Owner",1,0,'C',true);
    $pdf->Cell(20,10,"Price",1,1,'C',true);


    $logoWidth = 30; // Width of the logo image
    $pageWidth = $pdf->GetPageWidth();
    $xCoordinate = ($pageWidth - $logoWidth) / 2; // Calculate x-coordinate for centering
    $pdf->Image('img/stamp.png', $xCoordinate, $pdf->GetY() - 35 , $logoWidth);

    // Add table data
    $pdf->SetFont('Arial','',12);
    $count = 1;
    $fill = false; // Initialize fill variable for alternating row colors
    while ($row = mysqli_fetch_assoc($result)) {

         // Set fill color based on odd/even row
         if ($fill) {
            // Odd row, fill with pink color
            $pdf->SetFillColor(255, 192, 203); // Pink color
        } else {
            // Even row, fill with blue color
            $pdf->SetFillColor(173, 216, 230); // Blue color
        }

        // Add data to the table with adjusted left position
        $pdf->Cell(11,10,$count,1,0,'C',true);
        $pdf->Cell(36,10,'PA-'.$row['parkingnumber'],1,0,'C',true);
        $pdf->Cell(25,10,$row['vehiclebrand'],1,0,'C',true);
        $pdf->Cell(30,10,$row['vehiclecategory'],1,0,'C',true);
        $pdf->Cell(35,10,$row['registrationnumber'],1,0,'C',true);
        $pdf->Cell(38,10,$row['ownername'],1,0,'C',true);
        $pdf->Cell(20,10,'Rs. '.$row['parkingcharge'],1,1,'C',true);
        $count++;

        $fill = !$fill;
    }

    // Output PDF
    $pdf->Output('D', 'ParkingReport.pdf'); // 'D' prompts download, 'F' saves to a file, 'I' opens in browser
} else {
    // Redirect if fromdate or todate is not set
    header('Location: index.php');
    exit;
}
?>
