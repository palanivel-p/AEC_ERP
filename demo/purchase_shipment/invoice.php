<?php
include ('dompdf/autoload.inc.php');
Include("../includes/connection.php");
date_default_timezone_set("Asia/Kolkata");
$current_date = date('Y-m-d');
$invoice_date = date("d-m-Y", strtotime($current_date));
use Dompdf\Dompdf;
use Dompdf\Options;

$options = new Options();
$options->set('isRemoteEnabled', true);

$obj = new Dompdf($options);

$sale_id = $_GET['sale_id'];

$sqlSale = "SELECT * FROM `sale` WHERE `sale_id`='$sale_id'";
$resSale= mysqli_query($conn, $sqlSale);
$rowSale = mysqli_fetch_assoc($resSale);
$grand_total =  $rowSale['grand_total'];
$s_date =  $rowSale['sale_date'];
$sale_date = date("d-m-Y", strtotime($s_date));
$payment_terms =  $rowSale['payment_terms'];
$d_date =  $rowSale['d_date'];
$due_date = date("d-m-Y", strtotime($d_date));
$d_note =  $rowSale['d_note'];
$e_way =  $rowSale['e_way'];
$bo_no =  $rowSale['bo_no'];
$customer_id =  $rowSale['customer'];
$invoice_no =  $rowPurchase['invoice_no'];

$sqlShipping = "SELECT * FROM `shipping` WHERE `sale_id`='$sale_id'";
$resShipping= mysqli_query($conn, $sqlShipping);
$rowShipping = mysqli_fetch_assoc($resShipping);
$shipping_id =  $rowShipping['sale_id'];
$dispatch_doc =  $rowShipping['dispatch_doc'];
$del_date =  $rowShipping['delivery_date'];
$delivery_date = date("d-m-Y", strtotime($del_date));
$dispatched_through =  $rowShipping['dispatched_through'];
$destination =  $rowShipping['destination'];
$bl_no =  $rowShipping['bl_no'];
$vehicle_no =  $rowShipping['vehicle_no'];
$terms_delivery =  $rowShipping['terms_delivery'];
$shipping_amount =  $rowShipping['shipping_amount'];

$sqlCustomer = "SELECT * FROM `customer` WHERE `customer_id`='$customer_id'";
$resCustomer= mysqli_query($conn, $sqlCustomer);
$rowCustomer = mysqli_fetch_assoc($resCustomer);
$customer_name =  $rowCustomer['customer_name'];
$palceof_supply =  $rowCustomer['supply_place'];
$billto =  $rowCustomer['address1'];
$shipto =  $rowCustomer['address2'];
$gstin =  $rowCustomer['gstin'];

$sqlCompany = "SELECT * FROM `company_profile`";
$resCompany= mysqli_query($conn, $sqlCompany);
$rowCompany = mysqli_fetch_assoc($resCompany);
$bank_name =  $rowCompany['bank_name'];
$account_name =  $rowCompany['account_name'];
$account_no =  $rowCompany['account_no'];
$ifsc_code =  $rowCompany['ifsc_code'];
$branch_name =  $rowCompany['branch_name'];


$numberIntoWords = getIndianCurrency($grand_total);
function getIndianCurrency($number)
{
    $decimal = round($number - ($no = floor($number)), 2) * 100;
    $hundred = null;
    $digits_length = strlen($no);
    $i = 0;
    $str = array();
    $words = array(0 => '', 1 => 'One', 2 => 'Two',
        3 => 'Three', 4 => 'Four', 5 => 'Five', 6 => 'Six',
        7 => 'Seven', 8 => 'Eight', 9 => 'Nine',
        10 => 'Ten', 11 => 'Eleven', 12 => 'Twelve',
        13 => 'Thirteen', 14 => 'Fourteen', 15 => 'Fifteen',
        16 => 'Sixteen', 17 => 'Seventeen', 18 => 'Eighteen',
        19 => 'Nineteen', 20 => 'Twenty', 30 => 'Thirty',
        40 => 'Forty', 50 => 'Fifty', 60 => 'Sixty',
        70 => 'Seventy', 80 => 'Eighty', 90 => 'Ninety');
    $digits = array('', 'Hundred','Thousand','Lakh', 'Crore');
    while( $i < $digits_length ) {
        $divider = ($i == 2) ? 10 : 100;
        $number = floor($no % $divider);
        $no = floor($no / $divider);
        $i += $divider == 10 ? 1 : 2;
        if ($number) {
            $plural = (($counter = count($str)) && $number > 9) ? 's' : null;
            $hundred = ($counter == 1 && $str[0]) ? ' and ' : null;
            $str [] = ($number < 21) ? $words[$number].' '. $digits[$counter]. $plural.' '.$hundred:$words[floor($number / 10) * 10].' '.$words[$number % 10]. ' '.$digits[$counter].$plural.' '.$hundred;
        } else $str[] = null;
    }
    $Rupees = implode('', array_reverse($str));
    $paise = ($decimal > 0) ? "." . ($words[$decimal / 10] . " " . $words[$decimal % 10]) . ' Paise' : '';
    return ($Rupees ? $Rupees . 'Rupees ' : '') . $paise;
}



