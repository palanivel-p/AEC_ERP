<?php
// Include PHPExcel library
require_once 'PHPExcel/Classes/PHPExcel.php';

// Create new PHPExcel object
$objPHPExcel = new PHPExcel();

// Set properties
$objPHPExcel->getProperties()->setCreator("Your Name")
    ->setLastModifiedBy("Your Name")
    ->setTitle("HTML Table to Excel")
    ->setSubject("Converting HTML Table to Excel")
    ->setDescription("This file demonstrates converting HTML table to Excel using PHPExcel.")
    ->setKeywords("html table excel phpexcel")
    ->setCategory("Test file");

// Create a new worksheet
$objPHPExcel->setActiveSheetIndex(0);
$worksheet = $objPHPExcel->getActiveSheet();

// Your HTML table
$htmlTable = '
<table>
  <tr>
    <th>Name</th>
    <th>Email</th>
  </tr>
  <tr>
    <td>John Doe</td>
    <td>john@example.com</td>
  </tr>
  <tr>
    <td>Jane Smith</td>
    <td>jane@example.com</td>
  </tr>
</table>
';

// Load HTML table into PHPExcel
$worksheet->fromHtml($htmlTable);

// Save Excel file
$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
$objWriter->save('html_table_to_excel.xlsx');

echo "Excel file generated successfully!";
?>
