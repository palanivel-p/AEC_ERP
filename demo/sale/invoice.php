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
$notes =  $rowSale['notes'];
$grand_total =  $rowSale['grand_total'];
$s_date =  $rowSale['sale_date'];
$sale_date = date("d-m-Y", strtotime($s_date));
$payment_terms =  $rowSale['payment_terms'];
if($payment_terms == '0'){
    $p_terms = 'immediate';
}
else if($payment_terms == ''){
    $p_terms = 'immediate';
}
else{
    $p_terms = $payment_terms;
}
$d_date =  $rowSale['due_date'];
$due_date = date("d-m-Y", strtotime($d_date));
if($due_date == '30-11--0001'){
    $dd_date = 'NA';
}
else{
    $dd_date = $due_date;
}
$d_note =  $rowSale['d_note'];
$e_way =  $rowSale['e_way'];
$bo_no =  $rowSale['bo_no'];
$customer_id =  $rowSale['customer'];
$invoice_no =  $rowSale['invoice_no'];

$sqlShipping = "SELECT * FROM `sale_shipment` WHERE `sale_id`='$sale_id'";
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
if($shipping_amount == ''){
    $shipAmountSS =0;
}
else{
    $shipAmountSS = $shipping_amount;
}
$ship_grand = $grand_total + $shipAmountSS;

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

$sqlamount="SELECT SUM(pay_made) AS pay_made  FROM sale_payment WHERE sale_id='$sale_id'";
$resamount=mysqli_query($conn,$sqlamount);
if(mysqli_num_rows($resamount)>0){
    $arrayamount=mysqli_fetch_array($resamount);
    $totalAmountS=$arrayamount['pay_made'];
}
if($totalAmountS == ''){
    $totalAmountSS =0;
}
else{
    $totalAmountSS = $totalAmountS;
}
$balance_amount= $ship_grand - $totalAmountSS;