$data= '<html>
<head>
    <title>PDF</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.1/css/bootstrap-grid.min.css"/>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Great+Vibes&display=swap" rel="stylesheet">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.1/js/bootstrap.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Kanit&family=Yesteryear&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Alegreya+Sans+SC:wght@700&display=swap" rel="stylesheet">
    <style>
    body{
    font-size: 12px;
    }
        .table-container {
            overflow-x: auto;
            margin-bottom: 2px;
            font-family: Arial;
        }
        table {
            width: 100%;
            border-collapse: collapse;
        }
        td, th{
         border:1px solid black;
        }
        .bn {
          
           padding: 8px;
           text-align: left;
            border: none;
        }
        .heading-bg{
            background-color: #8a8a8a;
        }
        th{
            text-align: center;
            font-weight: bold;
            padding: 15px;
        }
        td{
        text-align: center;
        padding: 10px;
        
        }
        .dn{
            border:1px solid black;
            font-weight: bold;
            font-size: 15px;
        }
 
        @media screen and (max-width: 600px) {
            th, td {
                display: block;
                width: 100%; 
            }
        }
    </style>
</head>

<body style="font-size: 3px"  style="border: 1px solid black">
<div id="printPdf">
   <div class="table-container">
    <table style="text-align: center">
        <tbody>
        <tr style="margin-top: 2px">
            <td class="bn" style="text-align: left;font-size: 15px">GSTIN NO:  GSTIN87654325 </td>
            <td class="bn" style="text-align: center;"><strong class="dn">DELIVERY NOTE</strong> </td>
            <td class="bn" style="text-align: right;font-size: 15px">Mobile:  9876543212 </td>
        </tr>
        <tr>
            <td class="bn" style="text-align: right;padding-bottom: 0;"><img src="https://erp.aecindia.net/includes/AEC.png" height="80px"> </td>
            <td class="bn" style="text-align: left; font-size: 25px; padding-bottom: 0;" colspan="2">ASSOCIATED ENGINEERING COMPANY</td>

        </tr>
        <tr>
            <td class="bn" colspan="3" style="text-align: center;font-size: 16px;">
                <p style="margin: 0;">1/78, Neva India Road, Pelamedu Post, Coimbatore- 612502</p>
                <p style="margin: 0;">testing1235@gmail.com , Testing455@gmail.com</p>
            </td>
        </tr>
        <tr>
            <td class="bn" style="padding-bottom: 0;text-align: left;font-size: 15px;"><span style="padding-left: 10px">DC NO : fgf545467</span> </td>
            <td class="bn" style="padding-bottom: 0;"></td>
            <td class="bn" style="padding-bottom: 0;text-align: left;font-size: 15px;padding-left: 70px">Date: 21-12-2024</td>
        </tr>
         <tr>
            <td class="bn" colspan="3" style="padding-bottom: 0;text-align: left; word-wrap: break-word;font-size: 15px;">
                <p style="padding-left: 10px;">To: <span style="border-bottom: 1px dashed black;padding-bottom: 0">Test india private limited company, test nagar ,4th road,seidapet, chennai - 8254673 </span></p>
             </td>  
         </tr>    
         <tr>
            <td class="bn" colspan="3" style="padding-bottom: 0;font-size: 15px">
                <p style="padding-left: 10px;">Dear Sir,<br><span style="padding-left:70px;">Please receive the undermentioned goods agaist your order</span></p>
            </td> 
        </tr>
         </tbody>
</table>
    <table>
            <tr style="font-size: 15px">
                <td class="bn" style="text-align: left"><span style="padding-left: 10px">No : </span><span style="border-bottom: 1px dashed black">12345</span></td>
                <td class="bn" style="text-align: left"><span style="padding-left: 10px">Date : </span><span style="border-bottom: 1px dashed black">21-09-2022</span></td>
                <td class="bn" tyle="text-align: right"><span style="padding-left: 10px">Inv No: </span><span style="border-bottom: 1px dashed black">12345</span></td>
                <td class="bn" style="text-align: left"><span style="padding-left: 10px">Date: </span><span style="border-bottom: 1px dashed black">22-06-2023</span></td>
            </tr>
    </table>
    <table>
        <thead>
            <tr>
                <th style="width: 10%">S.No</th>
                <th style="width: 50%">Description</th>
                <th style="width: 20%">Quantity</th>
                <th style="width: 20%">Rate Rs</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td>1</td>
                <td>product name</td>
                <td>5</td>
                <td>500</td>
            </tr> 
              <tr>
                <td></td>
                <td>Total</td>
                <td>5</td>
                <td>500</td>
            </tr>
            <tr>
            <td></td>
            <td style="text-align: left">Party GST No: GSTNO766335466</td>
            <td></td>
            <td></td>
</tr>
        </tbody>
    </table>
    <div style="border: 1px solid black"
        <table>
        <tr>
            <td class="bn" rowspan="3">Received the above goods</td>
            <td class="bn" style="text-align: right;padding-right: 30px">For AEC</td>
        </tr>
        <tr>
            <td class="bn" style="height: 40px;text-align: right;padding-right: 30px">E-Signature</td>
        </tr>
        <tr>
            <td class="bn" style="text-align: right;padding-right: 30px">signature</td>
        </tr>
    </table>
    </div>
     
      
   </div>
   
</div>

</body>
</html>';

$obj->loadHTML($data);
$obj->render();
$output = $obj->output();

// Send appropriate headers to force download
header('Content-Type: application/pdf');
header('Content-Disposition: attachment; filename="DC-Invoice.pdf"'); // Change the filename as needed
header('Content-Length: ' . strlen($output));

// Output the PDF content
echo $output;
?>
