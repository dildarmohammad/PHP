<?php

require_once('fpdf/fpdf.php');
require_once('fpdi/src/autoload.php');

// Create instance of FPDI
$pdf = new \setasign\Fpdi\Fpdi();

// Set source PDF file (make sure the file exists at the given path)
$pageCount = $pdf->setSourceFile('file:///C:/xampp/htdocs/depository/rematerializationform.pdf');

// Import the first page
$pageId = $pdf->importPage(1, \setasign\Fpdi\PdfReader\PageBoundaries::MEDIA_BOX);

// Add a new page
$pdf->addPage();

//random number

session_start();

// Initialize the starting number if it is not set in the session
if (!isset($_SESSION['random_number'])) {
    $_SESSION['random_number'] = 5446000;    
}

// Get the current random number
$random_number = $_SESSION['random_number'];

// Increment the number for the next request
$_SESSION['random_number']++;

// Set font for the random number
$pdf->SetFont('Arial', 'B', 12); // You can adjust the font and size here

// Add the random number to the PDF
// Coordinates (x, y) are where the text will appear on the page, you can adjust these values
$pdf->Text(154, 18, "RRF/ " . $random_number);

//random number end

// Use the imported page, and adjust the coordinates and scaling if needed
$pdf->useImportedPage($pageId, 10, 10, 190); // Adjust size if necessary

// Output the generated PDF to the browser
$pdf->Output('I', 'generated.pdf');
?>
