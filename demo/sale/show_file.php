<?php Include("../includes/connection.php");

error_reporting(0);
$page= $_GET['page_no'];
$s_name= $_GET['s_name'];
$s_code= $_GET['s_code'];
$mobile= $_GET['mobile'];
$email= $_GET['email'];
$sale_id= $_GET['sale_id'];
if($page=='') {
    $page=1;
}

$pageSql= $page-1;
$start=$pageSql*10;
$end = $start;

if($pageSql == 0) {
    $end = 10;
}

if($s_name != ""){
//    $sNameSql= " AND customer_name = '".$s_name."'";
    $sNameSql = " AND customer_name LIKE '%" . $s_name . "%'";

}
else{
    $sNameSql ="";
}

if($s_code != ""){
//    $sCodeSql= " AND customer_code = '".$s_code."'";
    $sCodeSql = " AND customer_code LIKE '%" . $s_code . "%'";

}
else{
    $sCodeSql ="";
}

if($mobile != ""){
//    $mobileSql= " AND customer_phone = '".$mobile."'";
    $mobileSql = " AND customer_phone LIKE '%" . $mobile . "%'";
}
else{
    $mobileSql ="";
}

if($email != ""){
//    $emailSql= "AND customer_email = '".$email."'";
    $emailSql = " AND customer_email LIKE '%" . $email . "%'";
}
else {
    $emailSql = "";
}
$added_by = $_COOKIE['user_id'];
if($_COOKIE['role'] == 'Super Admin'){
    $addedBy = "";
}
else{
    $addedBy = " AND added_by='$added_by'";
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width,initial-scale=1">
    <title>Sale</title>
    <link rel="icon" type="image/png" sizes="16x16" href="https://bhims.ca/piloting/img/favicon_New.png">
    <link href="../vendor/jqvmap/css/jqvmap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="../vendor/chartist/css/chartist.min.css">
    <link href="../vendor/jqvmap/css/jqvmap.min.css" rel="stylesheet">
    <link href="../vendor/bootstrap-select/dist/css/bootstrap-select.min.css" rel="stylesheet">
    <link href="../css/style.css" rel="stylesheet">
    <link href="../vendor/owl-carousel/owl.carousel.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css" integrity="sha512-z3gLpd7yknf1YoNbCzqRKc4qyor8gaKU1qmn+CShxbuBusANI9QpRohGBreCFkKxLhei6S9CQXFEbbKuqLg0DA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link href="../vendor/bootstrap-daterangepicker/daterangepicker.css" rel="stylesheet">
    <link href="../vendor/clockpicker/css/bootstrap-clockpicker.min.css" rel="stylesheet">
    <link href="../vendor/bootstrap-material-datetimepicker/css/bootstrap-material-datetimepicker.css" rel="stylesheet">
    <link rel="stylesheet" href="../vendor/pickadate/themes/default.css">
    <link rel="stylesheet" href="../vendor/pickadate/themes/default.date.css">
    <link href="../vendor/summernote/summernote.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datetimepicker/4.7.14/css/bootstrap-datetimepicker.min.css">

</head>
<style>
    .error {
        color:red;
    }

    .table-bordered th {
        border: 1px solid #000 !important;
    }
    .table-bordered td {
        border: 1px solid #000 !important;
    }
    table.dom th{
        width: 35%;
    }
    table.dom td{
        word-wrap: break-word;
    }
</style>
<body>

<div id="preloader">
    <div class="sk-three-bounce">
        <div class="sk-child sk-bounce1"></div>
        <div class="sk-child sk-bounce2"></div>
        <div class="sk-child sk-bounce3"></div>
    </div>
</div>

<div id="main-wrapper">

    <?php
    $header_name ="Sale";
    Include ('../includes/header.php') ?>

    <div class="content-body">

        <div class="col-lg-12">
            <div class="card">
                <div class="card-body">
                    <div class="card-header">
                        <h4 class="card-title">View / Sale</h4>
                        <div style="display: flex;justify-content: flex-end;">
                            <a href="<?php echo $website?>/sale/all_sale.php"><button class="btn btn-danger" type="button">Close</button></a>

                        </div>
                    </div>
                    <div class="container">
                        <div class="row">
                            <div class="col-12">
                                <?php

                                  $sql = "SELECT * FROM sale WHERE sale_id='$sale_id'";

                                $result = mysqli_query($conn, $sql);
                                $sNo = $start;
                                $rowsale = mysqli_fetch_assoc($result);

                                $sNo++;
                                $s_date =  $rowsale['sale_date'];
                                $sale_date = date('d-m-Y', strtotime($s_date));
                                $d_date =  $rowsale['due_date'];
                                $due_date = date('d-m-Y', strtotime($d_date));
                                if($due_date == '30-11--0001'){
                                    $dd_date = 'NA';
                                }
                                else{
                                    $dd_date = $due_date;
                                }

                                $customer_id =  $rowsale['customer'];
                                $sqlcustomer = "SELECT * FROM `customer` WHERE `customer_id`='$customer_id'";
                                $rescustomer = mysqli_query($conn, $sqlcustomer);
                                $rowcustomer = mysqli_fetch_assoc($rescustomer);
                                $customer =  $rowcustomer['customer_name'];

                                $e_way =  $rowsale['e_way'];
                                $payment_terms =  $rowsale['payment_terms'];
                                if($payment_terms == '0'){
                                    $p_term = 'immediate day';
                                }
                                elseif($payment_terms == ''){
                                    $p_term= 'NA';
                                }
                                else{
                                    $p_term = $payment_terms . ' days';
                                }
                                $discountss =  $rowsale['discount'];
                                $discounts=  str_replace("%","",$discountss);
                                $payment_status =  $rowsale['status'];
                                $status =  $rowsale['payment_status'];
                                $grand_total =  $rowsale['grand_total'];
                                $po_no =  $rowsale['po_no'];
                                $p_date =  $rowsale['po_date'];
                                $po_date = date('d-m-Y', strtotime($p_date));
                                $notes=$rowsale['notes'];
                                $total_tax=$rowsale['total_tax'];
                                $tds=$rowsale['tds'];
                                if($e_way == ''){
                                    $e_bill = 'NA';
                                }
                                else{
                                    $e_bill = $e_way;
                                }
                                $transport =  $rowsale['transport'];
                                $notes=$rowsale['notes'];
                                if($notes == ''){
                                    $nts = 'NA';
                                }
                                else{
                                    $nts = $notes;
                                }
                                if($discounts == ''){
                                    $dct = 'NA';
                                }
                                else{
                                    $dct = $discounts;
                                }
                                if($tds == ''){
                                    $ttddss = 'NA';
                                }
                                else{
                                    $ttddss = $tds;
                                }


                                if($rowsale['payment_status'] == 1){
                                    $statColor = 'success';
                                    $statCont = 'Received';
                                }
                                else if($rowsale['payment_status'] == 2){
                                    $statColor = 'danger';
                                    $statCont = 'Shipped';
                                }
                                else if($rowsale['payment_status'] == 3){
                                    $statColor = 'danger';
                                    $statCont = 'Order';
                                }

                                $sqlamount="SELECT SUM(pay_made) AS pay_made  FROM sale_payment WHERE sale_id='$sale_id'";
                                $resamount=mysqli_query($conn,$sqlamount);
                                if(mysqli_num_rows($resamount)>0){
                                    $arrayamount=mysqli_fetch_array($resamount);
                                    $totalAmount=$arrayamount['pay_made'];
                                }
                                $grand_total= $rowsale['grand_total'];
                                $balance_amount= $grand_total - $totalAmount;
                                if($totalAmount == ''){
                                    $totalAmount = 'NA';
                                }
                                else{
                                    $totalAmount = $totalAmount;
                                }
                                $total_pay =  $rowsale['total_pay'];
                                if($total_pay == ''){
                                    $payment_status = 'UnPaid';
                                }
                                elseif($total_pay == $grand_total){
                                    $payment_status = 'Paid';
                                }
                                elseif ($total_pay < $grand_total){
                                    $payment_status = 'Partially Pending';
                                }

                                $date = $rowsale['adjustment_date'];
                                $adjusment_date = date('d-m-Y', strtotime($date));
                                ?>
                                <table class="table table-bordered dom" style="text-align: center;">
                                    <tbody>
                                    <tr>
                                        <th><strong>sale ID</strong></th>
                                        <td><strong><?php echo $sale_id;?></strong></td>
                                    </tr>
                                    <tr>
                                        <th class="table_head"><strong>sale Date</strong></th>
                                        <td class="table_data"><?php echo $sale_date?></td>
                                    </tr>
                                    <tr>
                                        <th class="table_head"><strong>Po No</strong></th>
                                        <td class="table_data"><?php echo $po_no?></td>
                                    </tr>
                                    <tr>
                                        <th class="table_head"><strong>Po Date</strong></th>
                                        <td class="table_data"><?php echo $po_date?></td>
                                    </tr>
                                    <tr>
                                        <th class="table_head"><strong>Customer</strong></th>
                                        <td class="table_data"><?php echo $customer?></td>
                                    </tr>

                                    <tr>
                                        <th class="table_head"><strong>Payment terms</strong></th>
                                        <td class="table_data"><?php echo $p_term?></td>
                                    </tr>
                                    <tr>
                                        <th class="table_head"><strong>Due Date</strong></th>
                                        <td class="table_data"><?php echo $dd_date?></td>
                                    </tr>
                                    <tr>
                                        <th class="table_head"><strong>Discount</strong></th>
                                        <td class="table_data"><?php echo $dct?></td>
                                    </tr>
                                    <tr>
                                        <th class="table_head"><strong>TDS</strong></th>
                                        <td class="table_data"><?php echo $ttddss?></td>
                                    </tr>
                                    <tr>
                                        <th class="table_head"><strong>Total Tax</strong></th>
                                        <td class="table_data"><?php echo $total_tax?></td>
                                    </tr>
                                    <tr>
                                        <th class="table_head"><strong>Grand Total</strong></th>
                                        <td class="table_data"><?php echo $grand_total?></td>
                                    </tr>
                                    <tr>
                                        <th class="table_head"><strong>Status</strong></th>
                                        <td class="table_data"><?php echo $statCont?></td>
                                    </tr>
                                    <tr>
                                        <th class="table_head"><strong>Payment Status</strong></th>
                                        <td class="table_data"><?php echo $payment_status?></td>
                                    </tr>
                                    <tr>
                                        <th class="table_head"><strong>E-way Bill</strong></th>
                                        <td class="table_data"><?php echo $e_bill?></td>
                                    </tr>
                                    <tr>
                                        <th class="table_head"><strong>Notes</strong></th>
                                        <td class="table_data"><?php echo $nts?></td>
                                    </tr>




                                    </tbody>
                                </table>

                            </div>
                            <!--                        <div class="col-4">-->
                            <!--                            <img src="--><?php //echo $website?><!--/includes/AEC.png" alt="none">-->
                            <!--                        </div>-->
                        </div>
                    </div>
                    <br>
                    <div class="container">
                        <div class="row">
                            <div class="col-12">
                                <table class="table table-bordered" style="text-align: center;">
                                    <thead>
                                    <tr>
                                        <th><strong>sale ID</strong></th>
                                        <th class="table_head"><strong>Product code</strong></th>
                                        <th class="table_head"><strong>Product Name</strong></th>
                                        <th class="table_head"><strong>Cost</strong></th>
                                        <th class="table_head"><strong>Stock</strong></th>
                                        <th class="table_head"><strong>Unit</strong></th>
                                        <th class="table_head"><strong>Qty</strong></th>
                                        <th class="table_head"><strong>Discount</strong></th>
                                        <th class="table_head"><strong>Discount Value</strong></th>
                                        <th class="table_head"><strong>Tax(%)</strong></th>
                                        <th class="table_head"><strong>Tax Value</strong></th>
                                        <th class="table_head"><strong>Subtotal</strong></th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <?php
                                    $sql = "SELECT * FROM sale_details WHERE sale_id ='$sale_id'";
                                    $result = mysqli_query($conn, $sql);
                                    if (mysqli_num_rows($result) > 0) {
                                        $sNo = $start;
                                        while ($row = mysqli_fetch_assoc($result)) {
                                            $sNo++;
                                            $sale_id=$row['sale_id'];
                                            $product_id=$row['product_id'];
                                            $product_code=$row['product_code'];
                                            $product_name=$row['product_name'];
                                            $stock=$row['Stock_count'];
                                            $qty=$row['qty'];
                                            $unit =  $row['unit'];
                                            $unit_cost =  $row['unit_cost'];
                                            $discount1 =  $row['discount'];
                                            $dis_symbl =  $row['dis_symbl'];
//                                                    $discount_s=  str_replace("%","",$discount1);
                                            $discount_value =  $row['discount_value'];
                                            $discount_Type =  $row['discount_type'];
                                            $tax =  $row['tax'];

                                            $stk = explode('-', $tax);
                                            $tax1 = trim($stk[1], " %");
                                            $tax2 = trim($stk[2], " %");
                                            $results = (float)$tax1 + (float)$tax2;

                                            $tax_value =  $row['tax_value'];
                                            $sub_total =  $row['sub_total'];

                                            $sqlProduct = "SELECT * FROM product WHERE product_id ='$product_id'";
                                            $resProduct = mysqli_query($conn, $sqlProduct);
                                            $rowProduct = mysqli_fetch_assoc($resProduct);
                                            $stock_qty =  $rowProduct['stock_qty'];
                                            $product_unit =  $rowProduct['product_unit'];
                                            $product_cost =  $rowProduct['product_cost'];
                                            ?>
                                            <tr>
                                                <td><strong><?php echo $sale_id; ?></strong></td>
                                                <td class="table_data"><?php echo $row['product_code']; ?></td>
                                                <td class="table_data"><?php echo $row['product_name']; ?></td>
                                                <td class="table_data"><?php echo round($product_cost); ?></td>
                                                <td class="table_data"><?php echo $stock_qty . "-" . $product_unit; ?></td>
                                                <td class="table_data"><?php echo $unit; ?></td>
                                                <td class="table_data"><?php echo $row['qty']; ?></td>
                                                <td class="table_data"><?php echo $discount1.$dis_symbl; ?></td>
                                                <td class="table_data"><?php echo round($discount_value); ?></td>
                                                <td class="table_data"><?php echo $tax; ?></td>
                                                <td class="table_data"><?php echo round($tax_value); ?></td>
                                                <td class="table_data"><?php echo round($sub_total); ?></td>

                                            </tr>
                                            <?php
                                        }
                                    }
                                    ?>
                                    </tbody>
                                </table>


                            </div>
                            <!--                        <div class="col-4">-->
                            <!--                            <img src="--><?php //echo $website?><!--/includes/AEC.png" alt="none">-->
                            <!--                        </div>-->
                        </div>
                    </div>
                </div>
            </div>
        </div>




    </div>

    <?php Include ('../includes/footer.php') ?>


</div>


<script src="../vendor/global/global.min.js"></script>
<script src="../vendor/bootstrap-select/dist/js/bootstrap-select.min.js"></script>
<script src="../vendor/chart.js/Chart.bundle.min.js"></script>
<script src="../js/custom.min.js"></script>
<script src="../js/dlabnav-init.js"></script>
<script src="../vendor/owl-carousel/owl.carousel.js"></script>
<script src="../vendor/peity/jquery.peity.min.js"></script>
<!--<script src="../vendor/apexchart/apexchart.js"></script>-->
<script src="../js/dashboard/dashboard-1.js"></script>
<script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="../vendor/jquery-validation/jquery.validate.min.js"></script>
<script src="../js/plugins-init/jquery.validate-init.js"></script>
<script src="../vendor/moment/moment.min.js"></script>
<script src="../vendor/bootstrap-daterangepicker/daterangepicker.js"></script>
<script src="../vendor/summernote/js/summernote.min.js"></script>
<script src="../js/plugins-init/summernote-init.js"></script>
<script>
    var elems = document.querySelectorAll('.active_link');
    [].forEach.call(elems, function(el){
        el.classList.remove("active_link");
    });


    var liElement = document.getElementById("active15");
    var aElement = document.getElementById("link15");

    // Add classes to the elements
    liElement.classList.add("mm-active", "active_link");
    aElement.classList.add("mm-active", "active_link");
</script>
<script>
    function dropdownfun(){
        const inputDateValue = document.getElementById("country").value;
        if (inputDateValue != 'India') {
            var inputElement = $('<input>').attr({
                type: 'text', // Change type to text (or any other type you desire)
                id: 'supply_place', // Set id attribute to match the original select element
                name: 'supply_place', // Set name attribute if needed
                style:"border-color: #181f5a;color: black",
                class:"form-control"
            });


            $('#supply_place').replaceWith(inputElement);
        }else{
            var selectElement = $('<select>').attr({
                id: 'supply_place', // Set id attribute to match the original select element
                name: 'supply_place',
                style: "border-color: #181f5a;color: black",
                class: "form-control"
            });

            selectElement.append($('<option>').val('Andhra Pradesh').text('Andhra Pradesh'));
            selectElement.append($('<option>').val('Andaman and Nicobar Islands').text('Andaman and Nicobar Islands'));
            selectElement.append($('<option>').val('Arunachal Pradesh').text('Arunachal Pradesh'));
            selectElement.append($('<option>').val('Assam').text('Assam'));
            selectElement.append($('<option>').val('Bihar').text('Bihar'));
            selectElement.append($('<option>').val('Chandigarh').text('Chandigarh'));
            selectElement.append($('<option>').val('Chhattisgarh').text('Chhattisgarh'));
            selectElement.append($('<option>').val('Dadar and Nagar Haveli').text('Dadar and Nagar Haveli'));
            selectElement.append($('<option>').val('Daman and Diu').text('Daman and Diu'));
            selectElement.append($('<option>').val('Delhi').text('Delhi'));
            selectElement.append($('<option>').val('Lakshadweep').text('Lakshadweep'));
            selectElement.append($('<option>').val('Puducherry').text('Puducherry'));
            selectElement.append($('<option>').val('Goa').text('Goa'));
            selectElement.append($('<option>').val('Gujarat').text('Gujarat'));
            selectElement.append($('<option>').val('Haryana').text('Haryana'));
            selectElement.append($('<option>').val('Himachal Pradesh').text('Himachal Pradesh'));
            selectElement.append($('<option>').val('Jammu and Kashmir').text('Jammu and Kashmir'));
            selectElement.append($('<option>').val('Jharkhand').text('Jharkhand'));
            selectElement.append($('<option>').val('Karnataka').text('Karnataka'));
            selectElement.append($('<option>').val('Kerala').text('Kerala'));
            selectElement.append($('<option>').val('Madhya Pradesh').text('Madhya Pradesh'));
            selectElement.append($('<option>').val('Maharashtra').text('Maharashtra'));
            selectElement.append($('<option>').val('Manipur').text('Manipur'));
            selectElement.append($('<option>').val('Meghalaya').text('Meghalaya'));
            selectElement.append($('<option>').val('Mizoram').text('Mizoram'));
            selectElement.append($('<option>').val('Nagaland').text('Nagaland'));
            selectElement.append($('<option>').val('Odisha').text('Odisha'));
            selectElement.append($('<option>').val('Punjab').text('Punjab'));
            selectElement.append($('<option>').val('Rajasthan').text('Rajasthan'));
            selectElement.append($('<option>').val('Sikkim').text('Sikkim'));
            selectElement.append($('<option>').val('Tamil Nadu').text('Tamil Nadu'));
            selectElement.append($('<option>').val('Telangana').text('Telangana'));
            selectElement.append($('<option>').val('Tripura').text('Tripura'));
            selectElement.append($('<option>').val('Uttar Pradesh').text('Uttar Pradesh'));
            selectElement.append($('<option>').val('Uttarakhand').text('Uttarakhand'));
            selectElement.append($('<option>').val('West Bengal').text('West Bengal'));

            $('#supply_place').replaceWith(selectElement);
        }
    };
    // document.addEventListener('DOMContentLoaded', function () {
    //     const country = document.getElementById('country');
    //     const sup_name = document.getElementById('sup_name');
    //     const sup_email = document.getElementById('sup_email');
    //     const sup_phone = document.getElementById('sup_phone');
    //     const sup_phone1 = document.getElementById('sup_phone1');
    //     const sup_gstin = document.getElementById('sup_gstin');
    //     const sup_country = document.getElementById('sup_country');
    //     const sup_place = document.getElementById('sup_place');
    //     const sup_other = document.getElementById('sup_other');
    //     const sup_address1 = document.getElementById('sup_address1');
    //     const sup_bank_name = document.getElementById('sup_bank_name');
    //     const sup_acc_name = document.getElementById('sup_acc_name');
    //     const sup_acc_no = document.getElementById('sup_acc_no');
    //     const sup_ifsc = document.getElementById('sup_ifsc');
    //     const sup_branch_name = document.getElementById('sup_branch_name');
    //
    //     // Add an event listener to the dropdown
    //     country.addEventListener('change', function () {
    //         a(country.value);
    //     });
    //
    //     function a(values) {
    //         if (values === 'India') {
    //             // Hide the input field when 'Hide Input Field' is selected
    //             country.style.display = 'block';
    //             sup_name.style.display = 'block';
    //             sup_email.style.display = 'block';
    //             sup_phone.style.display = 'block';
    //             sup_phone1.style.display = 'block';
    //             sup_gstin.style.display = 'block';
    //             sup_country.style.display = 'block';
    //             sup_place.style.display = 'block';
    //             sup_other.style.display = 'none';
    //             sup_address1.style.display = 'block';
    //             sup_bank_name.style.display = 'block';
    //             sup_acc_name.style.display = 'block';
    //             sup_acc_no.style.display = 'block';
    //             sup_ifsc.style.display = 'block';
    //             sup_branch_name.style.display = 'block';
    //             // other_ress.style.display = 'block';
    //
    //         }
    //         else {
    //             // Show the input field for other selections
    //             country.style.display = 'block';
    //             sup_name.style.display = 'block';
    //             sup_email.style.display = 'block';
    //             sup_phone.style.display = 'block';
    //             sup_phone1.style.display = 'block';
    //             sup_gstin.style.display = 'block';
    //             sup_country.style.display = 'block';
    //             sup_place.style.display = 'none';
    //             sup_other.style.display = 'block';
    //             sup_address1.style.display = 'block';
    //             sup_bank_name.style.display = 'block';
    //             sup_acc_name.style.display = 'block';
    //             sup_acc_no.style.display = 'block';
    //             sup_ifsc.style.display = 'block';
    //             sup_branch_name.style.display = 'block';
    //         }
    //     }
    // });

    function handleCheckboxClick() {
        var checkbox = document.getElementById("access_status");
        if (checkbox.checked) {
            var address1 = $('#address1').val();
            $('#address2').val(address1);
        }else{
            $('#address2').val();
        }
    }

    function addTitle() {
        $("#title").html("Add customer");
        $('#career_form')[0].reset();
        $('#api').val("add_api.php")
        // $('#game_id').prop('readonly', false);
    }

    function editTitle(data) {

        $("#title").html("Edit customer- "+data);
        $('#career_form')[0].reset();
        $('#api').val("edit_api.php");

        $.ajax({
            type: "POST",
            url: "view_api.php",
            data: 'customer_id='+data,
            dataType: "json",
            success: function(res){
                if(res.status=='success')
                {
                    $("#customer_name").val(res.customer_name);
                    $("#customer_email").val(res.customer_email);
                    $("#customer_phone").val(res.customer_phone);
                    $("#customer_phone1").val(res.customer_phone1);
                    $("#gstin").val(res.gstin);
                    $('#address1').val(res.address1);
                    $('#address2').val(res.address2);
                    $("#bank_name").val(res.bank_name);
                    $("#acc_name").val(res.acc_name);
                    $("#acc_no").val(res.acc_no);
                    $("#ifsc").val(res.ifsc);
                    $("#address").val(res.address);
                    $("#branch_name").val(res.branch_name);
                    $("#supply_place").val(res.supply_place);
                    $("#country").val(res.country);
                    $("#other_state").val(res.other_state);

                    // $(".summernote").code("your text");
                    $("#old_pa_id").val(res.customer_id);
                    $("#customer_id").val(res.customer_id);

                    $("#access_status").val(res.access_status);
                    // $('#game_id').prop('readonly', true);

                    if(Number(res.access_status) == 1){
                        document.getElementById("access_status").checked = true;
                    }
                    else {
                        document.getElementById("access_status").checked = false;
                    }

                    var edit_model_title = "Edit customer - "+data;
                    $('#title').html(edit_model_title);
                    $('#add_btn').html("Save");
                    $('#career_list').modal('show');
                }
                else if(res.status=='wrong')
                {
                    swal("Invalid",  res.msg, "warning")
                        .then((value) => {
                            window.window.location.reload();
                        });
                }
                else if(res.status=='failure')
                {
                    swal("Failure",  res.msg, "error")
                        .then((value) => {
                            window.window.location.reload();

                        });
                }
            },
            error: function(){
                swal("Check your network connection");

                window.window.location.reload();
            }
        });

    }


    //to validate form
    $("#career_form").validate(
        {
            ignore: '.ignore',
            // Specify validation rules
            rules: {

                customer_name: {
                    required: true
                },
                customer_email: {
                    required: true,
                    email: true
                },
                customer_phone: {
                    required: true,
                    maxlength: 10,
                    minlength: 10
                },
                bank_name: {
                    required: true
                },
                country: {
                    required: true
                },
                branch_name: {
                    required: true
                },
                ifsc: {
                    required: true
                },
                acc_no: {
                    required: true
                },
                acc_name: {
                    required: true
                },
                address1: {
                    required: true
                },

            },
            // Specify validation error messages
            messages: {
                customer_name: "*This field is required",
                customer_email: "*This field is required",
                customer_phone: {
                    required:"*This field is required",
                    maxlength:"*Mobile Number Should Be 10 Character",
                    minlength:"*Mobile Number Should Be 10 Character"
                },
                bank_name: "*This field is required",
                country: "*This field is required",
                branch_name: "*This field is required",
                ifsc: "*This field is required",
                acc_no: "*This field is required",
                acc_name: "*This field is required",
                address1: "*This field is required",
            }
            // Make sure the form is submitted to the destination defined
        });

    //add data

    $('#add_btn').click(function () {

        $("#career_form").valid();

        if($("#career_form").valid()==true) {

            var api = $('#api').val();
            var form = $("#career_form");
            var access_status = $('#access_status').is(":checked");

            console.log(access_status);

            if(access_status == true)
            {
                access_status =1;
            }
            else{
                access_status =0;
            }
            var formData = new FormData(form[0]);
            formData.append("active_status",access_status);
            this.disabled = true;
            this.innerHTML = '<i class="fa fa-spinner fa-spin"></i>';
            $.ajax({

                type: "POST",
                url: api,
                // data: $('#career_form').serialize(),
                data: formData,
                dataType: "json",
                dataType: "json",
                contentType: false,
                cache: false,
                processData: false,
                success: function (res) {
                    if (res.status == 'success') {
                        Swal.fire(
                            {
                                title: "Success",
                                text: res.msg,
                                icon: "success",
                                button: "OK",
                                allowOutsideClick: false,
                                allowEscapeKey: false,
                                closeOnClickOutside: false,
                            }
                        )
                            .then((value) => {
                                window.window.location.reload();
                            });
                    } else if (res.status == 'failure') {

                        Swal.fire(
                            {
                                title: "Failure",
                                text: res.msg,
                                icon: "warning",
                                button: "OK",
                                allowOutsideClick: false,
                                allowEscapeKey: false,
                                closeOnClickOutside: false,
                            }
                        )
                            .then((value) => {

                                document.getElementById("add_btn").disabled = false;
                                document.getElementById("add_btn").innerHTML = 'Add';
                            });

                    }
                },
                error: function () {

                    Swal.fire('Check Your Network!');
                    document.getElementById("add_btn").disabled = false;
                    document.getElementById("add_btn").innerHTML = 'Add';
                }

            });



        } else {
            document.getElementById("add_btn").disabled = false;
            document.getElementById("add_btn").innerHTML = 'Add';

        }


    });


    //
    //delete model

    function delete_model(data) {

        Swal.fire({
            title: "Delete",
            text: "Are you sure want to delete the record?",
            icon: "warning",
            buttons: true,
            dangerMode: true,
            allowOutsideClick: false,
            allowEscapeKey: false,
            closeOnClickOutside: false,
            showCancelButton: true,
            cancelButtonText: 'Cancel'
        })
            .then((value) => {
                if(value.isConfirmed) {

                    $.ajax({

                        type: "POST",
                        url: "delete_api.php",
                        data: 'customer_id='+data,
                        dataType: "json",
                        success: function(res){
                            if(res.status=='success')
                            {
                                Swal.fire(
                                    {
                                        title: "Success",
                                        text: res.msg,
                                        icon: "success",
                                        button: "OK",
                                        allowOutsideClick: false,
                                        allowEscapeKey: false,
                                        closeOnClickOutside: false,
                                    }
                                )
                                    .then((value) => {
                                        window.window.location.reload();

                                    });
                            }
                            else if(res.status=='failure')
                            {
                                swal(
                                    {
                                        title: "Failure",
                                        text: res.msg,
                                        icon: "warning",
                                        button: "OK",
                                        allowOutsideClick: false,
                                        allowEscapeKey: false,
                                        closeOnClickOutside: false,
                                    }
                                )
                                    .then((value) => {
                                        window.window.location.reload();                             });

                            }
                        },
                        error: function(){
                            swal("Check your network connection");

                        }

                    });

                }

            });

    }

    $( document ).ready(function() {
        $('#search').val('<?php echo $search;?>');

    });

    $(document).on("click", ".excel_download", function () {
        window.location.href = "excel_download.php?&s_name=<?php echo $s_name?>&s_code=<?php echo $s_code?>&mobile=<?php echo $mobile?>&email=<?php echo $email?>";
    });
    $(document).on("click", ".pdf_download", function () {
        window.location.href = "pdf_download.php?&s_name=<?php echo $s_name?>&mobile=<?php echo $mobile?>&email=<?php echo $email?>";
    });
</script>


</body>
</html>