$numberIntoWords = getIndianCurrency($ship_grand);
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
        th, td {
            border: 1px solid #ccc;
            padding: 8px;
            text-align: left;
        }
        .heading-bg{
            background-color: #8a8a8a;
        }
        th{
            text-align: center;
            font-weight: bold;
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
        <table style="background-color: #b5b5b5;text-align: center">
            <tbody>
            <tr>
                <td style="text-align: center"><img src="https://erp.aecindia.net/purchase/AEC.png" height="80px"></td>
                <td style="width:50%"> <strong>Associated Engineering Company</strong>
                <p>S.F. No.116/3 (b2) .Annur road,Arasur Village, <br>
                Sulur Taluk ,Coimbatore- 641407<br>
                Tel : 0422 - 2567113,<br>
                 Mobile : 99949 40506, 99949 60506 <br>
                GST No: 33AAEFA5749C2ZS</p>
                </td>
                <td style="width:20%;text-align: center"><strong>Sales Invoice</strong></td>
            </tr>
             </tbody>
        </table>
        <table>
        <tbody>
             <tr>
            <th style="width:25%;text-align: left">Invoice Number</th>
            <td style="width:25%">'. $invoice_no.'</td>
            <th style="width:25%;text-align: left">Invoice Date</th>
            <td style="width:25%">'. $invoice_date.'</td>
            </tr>
            <tr>
            <th style="width:25%;text-align: left">PO Number</th>
            <td style="width:25%">'. $sale_id.'</td>
            <th style="width:25%;text-align: left">PO Date</th>
            <td style="width:25%">'. $sale_date.'</td>
            </tr>
            <tr>
            <th style="text-align: left">Payment Terms</th>     
            <td>'. $p_terms . ' days</td>
            <th style="text-align: left">Due Date</th>
            <td>'. $dd_date.'</td>
            </tr>
            <tr>
            <th style="text-align: left">Dispatch Doc No </th>
            <td>'. $dispatch_doc.'</td>
            <th style="text-align: left">E-Way No</th>
            <td>'. $e_way. '</td>
            </tr>
            <tr>
             <th style="text-align: left">Destination  </th>
            <td>'. $destination.'</td>
            <th style="text-align: left">Place of Supply</th>
            <td>'. $palceof_supply. '</td>
            </tr>
       
            <tr>
            <th style="text-align: left">Terms of Delivery </th>
            <td>'. $terms_delivery. '</td>
            <th style="text-align: left">Dispatched through </th>
            <td>'. $dispatched_through. '</td>
            </tr>
            <tr>
             
            <th style="text-align: left">Motor Vehicle No </th>
            <td>'. $vehicle_no.'</td>   
            <th style="text-align: left"> </th>
            <td></td>  
            </tr>            
            </tbody>
        </table>
        <h4 style="margin-left: 20px">Dear Sir,<br>
        <span style="margin-left: 40px"> Kindly supply the following material as per the terms and conditions mentioned below.</span></h4>
        <table>
        <tbody>
            <tr style="background-color: silver">
            <th style="width:50%;text-align: center">Bill To</th>
            <th style="width:50%;text-align: center">Ship To</th>
            
            </tr>
            <tr>
            <td><h5 style="margin: 2px 0px">'.$customer_name.'</h5>'.$billto.'<br>GSTIN:'.$gstin.'</td>
            <td><h5 style="margin: 2px 0px">'.$customer_name.'</h5>'.$shipto.'<br>GSTIN:'.$gstin.'</td>
            
            </tr>
            </tbody>
        </table>
        
        <table>
        <tbody>
              <tr style="background-color: #ffab7d">
          <th rowspan="2" style="width: 3%">S.No</th>
            <th rowspan="2" style="width: 15%">Product Name</th>
            <th rowspan="2" style="width: 9%">HSN Code</th>           
            <th rowspan="2" style="width: 7%">QTY</th>
            <th rowspan="2" style="width: 13%">Rate</th>
            <th colspan="2" style="width: 15%">Discount</th>           
            <th colspan="2" style="width: 20%">Tax</th> <!-- Removed style attribute -->
            <th rowspan="2" style="width: 18%">Total</th>
            </tr>
            
            <tr style="background-color: #ffab7d">
            <th>%</th> <!-- Adjusted width -->
            <th>Value</th> <!-- Adjusted width -->
            <th>%</th> <!-- Adjusted width -->
            <th>Value</th> <!-- Adjusted width -->
            </tr>';

$sql = "SELECT * FROM sale_details WHERE sale_id = '$sale_id'";
$result = mysqli_query($conn, $sql);
if (mysqli_num_rows($result)>0) {
    $sNo = 0;
    $totalDiscountValue = 0; // Initialize discount value accumulator
    $totalTaxValue = 0;
    $totalAmount = 0;
    while($row = mysqli_fetch_assoc($result)) {
        $sNo++;
        $product_id = $row['product_id'];
        $productDesc = $row['productDesc'];
        $pro_name = $row['product_name'];

        $sqlProductV = "SELECT * FROM `product_varient` WHERE `product_id`='$product_id'";
        $resProductV= mysqli_query($conn, $sqlProductV);
        $rowProductV = mysqli_fetch_assoc($resProductV);

        $product_varient =  $rowProductV['varient_name'];
        if($product_varient != ''){
            $p_name = $rowProductV['varient_name'];
        }
        else{
            $p_name = $row['product_name'];
        }

//        $pv = explode("/", $pro_name);
//        $p_name= $pv[0]; // piece1
//        $pv_name= $pv[1];
//        if($pv_name != ''){
//            $product_varient = $pv_name;
//        }
//        else{
//            $product_varient = $pro_name;
//        }
        $unit_cost = $row['unit_cost'];
        $qty = $row['qty'];
        $discount = $row['discount'];
        $discount_value = $row['discount_value'];
        $tax = $row['tax'];
        $a = explode('%',$tax);
        $cgst = $a[0];
        $sgst = $a[1];
        $tax_value = $row['tax_value'];
        $sub_total = $row['sub_total'];
        $total = $qty * $unit_cost;

        $totalDiscountValue += $discount_value;
        $totalTaxValue += $tax_value;
        $totalAmount += $total;

        $sqlProduct = "SELECT * FROM `product` WHERE `product_id`='$product_id'";
        $resProduct= mysqli_query($conn, $sqlProduct);
        $rowProduct = mysqli_fetch_assoc($resProduct);
        $product_name =  $rowProduct['product_name'];
        $hsn_code =  $rowProduct['hsn_code'];
        $product_unit =  $rowProduct['product_unit'];
        $currency_type = '₹';
        $data .= '
            <tr>
            <td style="text-align: center">'. $sNo.'</td>
            <td>'. $pro_name.'<br>'.$productDesc.'</td>
            <td style="text-align: center;width: 30px">'. $hsn_code.'</td>
           
            <td style="width: 40px">'. $qty.'- '.$product_unit.'</td>
            <td style="text-align: center"><span style="font-family: DejaVu Sans; sans-serif;">&#8377;</span>'. number_format($unit_cost,2).'</td>
            <td style="text-align: center">'. $discount.'%</td>
            <td style="text-align: center"><span style="font-family: DejaVu Sans; sans-serif;">&#8377;</span>'. number_format($discount_value,2).'</td>
            <td style="width: 10px">'. $tax.'</td>
            <td style="text-align: center"><span style="font-family: DejaVu Sans; sans-serif;">&#8377;</span>'. number_format($tax_value,2).'</td>
            <td style="width: 40px"><span style="font-family: DejaVu Sans; sans-serif;">&#8377;</span>'. number_format($total, 2).'</td>
            </tr>
          
            ';
    }
}
$data .= '
               </tbody>
        </table>
            ';
$data .= '
         <table>
            <tbody>  
           
            <tr>
            <th colspan="8">Grand Total In Words</th>
            <td colspan="1">Sub Total</td>
            <td colspan="2" style="text-align: right"><span style="font-family: DejaVu Sans; sans-serif;">&#8377;</span>'.number_format($totalAmount,2).'</td>
            </tr>
             ';
           if (substr($tax, 0, 3) === 'IGS'){
            $data .='
            <tr>
            <th colspan="8" rowspan="2">'.$numberIntoWords.'</th>
            <td colspan="1">Discount value (-)</td>
            <td colspan="2" style="text-align: right"><span style="font-family: DejaVu Sans; sans-serif;">&#8377;</span>'.number_format($totalDiscountValue,2).'</td>
            </tr>
 
            
             <tr>    
            <td colspan="1">Tax ('.$tax.') (+)</td>
            <td colspan="2" style="text-align: right"><span style="font-family: DejaVu Sans; sans-serif;">&#8377;</span>'.number_format($totalTaxValue,2).'</td>
            </tr>
            ';
} else {
    $data .= '
    <tr>
            <th colspan="8" rowspan="3">'.$numberIntoWords.'</th>
            <td colspan="1">Discount value (-)</td>
            <td colspan="2" style="text-align: right"><span style="font-family: DejaVu Sans; sans-serif;">&#8377;</span>'.number_format($totalDiscountValue,2).'</td>
            </tr>
             <tr>        
                <td colspan="1">Tax ('.$cgst.'%) (+)</td>
                <td colspan="2" style="text-align: right"><span style="font-family: DejaVu Sans; sans-serif;">&#8377;</span>'.number_format(($totalTaxValue/2),2).'</td>       
              </tr>           
              <tr>        
                <td colspan="1">Tax ('.$sgst.'%) (+)</td>
                <td colspan="2" style="text-align: right"><span style="font-family: DejaVu Sans; sans-serif;">&#8377;</span>'.number_format(($totalTaxValue/2),2).'</td>       
              </tr> 

';
}


$data .= '
            <tr>
            <td colspan="8" rowspan="4" style="text-align: left; vertical-align: top;line-height: 1.6">
            <span style="font-weight: bold">Bank Details</span><br>
            Bank Name:<span style="margin-left: 10px">'.$bank_name.'</span><br>
            Account Name :<span style="margin-left: 5px">'.$account_name.'</span><br>
            Account No:<span style="margin-left: 10px">'.$account_no.'</span><br>
            IFSC Code :<span style="margin-left: 10px">'.$ifsc_code.'</span><br>
            Branch Name:<span style="margin-left: 5px">'.$branch_name.'</span>
            </td>
            <td colspan="1">Shipping Amount</td>
            <td colspan="2" style="text-align: right"><span style="font-family: DejaVu Sans; sans-serif;">&#8377;</span>'. $shipAmountSS.'</td>
            </tr>
             <tr>
            <td colspan="1">Grand Total</td>
            <td colspan="2" style="text-align: right"><span style="font-family: DejaVu Sans; sans-serif;">&#8377;</span>'. number_format($ship_grand,2).'</td>
            </tr>
            <tr>
    
            <td colspan="1">Payment Made</td>
            <td colspan="2" style="text-align: right"><span style="font-family: DejaVu Sans; sans-serif;">&#8377;</span>'.number_format($totalAmountSS,2).'</td>
            </tr>
            
             <tr>
            <td colspan="1" style="font-weight: bold">Balance Due</td>
            <td colspan="2" style="text-align: right;font-weight: bold"><span style="font-family: DejaVu Sans; sans-serif;">&#8377;</span>'.number_format($balance_amount,2).'</td>
            </tr>
            
            
            </tbody>
        </table>
        <table>
            <tbody>   
              <tr>
                <td><p style="margin-top:60px;text-align: center">Authorised by</p></td>
                </tr>
            </tbody>
        </table>
        <h4 style="padding-left: 10px">Thanks for your business.</h4>
        <h3 style="padding-left: 10px">Notes:' .$notes.'</h3>
        <h3 style="padding-left: 10px">Bank Details</h3>
     
        <div style="padding: 10px">
        <h3>TERMS AND CONDITIONS</h3>
        <p>1. All disputes on Associated Engineering Company are subject to Coimbatore Jurisdiction only. </p>
        <p>2. All materials are exactly as per the specifications and will be subject to our 100% inspection and approval at any time within 45days after delivery.</p>
        <p>When any rejections are assessed at the time of primary inspection the total quantity is liable to rejected. </p>
        <p>3. Associated Engineering Company reserves the right to cancel or amend this or this order of any part thereof without assigning any reason before delivery of material. </p>
        <p>4. All the materials in this order should be supplied within the specified schedule date of delivery. </p>
        <p>5. If this order is not executed within the specified period or time or the materials supplied is not of the contract quality or not according to the specifications required by the Associated Engineering Company, the Associated Engineering Company will be entitled to reject the materials and treat the order as cancelled and buy its requirement in the Open market on suppliers account. The rejected materials should be removed immediately from the Associated Engineering Company by this supplier on his risk and responsibility. </p>
        <p>6. ln the event of the production at any of our works interfered with breakdown or other circumstances beyond the control  Associated Engineering Company of, the Associated Engineering Company reserves the right to defer the delivery period of the order or to cancel as it #considers necessary without incurring liability. </p>
        <p>7. Inspection are at our site unless otherwise specified. </p>
        <p>8. Supplies should accompany report Test Certificate / Test bar. </p>
        <p>9. If the goods are rejected by us as non-conformance, the goods are returned to the supplier the proportionate post of freight. Loading & unloading and any other charges incidental there to should be borne by the supplier. </p>
        <p>10. Where a part of the supplies are rejected as non-conformance the Associated Engineering Company has the right to pass the bills of the supplier after deducting the value of rejected supplies. Proportionate freight and other charges etc., </p>
        <p>11. If the goods are not delivered as per the order the Associated Engineering Company will have the option not to accept the goods. If goods transportation is on supplier scope any loss, shortage, damage ,insurance is all includes on supplier scope. </p>
        <p>12. If supplies are made against documents retired through banks are rejected in whole or in part by the Associated Engineering Company. The supplier should effect payment of the value thereof. </p>
        <p>13. The supplier shall dispatch all supplies through the authorized carriers of the Associated Engineering Company </p>
        <p>14. If instructions are given to the carriers for door delivery and the carriers do not effect door delivery proportionate freight and other incidental charges that may be paid by the Associated Engineering Company shall be to the suppliers account. </p>
        <p>15. If the supplier shall not follow the sales tax regulations consequently it the Associated Engineering Company has to pay any penalty or other expenses for loading, unloading and 
Check-posts, the supplier should make such loss sustained by the Associated Engineering Company. </p>   
        <p>16. If documents sent through bank are not received in time and the Associated Engineering Company is called upon to pay interest, dermurrage and any other expenses incidental there to, such expenses are to the suppliers account. </p>  
        <p>17. The Associated Engineering Company has the right to insure the goods himself If the Associated Engineering Company does not insure he may ask the supplier to effect the insurance. </p>   
        <p>18. The Associated Engineering Company shall be entitled to a general lien on the goods in his possession under this contract for any monies for the time being the due to the  Associated Engineering Company from the supplier. </p>
        <p>19. The above terms-must not be altered or varied without prior permission in writing. </p>
        <p>20. Associated Engineering Company to recommend to follow the legal & other applicable requirements, Code of conduct (COC), Employee safety PPE adherence & Prevention of environmental pollution by suppliers. </p>
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
//header('Content-Disposition: attachment; filename=.'$sale_id'.".pdf"'); // Change the filename as needed
header('Content-Disposition: attachment; filename="' . $sale_id . '.pdf"');

header('Content-Length: ' . strlen($output));

// Output the PDF content
echo $output;
?>
