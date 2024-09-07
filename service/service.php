
<?php Include("../includes/connection.php");
date_default_timezone_set("Asia/kolkata");

error_reporting(0);
$page= $_GET['page_no'];
$service_type= $_GET['service_type'];
$service_id = $_GET['service_id'];
$t_date = $_GET['t_date'];

if($f_date == ''){
    $f_date = date('Y-m-01');
}
if($t_date == ''){
    $t_date = date('Y-m-d');
}
$from_date = date('Y-m-d 00:00:00',strtotime($f_date));
$to_date = date('Y-m-d 23:59:59',strtotime($t_date));
if($pur_id != ""){
    $pur_idSql= " AND purchase_id = '".$pur_id."'";

}
else{
    $pur_idSql ="";
}

if($page=='') {
    $page=1;
}

$pageSql= $page-1;
$start=$pageSql*10;
$end = $start;

if($pageSql == 0) {
    $end = 10;
}
$cookieStaffId = $_COOKIE['staff_id'];
$cookieBranch_Id = $_COOKIE['branch_id'];
if($_COOKIE['role'] == 'Super Admin'){
    $addedBranchSerach = '';
}
else {
    if ($_COOKIE['role'] == 'Admin'){
        $addedBranchSerach = "AND branch_name='$cookieBranch_Id'";

    }
//    else{
//        $addedBranchSerach = "AND added_by='$cookieStaffId' AND branch_name='$cookieBranch_Id'";
//
//    }

}
$service_add = 0;
if($service_id != '' && $service_type == 'Furnace Lining') {
$sql = "SELECT * FROM furnace WHERE service_id='$service_id'";
$result = mysqli_query($conn, $sql);
if (mysqli_num_rows($result) > 0) {
    $row = mysqli_fetch_assoc($result);
    $furnace_id = $row['furnace_id'];
    $service_add = 1;
    $visit_date = $row['visit_date'];
    $capacity = $row['capacity'];
    $company_name = $row['company_name'];
    $service_type = $row['service_type'];
    $service_id = $row['service_id'];
    $furnace_no = $row['furnace_no'];
    $furnace_top = $row['furnace_top'];
    $furnace_bottom = $row['furnace_bottom'];
    $furnace_height = $row['furnace_height'];
    $material_type = $row['material_type'];
    $gld = $row['gld'];
    $fork_height = $row['fork_height'];
    $sharpness = $row['sharpness'];
    $tapping_temperature = $row['tapping_temperature'];
    $power = $row['power'];
    $panel_capacity = $row['panel_capacity'];
    $product_name = $row['product_name'];
    $grey = $row['grey'];
    $batch_no = $row['batch_no'];
    $former_top = $row['former_top'];
    $former_bottom = $row['former_bottom'];
    $former_height = $row['former_height'];
    $former_tapper = $row['former_tapper'];
    $gld_dimension = $row['gld_dimension'];
    $remark = $row['remark'];
    $thickness_bottom = $row['thickness_bottom'];
    $thickness_side = $row['thickness_side'];

}
}
$sqlFurnace_a = "SELECT COUNT(id) AS furnace FROM furnace_details WHERE furnace_id='$furnace_id' AND vibrator='bottom'";
$resultFurnace_a = mysqli_query($conn, $sqlFurnace_a);
$rowFurnace_a = mysqli_fetch_assoc($resultFurnace_a);
$plCount = $rowFurnace_a['furnace'];

$sqlFurnace_b = "SELECT COUNT(id) AS hlCount FROM furnace_details WHERE furnace_id='$furnace_id' AND vibrator='side'";
$resultFurnace_b = mysqli_query($conn, $sqlFurnace_b);
$rowFurnace_b = mysqli_fetch_assoc($resultFurnace_b);
$hlCount = $rowFurnace_b['hlCount'];

if($service_id != '' && $service_type == 'Laddle Wet Lining') {
    $sql = "SELECT * FROM wet_lining WHERE service_id='$service_id'";
    $result = mysqli_query($conn, $sql);
    if (mysqli_num_rows($result) > 0) {
        $row = mysqli_fetch_assoc($result);
        $wet_lining_id = $row['wet_lining_id'];
        $service_add = 1;
        $visit_datewet = $row['visit_datewet'];
        $venuewet = $row['venuewet'];
        $customer_wet = $row['customer_wet'];
        $service_type = $row['service_type'];
        $service_id = $row['service_id'];
        $laddle_nowet = $row['laddle_nowet'];
        $laddle_diawet = $row['laddle_diawet'];
        $capacitywet = $row['capacitywet'];
        $laddle_heightwet = $row['laddle_heightwet'];
        $former_diawet = $row['former_diawet'];
        $former_heightwet = $row['former_heightwet'];
        $product_usedwet = $row['product_usedwet'];
        $batch_nowet = $row['batch_nowet'];
        $liquidwet = $row['liquidwet'];
        $waterwet = $row['waterwet'];
        $material_typewet = $row['material_typewet'];
        $pendingwet = $row['pendingwet'];
        $wastagewet = $row['wastagewet'];
        $lining_end_timewet = $row['lining_end_timewet'];
        $remarkwet = $row['remarkwet'];
        $thickness_bottomwet = $row['thickness_bottomwet'];
        $thickness_sidewet = $row['thickness_sidewet'];
        $total_weightwet = $row['total_weightwet'];

    }
}
$sqlWet_a = "SELECT COUNT(id) AS wet_a FROM wet_lining_details WHERE wet_lining_id='$wet_lining_id' AND layer='bottom'";
$resultWet_a = mysqli_query($conn, $sqlWet_a);
$rowWet_a = mysqli_fetch_assoc($resultWet_a);
$wetBCount = $rowWet_a['wet_a'];

$sqlWet_b = "SELECT COUNT(id) AS wet_b FROM wet_lining_details WHERE wet_lining_id='$wet_lining_id' AND layer='side'";
$resultWet_b = mysqli_query($conn, $sqlWet_b);
$rowWet_b = mysqli_fetch_assoc($resultWet_b);
$wetSCount = $rowWet_b['wet_b'];


if($service_id != '' && $service_type == 'Laddle Dry Lining') {
    $sql = "SELECT * FROM dry_lining WHERE service_id='$service_id'";
    $result = mysqli_query($conn, $sql);
    if (mysqli_num_rows($result) > 0) {
        $row = mysqli_fetch_assoc($result);
        $dry_lining_id = $row['dry_lining_id'];
        $service_add = 1;
        $visit_datedry = $row['visit_datedry'];
        $venuedry = $row['venuedry'];
        $customer_dry = $row['customer_dry'];
        $service_type = $row['service_type'];
        $service_id = $row['service_id'];
        $laddle_nodry = $row['laddle_nodry'];
        $capacitydry = $row['capacitydry'];
        $laddle_diadry = $row['laddle_diadry'];
        $laddle_heightdry = $row['laddle_heightdry'];
        $former_diadry = $row['former_diadry'];
        $former_heightdry = $row['former_heightdry'];
        $product_useddry = $row['product_useddry'];
        $batch_nodry = $row['batch_nodry'];
        $liquiddry = $row['liquiddry'];
        $waterdry = $row['waterdry'];
        $material_typedry = $row['material_typedry'];
        $lining_start_timedry = $row['lining_start_timedry'];
        $firing_timedry = $row['firing_timedry'];
        $former_remove_timedry = $row['former_remove_timedry'];
        $pendingdry = $row['pendingdry'];
        $wastagedry = $row['wastagedry'];
        $lining_end_timedry = $row['lining_end_timedry'];
        $remarkdry = $row['remarkdry'];
        $typedry = $row['typedry'];
        $thickness_bottomdry = $row['thickness_bottomdry'];
        $thickness_sidedry = $row['thickness_sidedry'];
        $total_weightdry = $row['total_weightdry'];

    }
}
$sqlDry_a = "SELECT COUNT(id) AS dry_a FROM dry_lining_details WHERE dry_lining_id='$dry_lining_id' AND layer='bottom'";
$resultDry_a = mysqli_query($conn, $sqlDry_a);
$rowDry_a = mysqli_fetch_assoc($resultDry_a);
$dryBCount = $rowDry_a['dry_a'];

$sqlDry_b = "SELECT COUNT(id) AS dry_b FROM dry_lining_details WHERE dry_lining_id='$dry_lining_id' AND layer='side'";
$resultDry_b = mysqli_query($conn, $sqlDry_b);
$rowDry_b = mysqli_fetch_assoc($resultDry_b);
$drySCount = $rowDry_b['dry_b'];

if($service_id != '' && $service_type == 'Erosion Analysis') {
    $sql = "SELECT * FROM erosion WHERE service_id='$service_id'";
    $result = mysqli_query($conn, $sql);
    if (mysqli_num_rows($result) > 0) {
        $row = mysqli_fetch_assoc($result);
        $erosion_id = $row['erosion_id'];
        $service_add = 1;
        $dateer = $row['dateer'];
        $customer_er = $row['customer_er'];
        $material_typeer = $row['material_typeer'];
        $service_type = $row['service_type'];
        $service_id = $row['service_id'];
        $locationer = $row['locationer'];
        $ms_nameer = $row['ms_nameer'];
        $ms_mobileer = $row['ms_mobileer'];
        $mm_nameer = $row['mm_nameer'];
        $mm_mobileer = $row['mm_mobileer'];
        $monthly_productioner = $row['monthly_productioner'];
        $temper = $row['temper'];
        $powerer = $row['powerer'];
        $capacityer = $row['capacityer'];
        $sger = $row['sger'];
        $greyer = $row['greyer'];
        $batch_noer = $row['batch_noer'];
        $typeer = $row['typeer'];
        $materialer = $row['materialer'];
        $brickser = $row['brickser'];
        $competiterer = $row['competiterer'];
        $d1_c1 = $row['d1_c1'];
        $d2_c2 = $row['d2_c2'];
        $d3_c3 = $row['d3_c3'];
        $h1_h2 = $row['h1_h2'];
        $heat_gone = $row['heat_gone'];
        $Ad1_Ac1 = $row['Ad1_Ac1'];
        $Ad2_Ac2 = $row['Ad2_Ac2'];
        $Ad3_Ac3 = $row['Ad3_Ac3'];
        $Ah1_h2 = $row['Ah1_h2'];

    }
}
$sqlEr_a = "SELECT COUNT(id) AS er_a FROM erosion_details WHERE erosion_id='$erosion_id' AND erosion_type='laddle'";
$resultEr_a = mysqli_query($conn, $sqlEr_a);
$rowEr_a = mysqli_fetch_assoc($resultEr_a);
$erLCount = $rowEr_a['er_a'];

$sqlEr_b = "SELECT COUNT(id) AS er_b FROM erosion_details WHERE erosion_id='$erosion_id' AND erosion_type='furnace'";
$resultEr_b = mysqli_query($conn, $sqlEr_b);
$rowEr_b = mysqli_fetch_assoc($resultEr_b);
$erFCount = $rowEr_b['er_b'];

//$hlCount =1;
//$plCount =1;
//$wetBCount =1;
//$wetSCount =1;
//$dryBCount =1;
//$drySCount =1;
//$erLCount =1;
//$erFCount =1;
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width,initial-scale=1">
    <title>Service</title>

    <link rel="icon" type="image/png" sizes="16x16" href="../images/favicon_New.png">
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


    <link rel="stylesheet" href="../vendor/select2/css/select2.min.css">

    <link href="../vendor/bootstrap-material-datetimepicker/css/bootstrap-material-datetimepicker.css" rel="stylesheet">

    <link rel="stylesheet" href="../vendor/pickadate/themes/default.css">
    <link rel="stylesheet" href="../vendor/pickadate/themes/default.date.css">
    <link href="../vendor/summernote/summernote.css" rel="stylesheet">


    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datetimepicker/4.7.14/css/bootstrap-datetimepicker.min.css">


</head>
<style>
    /*table {*/
    /*    font-size: 12px;*/
    /*}*/
    .btn.btn-sm {
        /* Adjust the font size */
        font-size: 12px;
        /* Adjust padding if needed */
        padding: 5px 10px;
    }
    .error {
        color:red;
    }
    body{
        font-size: 15px;
    }

    .productListUl {

        background: aliceblue;
        text-align: center;
        height: auto;
        max-height: 131px;
        overflow-y: scroll;

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
    $header = "Service";
    $header_name =$header . " - " . $service_type . " Edit";
    Include ('../includes/header.php')
    ?>
    <div class="content-body">
        <div class="page-titles" style="margin-left: 21px;">
            <!--            <ol class="breadcrumb">-->
            <!--                <li class="breadcrumb-item"><a href="javascript:void(0)">Table</a></li>-->
            <!--                <li class="breadcrumb-item active"><a href="javascript:void(0)">Furnace</a></li>-->
            <!--            </ol>-->
        </div>
        <?php
        if($service_type =='Furnace Lining'){
        ?>
        <div class="col-lg-12">
            <div class="card">
                <div class="card-body">
                    <div class="col-lg-12">
                    </div>
                    <div class="basic-form" style="color: black;">
                        <form id="q1_form">
                            <div class="form-row">

                                <div class="form-group col-md-4">
                                    <label> Customer Name </label>
                                    <input type="text" class="form-control" placeholder="Customer Name" id="customer_name" name="customer_name" value="<?php echo $company_name?>" style="border-color: #181f5a;color: black;text-transform: uppercase">
                                    <input type="hidden" class="form-control"  id="api" name="api">
                                    <input type="hidden" class="form-control"  id="old_pa_id" name="old_pa_id">
                                    <input type="hidden" class="form-control"  id="furnace_id" name="furnace_id" value="<?php echo $furnace_id?>">
                                    <input type="hidden" class="form-control"  id="service_id" name="service_id" value="<?php echo $service_id?>">
                                    <input type="hidden" class="form-control"  id="service_type" name="service_type" value="<?php echo $service_type?>">
                                    <input type="hidden" class="form-control"  id="service_add" name="service_add" value="<?php echo $service_add?>">
                                </div>
                                <div class="form-group col-md-4">
                                    <label> Visit Date </label>
                                    <input type="date" class="form-control"  id="visit_date" name="visit_date" value="<?php echo $visit_date?>" style="border-color: #181f5a;color: black;text-transform: uppercase">
                                </div>

                                <div class="form-group col-md-4">
                                    <label>Furnace No </label>
                                    <input type="text" class="form-control"  id="furnace_no" name="furnace_no" placeholder="Furnace No" value="<?php echo $furnace_no?>" style="border-color: #181f5a;color: black;text-transform: uppercase">
                                </div>

                                <div class="form-group col-md-4">
                                    <label>Furnace Capacity </label>
                                    <input type="text" class="form-control" placeholder="Furnace Capacity" id="capacity" name="capacity" value="<?php echo $capacity?>" style="border-color: #181f5a;color: black">
                                    <!--onkeyup="this.value = fnc(this.value, 0, 100)"-->
                                </div>
                                <div class="form-group col-md-4">
                                    <label>Material Type</label>
                                    <select name="material_type" id="material_type" class="form-control" value="<?php echo $material_type?>" style="border-color: #181f5a;color: black">
                                        <option value="Mica Sheet">Mica Sheet</option>
                                        <option value="Mill Board">Mill Board Paper Thickness</option>
                                    </select>
                                </div>
                                <div class="form-group col-md-4">
                                    <label>GLD Value </label>
                                    <input type="text" class="form-control" placeholder="GLD Value" id="gld" name="gld" value="<?php echo $gld?>" style="border-color: #181f5a;color: black">
                                </div>
                                <div class="form-group col-md-4">
                                    <label>Fork Height </label>
                                    <input type="text" class="form-control" placeholder="Fork Height" id="fork_height" name="fork_height" value="<?php echo $fork_height?>" style="border-color: #181f5a;color: black">
                                </div>
                                <div class="form-group col-md-4" >
                                    <label>Sharpness </label>
                                    <input type="text" class="form-control" placeholder="Sharpness" id="sharpness" name="sharpness" value="<?php echo $sharpness?>" style="border-color: #181f5a;color: black">
                                </div>
                                <div class="form-group col-md-4">
                                    <label>Tapping Temperature  </label>
                                    <input type="text" class="form-control" placeholder="Tapping Temperature" id="tapping_temperature" name="tapping_temperature" value="<?php echo $tapping_temperature?>" style="border-color: #181f5a;color: black">
                                </div>
                                <div class="form-group col-md-4">
                                    <label>Power </label>
                                    <input type="text" class="form-control" placeholder="Power" id="power" name="power" value="<?php echo $power?>" style="border-color: #181f5a;color: black">
                                </div>
                                <div class="form-group col-md-4">
                                    <label>Panel Capacity</label>
                                    <input type="text" class="form-control" placeholder="Panel Capacity" id="panel_capacity" name="panel_capacity" value="<?php echo $panel_capacity?>" style="border-color: #181f5a;color: black">
                                </div>
                                <div class="form-group col-md-4">
                                    <label>Product Name </label>
                                    <input type="text" class="form-control" placeholder="Product Name" id="product_name" name="product_name" value="<?php echo $product_name?>" style="border-color: #181f5a;color: black">
                                </div>
                                <div class="form-group col-md-4">
                                    <label>Grey </label>
                                    <input type="text" class="form-control" placeholder="Grey" id="grey" name="grey" value="<?php echo $grey?>" style="border-color: #181f5a;color: black">
                                </div>
                                <div class="form-group col-md-4">
                                    <label>Batch No </label>
                                    <input type="text" class="form-control" placeholder="Batch No" id="batch_no" name="batch_no" value="<?php echo $batch_no?>" style="border-color: #181f5a;color: black">
                                </div>
                                <div class="form-group col-md-4">
                                    <label>Furnace Top-Dia </label>
                                    <input type="number" class="form-control" placeholder="Furnace Top-Dia" id="furnace_top" name="furnace_top" value="<?php echo $furnace_top?>" style="border-color: #181f5a;color: black">
                                </div>
                                <div class="form-group col-md-4">
                                    <label>Furnace Bottom-Dia </label>
                                    <input type="number" class="form-control" placeholder="Furnace Bottom-Dia" id="furnace_bottom" name="furnace_bottom" value="<?php echo $furnace_bottom?>" style="border-color: #181f5a;color: black">
                                </div>
                                <div class="form-group col-md-4">
                                    <label>Furnace Height</label>
                                    <input type="number" class="form-control" placeholder="Furnace Height" id="furnace_height" name="furnace_height" value="<?php echo $furnace_height?>" style="border-color: #181f5a;color: black">
                                </div>
                                <div class="form-group col-md-4">
                                    <label>Former Top-Dia </label>
                                    <input type="number" class="form-control" placeholder="Former Top-Dia" id="former_top" name="former_top" value="<?php echo $former_top?>" style="border-color: #181f5a;color: black">
                                </div>
                                <div class="form-group col-md-4">
                                    <label>Former Bottom-Dia </label>
                                    <input type="number" class="form-control" placeholder="Former Bottom-Dia" id="former_bottom" name="former_bottom" value="<?php echo $former_bottom?>" style="border-color: #181f5a;color: black">
                                </div>
                                <div class="form-group col-md-4">
                                    <label>Former Height </label>
                                    <input type="number" class="form-control" placeholder="Former Height" id="former_height" name="former_height" value="<?php echo $former_height?>" style="border-color: #181f5a;color: black">
                                </div>
                                <div class="form-group col-md-4">
                                    <label>Former Topper-Height </label>
                                    <input type="number" class="form-control" placeholder="Former Topper-Height" id="former_tapper" name="former_tapper" value="<?php echo $former_tapper?>" style="border-color: #181f5a;color: black">
                                </div>

                                <div class="form-group col-md-4">
                                    <label>Gld Dimensions </label>
                                    <input type="number" class="form-control" placeholder="Gld Dimensions" id="gld_dimension" name="gld_dimension" value="<?php echo $gld_dimension?>" style="border-color: #181f5a;color: black">
                                </div>
                                <div class="form-group col-md-4">
                                    <label>Remarks </label>
                                    <input type="text" class="form-control" placeholder="Remarks" id="remark" name="remark" value="<?php echo $remark?>" style="border-color: #181f5a;color: black">
                                </div>
                                <div class="form-group col-md-4">
                                    <label>Lining Thickness Bottom </label>
                                    <input type="number" class="form-control" placeholder="Lining Thickness Bottom" id="thickness_bottom" name="thickness_bottom" value="<?php echo $thickness_bottom?>" style="border-color: #181f5a;color: black">
                                </div>
                                <div class="form-group col-md-4">
                                    <label>Lining Thickness Side </label>
                                    <input type="number" class="form-control" placeholder="Lining Thickness Side" id="thickness_side" name="thickness_side" value="<?php echo $thickness_side?>" style="border-color: #181f5a;color: black">
                                </div>
<!--                                <div class="form-group col-md-4">-->
<!--                                    <label>Total Weight</label>-->
<!--                                    <input type="number" class="form-control" placeholder="Total Weight" id="total_weight" name="total_weight"  style="border-color: #181f5a;color: black">-->
<!--                                </div>-->
                            </div>

                            <section class="review-section information">
                                <div class="review-header text-center">
                                    <h3 class="review-title">Bottom Layer</h3>
                                    <button onclick="addPL()" type="button" class="btn btn-success w-30">Create</button>
                                </div>
                                <div class="row" style="margin-top: 20px;padding: 15px;">
                                    <div class="col-md-12 col-sm-12">
                                        <div class="" id="personalLoan_div">
                                            <!-- Div are Insert Here-->
                                              <?php
                                              if($plCount > 0) {
                                                  $sqlPersonalLoan = "SELECT * FROM furnace_details WHERE furnace_id='$furnace_id' AND vibrator='bottom'";
                                                  $resultPersonalLoan = mysqli_query($conn, $sqlPersonalLoan);
                                                  if (mysqli_num_rows($resultPersonalLoan)>0) {
                                                      $plCount_id = 0;
                                                      while($rowPersonalLoan = mysqli_fetch_assoc($resultPersonalLoan)) {
                                                          $plCount_id++;
                                                          $pressure = $rowPersonalLoan['pressure'];
                                                          $qty = $rowPersonalLoan['qty'];
                                                          $fork_start_time = $rowPersonalLoan['fork_start_time'];
                                                          $fork_close_time = $rowPersonalLoan['fork_close_time'];
                                                          $vibrator_start_time = $rowPersonalLoan['vibrator_start_time'];
                                                          $vibrator_close_time = $rowPersonalLoan['vibrator_close_time'];
                                                          ?>
                                                          <div class="row personalLoanInputs" id="<?php echo 'personalLoan_divRow_'.$plCount_id?>"><br>
                                                              <h2 class="personalLoan_divRow_heading" style="width:100%">Bottom Layer <?php echo $plCount_id?></h2>
                                                              <br>
                                                          <div class="col-md-4">
                                                              <div class="input-block mb-3">
                                                                  <label>PRESSURE</label>
                                                                  <input type="text" class="form-control plAdd" id="<?php echo 'pressure_'.$plCount_id?>" name="<?php echo 'pressure_'.$plCount_id?>" value="<?php echo $pressure?>" style="border-color: black;color: black">
                                                              </div>
                                                          </div>
                                                          <div class="col-md-4">
                                                              <div class="input-block mb-3">
                                                                  <label>QTY</label>
                                                                  <input type="text" class="form-control plAdd" id="<?php echo 'qty_'.$plCount_id?>" name="<?php echo 'qty_'.$plCount_id?>" value="<?php echo $qty?>" style="border-color: black;color: black">
                                                              </div>
                                                          </div>
                                                          <div class="col-md-4">
                                                              <div class="input-block mb-3">
                                                                  <label>FORK START TIME</label>
                                                                  <input type="time" class="form-control plAdd" id="<?php echo 'fork_start_time_'.$plCount_id?>" name="<?php echo 'fork_start_time_'.$plCount_id?>" value="<?php echo $fork_start_time?>" style="border-color: black;color: black">
                                                              </div>
                                                          </div>
                                                          <div class="col-md-4">
                                                              <div class="input-block mb-3">
                                                                  <label>FORK CLOSE TIME</label>
                                                                  <input type="time" class="form-control plAdd" id="<?php echo 'fork_close_time_'.$plCount_id?>" name="<?php echo 'fork_close_time_'.$plCount_id?>" value="<?php echo $fork_close_time?>" style="border-color: black;color: black">
                                                              </div>
                                                          </div>
                                                          <div class="col-md-4">
                                                              <div class="input-block mb-3">
                                                                  <label>VIBRATOR START TIME</label>
                                                                  <input type="time" class="form-control plAdd" id="<?php echo 'vibrator_start_time_'.$plCount_id?>" name="<?php echo 'vibrator_start_time_'.$plCount_id?>" value="<?php echo $vibrator_start_time?>" style="border-color: black;color: black">
                                                              </div>
                                                          </div>
                                                          <div class="col-md-4">
                                                              <div class="input-block mb-3">
                                                                  <label>VIBRATOR CLOSE TIME</label>
                                                                  <input type="time" class="form-control plAdd" id="<?php echo 'vibrator_close_time_'.$plCount_id?>" name="<?php echo 'vibrator_close_time_'.$plCount_id?>" value="<?php echo $vibrator_close_time?>" style="border-color: black;color: black">
                                                              </div>
                                                          </div>
                                                              <div class="col-md-4">
                                                                  <div class="input-block mb-3">
                                                                      <button type="button" class="btn btn-danger w-30" onclick="removeEle('<?php echo 'personalLoan_divRow_'.$plCount_id?>','pl')">Remove</button>
                                                                  </div>

                                                              </div>
                                                          </div>
                                                          <?php
                                                      }
                                                  }
                                              }

                                            ?>

                                        </div>
                                    </div>
                                </div>
                            </section>

                            <section class="review-section information">
                                <div class="review-header text-center">
                                    <h3 class="review-title">Side Layer</h3>
                                    <button onclick="addHL()" type="button" class="btn btn-success w-30">Create</button>
                                </div>
                                <div class="row" style="margin-top: 20px;padding: 15px;">
                                    <div class="col-md-12 col-sm-12">
                                        <div class="" id="homeLoan_div">
                                            <!-- Div are Insert Here-->
                                            <?php
                                            if($hlCount > 0) {
                                                $sqlHomeLoan = "SELECT * FROM furnace_details WHERE furnace_id='$furnace_id' AND vibrator='side'";
                                                $resultHomeLoan = mysqli_query($conn, $sqlHomeLoan);
                                                if (mysqli_num_rows($resultHomeLoan)>0) {
                                                    $hlCount_id = 0;
                                                    while($rowHomeLoan = mysqli_fetch_assoc($resultHomeLoan)) {
                                                        $hlCount_id++;
                                                        $pressure = $rowHomeLoan['pressure'];
                                                        $qty = $rowHomeLoan['qty'];
                                                        $fork_start_time = $rowHomeLoan['fork_start_time'];
                                                        $fork_close_time = $rowHomeLoan['fork_close_time'];
                                                        $vibrator_start_time = $rowHomeLoan['vibrator_start_time'];
                                                        $vibrator_close_time = $rowHomeLoan['vibrator_close_time'];
                                                        ?>
                                                        <div class="row personalLoanInputs" id="<?php echo 'personalLoan_divRow_'.$hlCount_id?>"><br>
                                                            <h2 class="personalLoan_divRow_heading" style="width:100%">Side Layer <?php echo $hlCount_id?></h2>
                                                            <br>
                                                            <div class="col-md-4">
                                                                <div class="input-block mb-3">
                                                                    <label>PRESSURE</label>
                                                                    <input type="text" class="form-control plAdd" id="<?php echo 'pressure_'.$hlCount_id?>" name="<?php echo 'pressure_'.$hlCount_id?>" value="<?php echo $pressure?>" style="border-color: black;color: black">
                                                                </div>
                                                            </div>
                                                            <div class="col-md-4">
                                                                <div class="input-block mb-3">
                                                                    <label>QTY</label>
                                                                    <input type="text" class="form-control plAdd" id="<?php echo 'qty_'.$hlCount_id?>" name="<?php echo 'qty_'.$hlCount_id?>" value="<?php echo $qty?>" style="border-color: black;color: black">
                                                                </div>
                                                            </div>
                                                            <div class="col-md-4">
                                                                <div class="input-block mb-3">
                                                                    <label>FORK START TIME</label>
                                                                    <input type="time" class="form-control plAdd" id="<?php echo 'fork_start_time_'.$hlCount_id?>" name="<?php echo 'fork_start_time_'.$hlCount_id?>" value="<?php echo $fork_start_time?>" style="border-color: black;color: black">
                                                                </div>
                                                            </div>
                                                            <div class="col-md-4">
                                                                <div class="input-block mb-3">
                                                                    <label>FORK CLOSE TIME</label>
                                                                    <input type="time" class="form-control plAdd" id="<?php echo 'fork_close_time_'.$hlCount_id?>" name="<?php echo 'fork_close_time_'.$hlCount_id?>" value="<?php echo $fork_close_time?>" style="border-color: black;color: black">
                                                                </div>
                                                            </div>
                                                            <div class="col-md-4">
                                                                <div class="input-block mb-3">
                                                                    <label>VIBRATOR START TIME</label>
                                                                    <input type="time" class="form-control plAdd" id="<?php echo 'vibrator_start_time_'.$hlCount_id?>" name="<?php echo 'vibrator_start_time_'.$hlCount_id?>" value="<?php echo $vibrator_start_time?>" style="border-color: black;color: black">
                                                                </div>
                                                            </div>
                                                            <div class="col-md-4">
                                                                <div class="input-block mb-3">
                                                                    <label>VIBRATOR CLOSE TIME</label>
                                                                    <input type="time" class="form-control plAdd" id="<?php echo 'vibrator_close_time_'.$hlCount_id?>" name="<?php echo 'vibrator_close_time_'.$hlCount_id?>" value="<?php echo $vibrator_close_time?>" style="border-color: black;color: black">
                                                                </div>
                                                            </div>
                                                            <div class="col-md-4">
                                                                <div class="input-block mb-3">
                                                                    <button type="button" class="btn btn-danger w-30" onclick="removeEle('<?php echo 'personalLoan_divRow_'.$plCount_id?>','hl')">Remove</button>
                                                                </div>

                                                            </div>
                                                        </div>
                                                        <?php
                                                    }
                                                }
                                            }

                                            ?>

                                        </div>

                                    </div>
                                </div>
                            </section>


                            <div style="display: inline-block;">
                            </div>
                            <div style="margin-bottom: 25px;float: right;">
                                <button class="btn btn-primary" id="form_btn" type="button">Save Details</button>
                            </div>
                        </form>
                    </div>

                </div>
            </div>
        </div>
        <?php
        }
        ?>
        <?php
        if($service_type =='Laddle Wet Lining'){
        ?>
        <div class="col-lg-12">
            <div class="card">
                <div class="card-body">
                    <div class="col-lg-12">
                    </div>
                    <div class="basic-form" style="color: black;">
                        <form id="q1_form">
                            <div class="form-row">

                                <div class="form-group col-md-4">
                                    <label> Customer Name </label>
                                    <input type="text" class="form-control" placeholder="Customer Name" id="customer_wet" name="customer_wet" value="<?php echo $customer_wet?>" style="border-color: #181f5a;color: black;text-transform: uppercase">
                                    <input type="hidden" class="form-control"  id="apiwet" name="apiwet">
                                    <input type="hidden" class="form-control"  id="old_pa_idwet" name="old_pa_idwet">
                                    <input type="hidden" class="form-control"  id="furnace_idwet" name="furnace_idwet" value="<?php echo $wet_lining_id?>">
                                    <input type="hidden" class="form-control"  id="service_id" name="service_id" value="<?php echo $service_id?>">
                                    <input type="hidden" class="form-control"  id="service_type" name="service_type" value="<?php echo $service_type?>">
                                    <input type="hidden" class="form-control"  id="service_add" name="service_add" value="<?php echo $service_add?>">
                                </div>
                                <div class="form-group col-md-4">
                                    <label> Visit Date </label>
                                    <input type="date" class="form-control"  id="visit_datewet" name="visit_datewet" value="<?php echo $visit_datewet?>" style="border-color: #181f5a;color: black;text-transform: uppercase">
                                </div>
                                <div class="form-group col-md-4">
                                    <label>Venue </label>
                                    <input type="text" class="form-control"  id="venuewet" name="venuewet" placeholder="Venue" value="<?php echo $venuewet?>" style="border-color: #181f5a;color: black;text-transform: uppercase">
                                </div>
                                <div class="form-group col-md-4">
                                    <label>Laddle No </label>
                                    <input type="text" class="form-control" placeholder="Laddle No" id="laddle_nowet" name="laddle_nowet" value="<?php echo $laddle_nowet?>" style="border-color: #181f5a;color: black">
                                    <!--onkeyup="this.value = fnc(this.value, 0, 100)"-->
                                </div>
                                <div class="form-group col-md-4">
                                    <label>Laddle Capacity</label>
                                    <input type="text" class="form-control" placeholder="Laddle Capacity" id="capacitywet" name="capacitywet" value="<?php echo $capacitywet?>" style="border-color: #181f5a;color: black">

                                </div>
                                <div class="form-group col-md-4">
                                    <label>Laddle Dia </label>
                                    <input type="text" class="form-control" placeholder="Laddle Dia" id="laddle_diawet" name="laddle_diawet" value="<?php echo $laddle_diawet?>" style="border-color: #181f5a;color: black">
                                </div>
                                <div class="form-group col-md-4">
                                    <label>Laddle Height </label>
                                    <input type="text" class="form-control" placeholder="Laddle Height" id="laddle_heightwet" name="laddle_heightwet" value="<?php echo $laddle_heightwet?>" style="border-color: #181f5a;color: black">
                                </div>
                                <div class="form-group col-md-4" >
                                    <label>Former Dia </label>
                                    <input type="text" class="form-control" placeholder="Former Dia" id="former_diawet" name="former_diawet" value="<?php echo $former_diawet?>" style="border-color: #181f5a;color: black">
                                </div>
                                <div class="form-group col-md-4">
                                    <label>Former Height  </label>
                                    <input type="text" class="form-control" placeholder="Former Height" id="former_heightwet" name="former_heightwet" value="<?php $former_heightwet?>" style="border-color: #181f5a;color: black">
                                </div>
                                <div class="form-group col-md-4">
                                    <label>Product Used </label>
                                    <input type="text" class="form-control" placeholder="Product Used" id="product_usedwet" name="product_usedwet" value="<?php echo $product_usedwet?>" style="border-color: #181f5a;color: black">
                                </div>
                                <div class="form-group col-md-4">
                                    <label>Batch No</label>
                                    <input type="text" class="form-control" placeholder="Batch No" id="batch_nowet" name="batch_nowet" value="<?php echo $batch_nowet?>" style="border-color: #181f5a;color: black">
                                </div>
                                <div class="form-group col-md-4">
                                    <label>Liquid </label>
                                    <input type="text" class="form-control" placeholder="Liquid" id="liquidwet" name="liquidwet" value="<?php echo $liquidwet?>" style="border-color: #181f5a;color: black">
                                </div>
                                <div class="form-group col-md-4">
                                    <label>Water Based % </label>
                                    <input type="text" class="form-control" placeholder="Water Based %" id="waterwet" name="waterwet" value="<?php echo $waterwet?>" style="border-color: #181f5a;color: black">
                                </div>
                                <div class="form-group col-md-4">
                                    <label>Paper Used</label>
                                    <select name="material_type" id="material_typewet" name="material_typewet" class="form-control" value="<?php echo $material_typewet?>" style="border-color: #181f5a;color: black">
                                        <option value="Card Board">Card Board</option>
                                        <option value="Ceramic Paper">Ceramic Paper</option>
                                    </select>
                                </div>
                                <div class="form-group col-md-4">
                                    <label>Pending Liquid Quantity </label>
                                    <input type="text" class="form-control" placeholder="Pending Liquid Quantity" id="pendingwet" name="pendingwet" value="<?php echo $pendingwet?>" style="border-color: #181f5a;color: black">
                                </div>
                                <div class="form-group col-md-4">
                                    <label>Wastage Quantity </label>
                                    <input type="text" class="form-control" placeholder="Wastage Quantity" id="wastagewet" name="wastagewet" value="<?php echo $wastagewet?>" style="border-color: #181f5a;color: black">
                                </div>
                                <div class="form-group col-md-4">
                                    <label>Lining End Time</label>
                                    <input type="time" class="form-control" placeholder="Total Weight" id="lining_end_timewet" name="lining_end_timewet" value="<?php echo $lining_end_timewet?>" style="border-color: #181f5a;color: black">
                                </div>
                                <div class="form-group col-md-4">
                                    <label>Remarks </label>
                                    <input type="text" class="form-control" placeholder="Remarks" id="remarkwet" name="remarkwet" value="<?php echo $remarkwet?>" style="border-color: #181f5a;color: black">
                                </div>
                                <div class="form-group col-md-4">
                                    <label>Lining Thickness Bottom </label>
                                    <input type="number" class="form-control" placeholder="Lining Thickness Bottom" id="thickness_bottomwet" name="thickness_bottomwet" value="<?php echo $thickness_bottomwet?>" style="border-color: #181f5a;color: black">
                                </div>
                                <div class="form-group col-md-4">
                                    <label>Lining Thickness Side </label>
                                    <input type="number" class="form-control" placeholder="Lining Thickness Side" id="thickness_sidewet" name="thickness_sidewet" value="<?php echo $thickness_sidewet?>" style="border-color: #181f5a;color: black">
                                </div>
                                <div class="form-group col-md-4">
                                    <label>Total Weight</label>
                                    <input type="number" class="form-control" placeholder="Total Weight" id="total_weightwet" name="total_weightwet" value="<?php echo $total_weightwet?>" style="border-color: #181f5a;color: black">
                                </div>
                            </div>

                            <section class="review-section information">
                                <div class="review-header text-center">
                                    <h3 class="review-title">Bottom Layer</h3>
                                    <button onclick="wetB()" type="button" class="btn btn-success w-30">Create</button>
                                </div>
                                <div class="row" style="margin-top: 20px;padding: 15px;">
                                    <div class="col-md-12 col-sm-12">
                                        <div class="" id="wetB_div">
                                            <!-- Div are Insert Here-->
                                            <?php
                                            if($wetBCount > 0) {
                                                $sqlwetB = "SELECT * FROM wet_lining_details WHERE wet_lining_id='$wet_lining_id' AND layer='bottom'";
                                                $resultwetB = mysqli_query($conn, $sqlwetB);
                                                if (mysqli_num_rows($resultwetB)>0) {
                                                    $wetBCount_id = 0;
                                                    while($rowwetB = mysqli_fetch_assoc($resultwetB)) {
                                                        $wetBCount_id++;
                                                        $qty = $rowwetB['qty'];
                                                        $dry_start_time = $rowwetB['dry_start_time'];
                                                        $dry_close_time = $rowwetB['dry_close_time'];
                                                        $liquid_start_time = $rowwetB['liquid_start_time'];
                                                        $liquid_close_time = $rowwetB['liquid_close_time'];
                                                        $dry_liquid_total_time = $rowwetB['dry&liquid_total_time'];
                                                        $water_usage = $rowwetB['water_usage'];
                                                        ?>
                                                        <div class="row wetBInputs" id="<?php echo 'wetB_divRow_'.$wetBCount_id?>"><br>
                                                            <h2 class="wetB_divRow_heading" style="width:100%">Bottom Layer <?php echo $wetBCount_id?></h2>
                                                            <br>

                                                            <div class="col-md-4">
                                                                <div class="input-block mb-3">
                                                                    <label>QTY</label>
                                                                    <input type="text" class="form-control wetBAdd" id="<?php echo 'qty_'.$wetBCount_id?>" name="<?php echo 'qty_'.$wetBCount_id?>" value="<?php echo $qty?>" style="border-color: black;color: black">
                                                                </div>
                                                            </div>
                                                            <div class="col-md-4">
                                                                <div class="input-block mb-3">
                                                                    <label>DRY START TIME</label>
                                                                    <input type="time" class="form-control wetBAdd" id="<?php echo 'dry_start_time_'.$wetBCount_id?>" name="<?php echo 'dry_start_time_'.$wetBCount_id?>" value="<?php echo $dry_start_time?>" style="border-color: black;color: black">
                                                                </div>
                                                            </div>
                                                            <div class="col-md-4">
                                                                <div class="input-block mb-3">
                                                                    <label>DRY CLOSE TIME</label>
                                                                    <input type="time" class="form-control wetBAdd" id="<?php echo 'dry_close_time_'.$wetBCount_id?>" name="<?php echo 'dry_close_time_'.$wetBCount_id?>" value="<?php echo $dry_close_time?>" style="border-color: black;color: black">
                                                                </div>
                                                            </div>
                                                            <div class="col-md-4">
                                                                <div class="input-block mb-3">
                                                                    <label>LIQUID START TIME</label>
                                                                    <input type="time" class="form-control wetBAdd" id="<?php echo 'liquid_start_time_'.$wetBCount_id?>" name="<?php echo 'liquid_start_time_'.$wetBCount_id?>" value="<?php echo $liquid_start_time?>" style="border-color: black;color: black">
                                                                </div>
                                                            </div>
                                                            <div class="col-md-4">
                                                                <div class="input-block mb-3">
                                                                    <label>LIQUID CLOSE TIME</label>
                                                                    <input type="time" class="form-control wetBAdd" id="<?php echo 'liquid_close_time_'.$wetBCount_id?>" name="<?php echo 'liquid_close_time_'.$wetBCount_id?>" value="<?php echo $liquid_close_time?>" style="border-color: black;color: black">
                                                                </div>
                                                            </div>
                                                            <div class="col-md-4">
                                                                <div class="input-block mb-3">
                                                                    <label>WATER USAGE</label>
                                                                    <input type="text" class="form-control wetBAdd" id="<?php echo 'water_usage_'.$wetBCount_id?>" name="<?php echo 'water_usage_'.$wetBCount_id?>" value="<?php echo $water_usage?>" style="border-color: black;color: black">
                                                                </div>
                                                            </div>
                                                            <div class="col-md-4">
                                                                <div class="input-block mb-3">
                                                                    <button type="button" class="btn btn-danger w-30" onclick="removeEle('<?php echo 'wetB_divRow_'.$wetBCount_id?>','wetB')">Remove</button>
                                                                </div>

                                                            </div>
                                                        </div>
                                                        <?php
                                                    }
                                                }
                                            }

                                            ?>
                                        </div>
                                    </div>
                                </div>
                            </section>

                            <section class="review-section information">
                                <div class="review-header text-center">
                                    <h3 class="review-title">Side Layer</h3>
                                    <button onclick="wetS()" type="button" class="btn btn-success w-30">Create</button>
                                </div>
                                <div class="row" style="margin-top: 20px;padding: 15px;">
                                    <div class="col-md-12 col-sm-12">
                                        <div class="" id="wetS_div">
                                            <!-- Div are Insert Here-->
                                            <?php
                                            if($wetSCount > 0) {
                                                $sqlwetS = "SELECT * FROM wet_lining_details WHERE wet_lining_id='$wet_lining_id' AND layer='side'";
                                                $resultwetS = mysqli_query($conn, $sqlwetS);
                                                if (mysqli_num_rows($resultwetS)>0) {
                                                    $wetSCount_id = 0;
                                                    while($rowwetS = mysqli_fetch_assoc($resultwetS)) {
                                                        $wetSCount_id++;
                                                        $qty = $rowwetS['qty'];
                                                        $dry_start_time = $rowwetS['dry_start_time'];
                                                        $dry_close_time = $rowwetS['dry_close_time'];
                                                        $liquid_start_time = $rowwetS['liquid_start_time'];
                                                        $liquid_close_time = $rowwetS['liquid_close_time'];
                                                        $dry_liquid_total_time = $rowwetS['dry&liquid_total_time'];
                                                        $water_usage = $rowwetS['water_usage'];
                                                        ?>
                                                        <div class="row wetSInputs" id="<?php echo 'wetS_divRow_'.$wetSCount_id?>"><br>
                                                            <h2 class="wetS_divRow_heading" style="width:100%">Side Layer <?php echo $wetSCount_id?></h2>
                                                            <br>

                                                            <div class="col-md-4">
                                                                <div class="input-block mb-3">
                                                                    <label>QTY</label>
                                                                    <input type="text" class="form-control wetSAdd" id="<?php echo 'qty_'.$wetSCount_id?>" name="<?php echo 'qty_'.$wetSCount_id?>" value="<?php echo $qty?>" style="border-color: black;color: black">
                                                                </div>
                                                            </div>
                                                            <div class="col-md-4">
                                                                <div class="input-block mb-3">
                                                                    <label>DRY START TIME</label>
                                                                    <input type="time" class="form-control wetSAdd" id="<?php echo 'dry_start_time_'.$wetSCount_id?>" name="<?php echo 'dry_start_time_'.$wetSCount_id?>" value="<?php echo $dry_start_time?>" style="border-color: black;color: black">
                                                                </div>
                                                            </div>
                                                            <div class="col-md-4">
                                                                <div class="input-block mb-3">
                                                                    <label>DRY CLOSE TIME</label>
                                                                    <input type="time" class="form-control wetSAdd" id="<?php echo 'dry_close_time_'.$wetSCount_id?>" name="<?php echo 'dry_close_time_'.$wetSCount_id?>" value="<?php echo $dry_close_time?>" style="border-color: black;color: black">
                                                                </div>
                                                            </div>
                                                            <div class="col-md-4">
                                                                <div class="input-block mb-3">
                                                                    <label>LIQUID START TIME</label>
                                                                    <input type="time" class="form-control wetSAdd" id="<?php echo 'liquid_start_time_'.$wetSCount_id?>" name="<?php echo 'liquid_start_time_'.$wetSCount_id?>" value="<?php echo $liquid_start_time?>" style="border-color: black;color: black">
                                                                </div>
                                                            </div>
                                                            <div class="col-md-4">
                                                                <div class="input-block mb-3">
                                                                    <label>LIQUID CLOSE TIME</label>
                                                                    <input type="time" class="form-control wetSAdd" id="<?php echo 'liquid_close_time_'.$wetSCount_id?>" name="<?php echo 'liquid_close_time_'.$wetSCount_id?>" value="<?php echo $liquid_close_time?>" style="border-color: black;color: black">
                                                                </div>
                                                            </div>
                                                          
                                                            <div class="col-md-4">
                                                                <div class="input-block mb-3">
                                                                    <label>WATER USAGE</label>
                                                                    <input type="text" class="form-control wetSAdd" id="<?php echo 'water_usage_'.$wetSCount_id?>" name="<?php echo 'water_usage_'.$wetSCount_id?>" value="<?php echo $water_usage?>" style="border-color: black;color: black">
                                                                </div>
                                                            </div>
                                                            <div class="col-md-4">
                                                                <div class="input-block mb-3">
                                                                    <button type="button" class="btn btn-danger w-30" onclick="removeEle('<?php echo 'wetS_divRow_'.$wetSCount_id?>','wetS')">Remove</button>
                                                                </div>

                                                            </div>
                                                        </div>
                                                        <?php
                                                    }
                                                }
                                            }

                                            ?>
                                        </div>

                                    </div>
                                </div>
                            </section>


                            <div style="display: inline-block;">
                            </div>
                            <div style="margin-bottom: 25px;float: right;">
                                <button class="btn btn-primary" id="form_btn" type="button">Save Details</button>
                            </div>
                        </form>
                    </div>

                </div>
            </div>
        </div>
            <?php
        }
        ?>
        <?php
        if($service_type =='Laddle Dry Lining'){
        ?>
        <div class="col-lg-12">
            <div class="card">
                <div class="card-body">
                    <div class="col-lg-12">
                    </div>
                    <div class="basic-form" style="color: black;">
                        <form id="q1_form">
                            <div class="form-row">
                                <div class="form-group col-md-4">
                                    <label> Customer Name </label>
                                    <input type="text" class="form-control" placeholder="Customer Name" id="customer_dry" name="customer_dry" value="<?php echo $customer_dry?>" style="border-color: #181f5a;color: black;text-transform: uppercase">
                                    <input type="hidden" class="form-control"  id="api" name="api">
                                    <input type="hidden" class="form-control"  id="old_pa_id" name="old_pa_id">
                                    <input type="hidden" class="form-control"  id="furnace_iddry" name="furnace_iddry" value="<?php echo $dry_lining_id?>">
                                    <input type="hidden" class="form-control"  id="service_id" name="service_id" value="<?php echo $service_id?>">
                                    <input type="hidden" class="form-control"  id="service_type" name="service_type" value="<?php echo $service_type?>">
                                    <input type="hidden" class="form-control"  id="service_add" name="service_add" value="<?php echo $service_add?>">
                                </div>
                                <div class="form-group col-md-4">
                                    <label> Visit Date </label>
                                    <input type="date" class="form-control"  id="visit_datedry" name="visit_datedry" value="<?php echo $visit_datedry?>" style="border-color: #181f5a;color: black;text-transform: uppercase">
                                </div>
                                <div class="form-group col-md-4">
                                    <label>Venue </label>
                                    <input type="text" class="form-control"  id="venue" name="venuedry" placeholder="Venuedry" value="<?php echo $venuedry?>" style="border-color: #181f5a;color: black;text-transform: uppercase">
                                </div>
                                <div class="form-group col-md-4">
                                    <label>Laddle No </label>
                                    <input type="text" class="form-control" placeholder="Laddle No" id="laddle_nodry" name="laddle_nodry" value="<?php echo $laddle_nodry?>" style="border-color: #181f5a;color: black">
                                    <!--onkeyup="this.value = fnc(this.value, 0, 100)"-->
                                </div>
                                <div class="form-group col-md-4">
                                    <label>Laddle Capacity</label>
                                    <input type="text" class="form-control" placeholder="Laddle Capacity" id="capacitydry" name="capacitydry" value="<?php echo $capacitydry?>" style="border-color: #181f5a;color: black">

                                </div>
                                <div class="form-group col-md-4">
                                    <label>Laddle Dia </label>
                                    <input type="text" class="form-control" placeholder="Laddle Dia" id="laddle_diadry" name="laddle_diadry" value="<?php echo $laddle_diadry?>" style="border-color: #181f5a;color: black">
                                </div>
                                <div class="form-group col-md-4">
                                    <label>Laddle Height </label>
                                    <input type="text" class="form-control" placeholder="Laddle Height" id="laddle_heightdry" name="laddle_heightdry" value="<?php echo $laddle_heightdry?>" style="border-color: #181f5a;color: black">
                                </div>
                                <div class="form-group col-md-4" >
                                    <label>Former Dia </label>
                                    <input type="text" class="form-control" placeholder="Former Dia" id="former_diadry" name="former_diadry" value="<?php echo $former_diadry?>" style="border-color: #181f5a;color: black">
                                </div>
                                <div class="form-group col-md-4">
                                    <label>Former Height  </label>
                                    <input type="text" class="form-control" placeholder="Former Height" id="former_heightdry" name="former_heightdry" value="<?php echo $former_heightdry?>" style="border-color: #181f5a;color: black">
                                </div>
                                <div class="form-group col-md-4">
                                    <label>Product Used </label>
                                    <input type="text" class="form-control" placeholder="Product Used" id="product_useddry" name="product_useddry" value="<?php echo $product_useddry?>" style="border-color: #181f5a;color: black">
                                </div>
                                <div class="form-group col-md-4">
                                    <label>Batch No</label>
                                    <input type="text" class="form-control" placeholder="Batch No" id="batch_nodry" name="batch_nodry" value="<?php echo $batch_nodry?>" style="border-color: #181f5a;color: black">
                                </div>
                                <div class="form-group col-md-4">
                                    <label>Paper Used</label>
                                    <select name="material_typedry" id="material_typedry" class="form-control" value="<?php echo $material_typedry?>" style="border-color: #181f5a;color: black">
                                        <option value="Card Board">Card Board</option>
                                        <option value="Ceramic Paper">Ceramic Paper</option>
                                    </select>
                                </div>

                                <div class="form-group col-md-4">
                                    <label>Lining Start Time </label>
                                    <input type="time" class="form-control" placeholder="Pending Liquid Quantity" id="lining_start_timedry" name="lining_start_timedry" value="<?php echo $lining_start_timedry?>" style="border-color: #181f5a;color: black">
                                </div>
                                <div class="form-group col-md-4">
                                    <label>Former Removed Time </label>
                                    <input type="time" class="form-control" placeholder="Pending Liquid Quantity" id="former_remove_timedry" name="former_remove_timedry" value="<?php echo $former_remove_timedry?>" style="border-color: #181f5a;color: black">
                                </div>
                                <div class="form-group col-md-4">
                                    <label>Firing Time </label>
                                    <input type="time" class="form-control" placeholder="Pending Liquid Quantity" id="firing_timedry" name="firing_timedry" value="<?php echo $firing_timedry?>" style="border-color: #181f5a;color: black">
                                </div>
                                <div class="form-group col-md-4">
                                    <label>Lining End Time</label>
                                    <input type="time" class="form-control" placeholder="Total Weight" id="lining_end_timedry" name="lining_end_timedry" value="<?php echo $lining_end_timedry?>" style="border-color: #181f5a;color: black">
                                </div>
                                <div class="form-group col-md-4">
                                    <label>Wastage Quantity </label>
                                    <input type="text" class="form-control" placeholder="Wastage Quantity" id="wastagedry" name="wastagedry" value="<?php echo $waterdry?>" style="border-color: #181f5a;color: black">
                                </div>

                                <div class="form-group col-md-4">
                                    <label>Type </label>
                                    <input type="text" class="form-control" placeholder="Type" id="typedry" name="typedry" value="<?php echo $typedry?>" style="border-color: #181f5a;color: black">
                                </div>
                                <div class="form-group col-md-4">
                                    <label>Remarks </label>
                                    <input type="text" class="form-control" placeholder="Remarks" id="remarkdry" name="remarkdry" value="<?php echo $remarkdry?>" style="border-color: #181f5a;color: black">
                                </div>
                                <div class="form-group col-md-4">
                                    <label>Lining Thickness Bottom </label>
                                    <input type="number" class="form-control" placeholder="Lining Thickness Bottom" id="thickness_bottomdry" name="thickness_bottomdry" value="<?php echo $thickness_bottomdry?>" style="border-color: #181f5a;color: black">
                                </div>
                                <div class="form-group col-md-4">
                                    <label>Lining Thickness Side </label>
                                    <input type="number" class="form-control" placeholder="Lining Thickness Side" id="thickness_sidedry" name="thickness_sidedry" value="<?php echo $thickness_sidedry?>" style="border-color: #181f5a;color: black">
                                </div>
                                <div class="form-group col-md-4">
                                    <label>Total Weight</label>
                                    <input type="number" class="form-control" placeholder="Total Weight" id="total_weightdry" name="total_weightdry" value="<?php echo $total_weightdry?>" style="border-color: #181f5a;color: black">
                                </div>
                            </div>

                            <section class="review-section information">
                                <div class="review-header text-center">
                                    <h3 class="review-title">Bottom Layer</h3>
                                    <button onclick="dryB()" type="button" class="btn btn-success w-30">Create</button>
                                </div>
                                <div class="row" style="margin-top: 20px;padding: 15px;">
                                    <div class="col-md-12 col-sm-12">
                                        <div class="" id="dryB_div">
                                            <!-- Div are Insert Here-->
                                            <?php
                                            if($dryBCount > 0) {
                                                $sqldryB = "SELECT * FROM dry_lining_details WHERE dry_lining_id='$dry_lining_id' AND layer='bottom'";
                                                $resultdryB = mysqli_query($conn, $sqldryB);
                                                if (mysqli_num_rows($resultdryB)>0) {
                                                    $dryBCount_id = 0;
                                                    while($rowdryB = mysqli_fetch_assoc($resultdryB)) {
                                                        $dryBCount_id++;
                                                        $qty = $rowdryB['qty'];
                                                        $fork_start_time = $rowdryB['fork_start_time'];
                                                        $fork_close_time = $rowdryB['fork_close_time'];
                                                        ?>
                                                        <div class="row dryBInputs" id="<?php echo 'dryB_divRow_'.$dryBCount_id?>"><br>
                                                            <h2 class="dryB_divRow_heading" style="width:100%">Bottom Layer <?php echo $dryBCount_id?></h2>
                                                            <br>

                                                            <div class="col-md-4">
                                                                <div class="input-block mb-3">
                                                                    <label>QTY</label>
                                                                    <input type="text" class="form-control dryBAdd" id="<?php echo 'qty_'.$dryBCount_id?>" name="<?php echo 'qty_'.$dryBCount_id?>" value="<?php echo $qty?>" style="border-color: black;color: black">
                                                                </div>
                                                            </div>
                                                            <div class="col-md-4">
                                                                <div class="input-block mb-3">
                                                                    <label>FORK START TIME</label>
                                                                    <input type="time" class="form-control dryBAdd" id="<?php echo 'fork_start_time_'.$dryBCount_id?>" name="<?php echo 'fork_start_time_'.$dryBCount_id?>" value="<?php echo $fork_start_time?>" style="border-color: black;color: black">
                                                                </div>
                                                            </div>
                                                            <div class="col-md-4">
                                                                <div class="input-block mb-3">
                                                                    <label>FORK CLOSE TIME</label>
                                                                    <input type="time" class="form-control dryBAdd" id="<?php echo 'fork_close_time_'.$dryBCount_id?>" name="<?php echo 'fork_close_time_'.$dryBCount_id?>" value="<?php echo $fork_close_time?>" style="border-color: black;color: black">
                                                                </div>
                                                            </div>
                                                            <div class="col-md-4">
                                                                <div class="input-block mb-3">
                                                                    <button type="button" class="btn btn-danger w-30" onclick="removeEle('<?php echo 'dryB_divRow_'.$dryBCount_id?>','dryB')">Remove</button>
                                                                </div>

                                                            </div>
                                                        </div>
                                                        <?php
                                                    }
                                                }
                                            }

                                            ?>
                                        </div>
                                    </div>
                                </div>
                            </section>

                            <section class="review-section information">
                                <div class="review-header text-center">
                                    <h3 class="review-title" style="width:100%">Side Layer</h3>
                                    <button onclick="dryS()" type="button" class="btn btn-success w-30">Create</button>
                                </div>
                                <div class="row" style="margin-top: 20px;padding: 15px;">
                                    <div class="col-md-12 col-sm-12">
                                        <div class="" id="dryS_div">
                                            <!-- Div are Insert Here-->
                                            <?php
                                            if($drySCount > 0) {
                                                $sqldryS = "SELECT * FROM dry_lining_details WHERE dry_lining_id='$dry_lining_id' AND layer='side'";
                                                $resultdryS = mysqli_query($conn, $sqldryS);
                                                if (mysqli_num_rows($resultdryS)>0) {
                                                    $drySCount_id = 0;
                                                    while($rowdryS = mysqli_fetch_assoc($resultdryS)) {
                                                        $wetSCount_id++;
                                                        $qty = $rowdryS['qty'];
                                                        $dry_fork_start_time = $rowdryS['fork_start_time'];
                                                        $dry_fork_close_time = $rowdryS['fork_close_time'];
                                                        ?>
                                                        <div class="row drySInputs" id="<?php echo 'dryS_divRow_'.$drySCount_id?>"><br>
                                                            <h2 class="dryS_divRow_heading">Bottom Layer <?php echo $drySCount_id?></h2>
                                                            <br>

                                                            <div class="col-md-4">
                                                                <div class="input-block mb-3">
                                                                    <label>QTY</label>
                                                                    <input type="text" class="form-control drySAdd" id="<?php echo 'dryS_qty_'.$drySCount_id?>" name="<?php echo 'dryS_qty_'.$drySCount_id?>" value="<?php echo $qty?>" style="border-color: black;color: black">
                                                                </div>
                                                            </div>
                                                            <div class="col-md-4">
                                                                <div class="input-block mb-3">
                                                                    <label>FORK START TIME</label>
                                                                    <input type="time" class="form-control drySAdd" id="<?php echo 'dryS_fork_start_time'.$drySCount_id?>" name="<?php echo 'dryS_fork_start_time'.$drySCount_id?>" value="<?php echo $dry_fork_start_time?>" style="border-color: black;color: black">
                                                                </div>
                                                            </div>
                                                            <div class="col-md-4">
                                                                <div class="input-block mb-3">
                                                                    <label>FORK CLOSE TIME</label>
                                                                    <input type="time" class="form-control drySAdd" id="<?php echo 'dryS_fork_close_time'.$drySCount_id?>" name="<?php echo 'dryS_fork_close_time'.$drySCount_id?>" value="<?php echo $dry_fork_close_time?>" style="border-color: black;color: black">
                                                                </div>
                                                            </div>
                                                            <div class="col-md-4">
                                                                <div class="input-block mb-3">
                                                                    <button type="button" class="btn btn-danger w-30" onclick="removeEle('<?php echo 'dryS_divRow_'.$drySCount_id?>','dryS')">Remove</button>
                                                                </div>

                                                            </div>
                                                        </div>
                                                        <?php
                                                    }
                                                }
                                            }

                                            ?>
                                        </div>

                                    </div>
                                </div>
                            </section>


                            <div style="display: inline-block;">
                            </div>
                            <div style="margin-bottom: 25px;float: right;">
                                <button class="btn btn-primary" id="form_btn" type="button">Save Details</button>
                            </div>
                        </form>
                    </div>

                </div>
            </div>
        </div>
            <?php
        }
        ?>
        <?php
        if($service_type =='Erosion Analysis'){
        ?>
        <div class="col-lg-12">
            <div class="card">
                <div class="card-body">
                    <div class="col-lg-12">
                    </div>
                    <div class="basic-form" style="color: black;">
                        <form id="q1_form">
                            <div class="form-row">
                                <div class="form-group col-md-3">
                                    <label> Customer Names </label>
                                    <input type="text" class="form-control" placeholder="Customer Name" id="customer_er" name="customer_er" value="<?php echo $customer_er ?>" style="border-color: #181f5a;color: black;text-transform: uppercase">
                                    <input type="hidden" class="form-control"  id="apier" name="apier">
                                    <input type="hidden" class="form-control"  id="old_pa_id" name="old_pa_id">
                                    <input type="hidden" class="form-control"  id="furnace_ider" name="furnace_ider" value="<?php echo $erosion_id?>">
                                    <input type="hidden" class="form-control"  id="service_id" name="service_id" value="<?php echo $service_id?>">
                                    <input type="hidden" class="form-control"  id="service_type" name="service_type" value="<?php echo $service_type?>">
                                    <input type="hidden" class="form-control"  id="service_add" name="service_add" value="<?php echo $service_add?>">
                                </div>
                                <div class="form-group col-md-3">
                                    <label> Date </label>
                                    <input type="date" class="form-control"  id="dateer" name="dateer" placeholder="date" value="<?php echo $service_add?>" style="border-color: #181f5a;color: black;text-transform: uppercase">
                                </div>
                                <div class="form-group col-md-3">
                                    <label>Material Type</label>
                                    <select name="material_typeer" id="material_typeer" class="form-control" value="<?php echo $service_add?>" style="border-color: #181f5a;color: black">
                                        <option value="Cast Iron">Cast Iron</option>
                                        <option value="Steel">Steel</option>
                                    </select>
                                </div>
                                <div class="form-group col-md-3">
                                    <label> Location </label>
                                    <input type="text" class="form-control"  id="locationer" name="locationer" placeholder="Location" value="<?php echo $locationer?>" style="border-color: #181f5a;color: black;text-transform: uppercase">
                                </div>

                                <div class="form-group col-md-3">
                                    <label>Melting Supervisor Name </label>
                                    <input type="text" class="form-control" placeholder="Melting Supervisor Name" id="ms_nameer" name="ms_nameer" value="<?php echo $ms_nameer?>" style="border-color: #181f5a;color: black">
                                    <!--onkeyup="this.value = fnc(this.value, 0, 100)"-->
                                </div>
                                <div class="form-group col-md-3">
                                    <label>Supervisor Contact No </label>
                                    <input type="number" class="form-control" placeholder="Contact No" id="ms_mobileer" name="ms_mobileer" value="<?php echo $ms_mobileer?>" style="border-color: #181f5a;color: black">
                                </div>
                                <div class="form-group col-md-3">
                                    <label>Melting Manager Name </label>
                                    <input type="text" class="form-control" placeholder="Melting Manager Name" id="mm_nameer" name="mm_nameer" value="<?php echo $mm_nameer?>" style="border-color: #181f5a;color: black">
                                </div>
                                <div class="form-group col-md-3" >
                                    <label>Manager Contact No </label>
                                    <input type="number" class="form-control" placeholder="Contact No" id="mm_mobileer" name="mm_mobileer" value="<?php echo $mm_mobileer?>" style="border-color: #181f5a;color: black">
                                </div>
                                <div class="form-group col-md-3">
                                    <label>Monthly Production  </label>
                                    <input type="text" class="form-control" placeholder="Monthly Production " id="monthly_productioner" name="monthly_productioner" value="<?php echo $monthly_productioner?>" style="border-color: #181f5a;color: black">
                                    <!--   <textarea class="form-control" placeholder="Notes" id="notes" name="notes" rows="4" cols="50" style="border-color: #181f5a;color: black"></textarea>-->
                                </div>
                                <div class="form-group col-md-3">
                                    <label>Tapping Temperature </label>
                                    <input type="number" class="form-control" placeholder="Tapping Temperature" id="temper" name="temper" value="<?php echo $temper?>" style="border-color: #181f5a;color: black">
                                </div>
                                <div class="form-group col-md-3">
                                    <label>Power </label>
                                    <input type="number" class="form-control" placeholder="Power" id="powerer" name="powerer" value="<?php echo $powerer?>" style="border-color: #181f5a;color: black">
                                </div>
                                <div class="form-group col-md-3">
                                    <label>Capacity </label>
                                    <input type="number" class="form-control" placeholder="Capacity" id="capacityer" name="capacityer" value="<?php echo $capacityer?>" style="border-color: #181f5a;color: black">
                                </div>
                                <div class="form-group col-md-3">
                                    <label>SG </label>
                                    <input type="text" class="form-control" placeholder="SG" id="sger" name="sger" value="<?php echo $sger?>" style="border-color: #181f5a;color: black">
                                </div>
                                <div class="form-group col-md-3">
                                    <label>Grey </label>
                                    <input type="text" class="form-control" placeholder="Grey" id="greyer" name="greyer" value="<?php echo $greyer?>" style="border-color: #181f5a;color: black">
                                </div>
                                <div class="form-group col-md-3">
                                    <label>Batch No </label>
                                    <input type="number" class="form-control" placeholder="Batch No" id="batch_noer" name="batch_noer" value="<?php echo $batch_noer?>" style="border-color: #181f5a;color: black">
                                </div>

                                <div class="form-group col-md-3">
                                    <label>Type </label>
                                    <input type="text" class="form-control" placeholder="Type" id="typeer" name="typeer" value="<?php echo $typeer?>" style="border-color: #181f5a;color: black">
                                </div>
<!--                                <div class="form-group col-md-4">-->
<!--                                    <label>Remarks </label>-->
<!--                                    <input type="text" class="form-control" placeholder="Remarks" id="remark" name="remark"  style="border-color: #181f5a;color: black">-->
<!--                                </div>-->
                                <div class="form-group col-md-3">
                                    <label>Material Used </label>
                                    <input type="text" class="form-control" placeholder="Material Used" id="materialer" name="materialer" value="<?php echo $materialer?>" style="border-color: #181f5a;color: black">
                                </div>
                                <div class="form-group col-md-3">
                                    <label>Bricks Details </label>
                                    <input type="text" class="form-control" placeholder="Bricks Details" id="brickser" name="brickser" value="<?php echo $brickser?>" style="border-color: #181f5a;color: black">
                                </div>
                                <div class="form-group col-md-3">
                                    <label>Competiter</label>
                                    <input type="text" class="form-control" placeholder="Competiter" id="competiterer" name="competiterer" value="<?php echo $competiterer?>" style="border-color: #181f5a;color: black">
                                </div>
                                <div class="form-group col-md-3">
                                    <label>Lining Dia(D1 & C1)</label>
                                    <input type="text" class="form-control" placeholder="Lining Dia (D1 & C1)" id="d1_c1" name="d1_c1" value="<?php echo $d1_c1?>" style="border-color: #181f5a;color: black">
                                </div>
                                <div class="form-group col-md-3">
                                    <label>Lining Dia(D2 & C2)</label>
                                    <input type="text" class="form-control" placeholder="Lining Dia (D2 & C2)" id="d2_c2" name="d2_c2" value="<?php echo $d2_c2?>" style="border-color: #181f5a;color: black">
                                </div>
                                <div class="form-group col-md-3">
                                    <label>Lining Dia(D3 & C3)</label>
                                    <input type="text" class="form-control" placeholder="Lining Dia (D3 & C3)" id="d3_c3" name="d3_c3" value="<?php echo $d3_c3?>" style="border-color: #181f5a;color: black">
                                </div>
                                <div class="form-group col-md-3">
                                    <label>Lining Height(H1 & H2) </label>
                                    <input type="text" class="form-control" placeholder="Lining Height (H1 & H2)" id="h1_h2" name="h1_h2" value="<?php echo $h1_h2?>" style="border-color: #181f5a;color: black">
                                </div>
                                <div class="form-group col-md-3">
                                    <label>NO.OF.HEATS GONE</label>
                                    <input type="text" class="form-control" placeholder="NO.OF.HEATS GONE" id="heat_gone" name="heat_gone" value="<?php echo $heat_gone?>" style="border-color: #181f5a;color: black">
                                </div>
                                <div class="form-group col-md-3">
                                    <label>Aft Lining Dia(D1 & C1)</label>
                                    <input type="text" class="form-control" placeholder="Lining Dia (D1 & C1)" id="Ad1_Ac1" name="Ad1_Ac1" value="<?php echo $Ad1_Ac1?>" style="border-color: #181f5a;color: black">
                                </div>
                                <div class="form-group col-md-3">
                                    <label>Aft Lining Dia(D2 & C2)</label>
                                    <input type="text" class="form-control" placeholder="Lining Dia (D2 & C2)" id="Ad2_Ac2" name="Ad2_Ac2" value="<?php echo $Ad2_Ac2?>" style="border-color: #181f5a;color: black">
                                </div>
                                <div class="form-group col-md-3">
                                    <label>Aft Lining Dia(D3 & C3)</label>
                                    <input type="text" class="form-control" placeholder="Lining Dia (D3 & C3)" id="Ad3_Ac3" name="Ad3_Ac3" value="<?php echo $Ad3_Ac3?>" style="border-color: #181f5a;color: black">
                                </div>
                                <div class="form-group col-md-3">
                                    <label>Aft Lining Height(H1 & H2)</label>
                                    <input type="text" class="form-control" placeholder="Lining Height (H1 & H2)" id="Ah1_h2" name="Ah1_h2" value="<?php echo $Ah1_h2?>" style="border-color: #181f5a;color: black">
                                </div>
                            </div>

                            <section class="review-section information">
                                <div class="review-header text-center">
                                    <h3 class="review-title">Bottom Layer</h3>
                                    <button onclick="erL()" type="button" class="btn btn-success w-30">Create</button>
                                </div>
                                <div class="row" style="margin-top: 20px;padding: 15px;">
                                    <div class="col-md-12 col-sm-12">
                                        <div class="" id="erL_div">
                                            <!-- Div are Insert Here-->
                                            <?php
                                            if($erLCount > 0) {
                                                $sqlerL = "SELECT * FROM erosion_details WHERE erosion_id='$erosion_id' AND erosion_type='laddle'";
                                                $resulterL = mysqli_query($conn, $sqlerL);
                                                if (mysqli_num_rows($resulterL)>0) {
                                                    $erLCount_id = 0;
                                                    while($rowerL = mysqli_fetch_assoc($resulterL)) {
                                                        $erLCount_id++;
                                                        $lcapacity = $rowerL['lcapacity'];
                                                        $heat_undergone = $rowerL['heat_undergone'];
                                                        $no_of_patching = $rowerL['no_of_patching'];
                                                        $erosion_factor = $rowerL['erosion_factor'];
                                                        $material_consumption = $rowerL['material_consumption'];
                                                        $dimension_after_patching = $rowerL['dimension_after_patching'];
                                                        ?>
                                                        <div class="row erLInputs" id="<?php echo 'erL_divRow_'.$erLCount_id?>"><br>
                                                            <h2 class="erL_divRow_heading" style="width:100%">Bottom Layer  <?php echo $erLCount_id?></h2>
                                                            <br>

                                                            <div class="col-md-4">
                                                                <div class="input-block mb-3">
                                                                    <label>LCAPACITY</label>
                                                                    <input type="text" class="form-control erLAdd" id="<?php echo 'lcapacity_'.$erLCount_id?>" name="<?php echo 'lcapacity_'.$erLCount_id?>" value="<?php echo $lcapacity?>" style="border-color: black;color: black">
                                                                </div>
                                                            </div>
                                                            <div class="col-md-4">
                                                                <div class="input-block mb-3">
                                                                    <label>HEAT UNDERGONE</label>
                                                                    <input type="text" class="form-control erLAdd" id="<?php echo 'heat_undergone_'.$erLCount_id?>" name="<?php echo 'heat_undergone_'.$erLCount_id?>" value="<?php echo $heat_undergone?>" style="border-color: black;color: black">
                                                                </div>
                                                            </div>
                                                            <div class="col-md-4">
                                                                <div class="input-block mb-3">
                                                                    <label>NO OF PATCHING</label>
                                                                    <input type="text" class="form-control erLAdd" id="<?php echo 'no_of_patching_'.$erLCount_id?>" name="<?php echo 'no_of_patching_'.$erLCount_id?>" value="<?php echo $no_of_patching?>" style="border-color: black;color: black">
                                                                </div>
                                                            </div>
                                                            <div class="col-md-4">
                                                                <div class="input-block mb-3">
                                                                    <label>EROSION FACTOR</label>
                                                                    <input type="text" class="form-control erLAdd" id="<?php echo 'erosion_factor_'.$erLCount_id?>" name="<?php echo 'erosion_factor_'.$erLCount_id?>" value="<?php echo $erosion_factor?>" style="border-color: black;color: black">
                                                                </div>
                                                            </div>
                                                            <div class="col-md-4">
                                                                <div class="input-block mb-3">
                                                                    <label>MATERIAL CONSUMPTION</label>
                                                                    <input type="text" class="form-control erLAdd" id="<?php echo 'material_consumption_'.$erLCount_id?>" name="<?php echo 'material_consumption_'.$erLCount_id?>" value="<?php echo $material_consumption?>" style="border-color: black;color: black">
                                                                </div>
                                                            </div>
                                                            <div class="col-md-4">
                                                                <div class="input-block mb-3">
                                                                    <label>DIMENSION AFTER PATCHING</label>
                                                                    <input type="text" class="form-control erLAdd" id="<?php echo 'dimension_after_patching_'.$erLCount_id?>" name="<?php echo 'dimension_after_patching_'.$erLCount_id?>" value="<?php echo $dimension_after_patching?>" style="border-color: black;color: black">
                                                                </div>
                                                            </div>
                                                            <div class="col-md-4">
                                                                <div class="input-block mb-3">
                                                                    <button type="button" class="btn btn-danger w-30" onclick="removeEle('<?php echo 'erL_divRow_'.$erLCount_id?>','erL')">Remove</button>
                                                                </div>

                                                            </div>
                                                        </div>
                                                        <?php
                                                    }
                                                }
                                            }

                                            ?>
                                        </div>
                                    </div>
                                </div>
                            </section>

                            <section class="review-section information">
                                <div class="review-header text-center">
                                    <h3 class="review-title">Side Layer</h3>
                                    <button onclick="erF()" type="button" class="btn btn-success w-30">Create</button>
                                </div>
                                <div class="row" style="margin-top: 20px;padding: 15px;">
                                    <div class="col-md-12 col-sm-12">
                                        <div class="" id="erF_div">
                                            <?php
                                            if($erFCount > 0) {
                                                $sqlerF = "SELECT * FROM erosion_details WHERE erosion_id='$erosion_id' AND erosion_type='furnace'";
                                                $resulterF = mysqli_query($conn, $sqlerF);
                                                if (mysqli_num_rows($resulterF)>0) {
                                                    $erFCount_id = 0;
                                                    while($rowerF = mysqli_fetch_assoc($resulterF)) {
                                                        $erFCount_id++;
                                                        $lcapacityF = $rowerF['lcapacity'];
                                                        $heat_undergoneF = $rowerF['heat_undergone'];
                                                        $no_of_patchingF = $rowerF['no_of_patching'];
                                                        $erosion_factorF = $rowerF['erosion_factor'];
                                                        $material_consumptionF = $rowerF['material_consumption'];
                                                        $dimension_after_patchingF = $rowerF['dimension_after_patching'];
                                                        ?>
                                                        <div class="row erFInputs" id="<?php echo 'erF_divRow_'.$erFCount_id?>"><br>
                                                            <h2 class="erF_divRow_heading" style="width:100%">Side Layer  <?php echo $erFCount_id?></h2>
                                                            <br>

                                                            <div class="col-md-4">
                                                                <div class="input-block mb-3">
                                                                    <label>LCAPACITY</label>
                                                                    <input type="text" class="form-control erFAdd" id="<?php echo 'erF_lcapacity_'.$erFCount_id?>" name="<?php echo 'erF_lcapacity_'.$erFCount_id?>" value="<?php echo $lcapacityF?>" style="border-color: black;color: black">
                                                                </div>
                                                            </div>
                                                            <div class="col-md-4">
                                                                <div class="input-block mb-3">
                                                                    <label>HEAT UNDERGONE</label>
                                                                    <input type="text" class="form-control erFAdd" id="<?php echo 'erF_heat_undergone_'.$erFCount_id?>" name="<?php echo 'erF_heat_undergone_'.$erFCount_id?>" value="<?php echo $heat_undergoneF?>" style="border-color: black;color: black">
                                                                </div>
                                                            </div>
                                                            <div class="col-md-4">
                                                                <div class="input-block mb-3">
                                                                    <label>NO OF PATCHING</label>
                                                                    <input type="text" class="form-control erFAdd" id="<?php echo 'erF_no_of_patching_'.$erFCount_id?>" name="<?php echo 'erF_no_of_patching_'.$erFCount_id?>" value="<?php echo $no_of_patchingF?>" style="border-color: black;color: black">
                                                                </div>
                                                            </div>
                                                            <div class="col-md-4">
                                                                <div class="input-block mb-3">
                                                                    <label>EROSION FACTOR</label>
                                                                    <input type="text" class="form-control erFAdd" id="<?php echo 'erF_erosion_factor_'.$erFCount_id?>" name="<?php echo 'erF_erosion_factor_'.$erFCount_id?>" value="<?php echo $erosion_factorF?>" style="border-color: black;color: black">
                                                                </div>
                                                            </div>
                                                            <div class="col-md-4">
                                                                <div class="input-block mb-3">
                                                                    <label>MATERIAL CONSUMPTION</label>
                                                                    <input type="text" class="form-control erFAdd" id="<?php echo 'erF_material_consumption_'.$erFCount_id?>" name="<?php echo 'erF_material_consumption_'.$erFCount_id?>" value="<?php echo $material_consumptionF?>" style="border-color: black;color: black">
                                                                </div>
                                                            </div>
                                                            <div class="col-md-4">
                                                                <div class="input-block mb-3">
                                                                    <label>DIMENSION AFTER PATCHING</label>
                                                                    <input type="text" class="form-control erFAdd" id="<?php echo 'erF_dimension_after_patching_'.$erFCount_id?>" name="<?php echo 'erF_dimension_after_patching_'.$erFCount_id?>" value="<?php echo $dimension_after_patchingF?>" style="border-color: black;color: black">
                                                                </div>
                                                            </div>
                                                            <div class="col-md-4">
                                                                <div class="input-block mb-3">
                                                                    <button type="button" class="btn btn-danger w-30" onclick="removeEle('<?php echo 'erF_divRow_'.$erFCount_id?>','erF')">Remove</button>
                                                                </div>

                                                            </div>
                                                        </div>
                                                        <?php
                                                    }
                                                }
                                            }

                                            ?>
                                        </div>

                                    </div>
                                </div>
                            </section>


                            <div style="display: inline-block;">
                            </div>
                            <div style="margin-bottom: 25px;float: right;">
                                <button class="btn btn-primary" id="form_btn" type="button">Save Details</button>
                            </div>
                        </form>
                    </div>

                </div>
            </div>
        </div>
            <?php
        }
        ?>
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

<script src="../vendor/select2/js/select2.full.min.js"></script>
<script src="../js/plugins-init/select2-init.js"></script>

<!--<script src="../assets/js/jquery-3.7.0.min.js"></script>-->
<!---->
<!--<script src="../assets/js/bootstrap.bundle.min.js"></script>-->
<!---->
<!--<script src="../assets/js/jquery.slimscroll.min.js"></script>-->
<!---->
<!--<script src="../assets/js/select2.min.js"></script>-->
<!---->
<!--<script src="../assets/js/jquery.dataTables.min.js"></script>-->
<!--<script src="../assets/js/dataTables.bootstrap4.min.js"></script>-->
<!---->
<!--<script src="../assets/js/moment.min.js"></script>-->
<!--<script src="../assets/js/bootstrap-datetimepicker.min.js"></script>-->
<!---->
<!--<script src="../assets/js/layout.js"></script>-->
<!--<script src="../assets/js/theme-settings.js"></script>-->
<!--<script src="../assets/js/greedynav.js"></script>-->
<!---->
<!--<script src="../assets/js/app.js"></script>-->

<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.20.0/jquery.validate.min.js" integrity="sha512-WMEKGZ7L5LWgaPeJtw9MBM4i5w5OSBlSjTjCtSnvFJGSVD26gE5+Td12qN5pvWXhuWaWcVwF++F7aqu9cvqP0A==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>


<script>

    //to validate form
    $("#q1_form").validate(
        {
            ignore: '.ignore',
            // Specify validation rules
            rules: {
                customerName: {
                    required: true
                },
            },
            // Specify validation error messages
            messages: {
                customerName: "*This field is required",

            }
            // Make sure the form is submitted to the destination defined
        });
    //add data
    $('#form_btn').click(function () {


        $("#q1_form").valid();

        if($("#q1_form").valid()==true) {
            //furnace &laddle
            let inputArr = [];
            let inputArrhl = [];
            let personalLoan = {};
            let personalLoanAr = [];
            let homeLoan = {};
            let homeLoanAr = [];

            const personalLoanInputsS = document.getElementsByClassName("personalLoanInputs");
            const homeLoanInputsS = document.getElementsByClassName("homeLoanInputs");
            // personalLoan_divRow_
            for(let a=0;a<personalLoanInputsS.length;a++){
                console.log(personalLoanInputsS[a]);
                inputArr.push(personalLoanInputsS[a].id);
            }
            for(let hla=0;hla<homeLoanInputsS.length;hla++){
                console.log(homeLoanInputsS[hla]);
                inputArrhl.push(homeLoanInputsS[hla].id);
            }
            console.log(inputArr);

            for(let b=0;b<inputArr.length;b++){
                // console.log(b);
                let divElem = document.getElementById(inputArr[b]);
                let inputElements = divElem.querySelectorAll(".plAdd");
                let eleValue = [];
                let eleValueStr = "";

                for(let c=0;c<inputElements.length;c++){
                    // console.log(c);
                    eleValue.push(inputElements[c].value);
                    // if(c == 7 || c == 8){
                    //     eleValueStr+=inputElements[c].id+'%';
                    // }else {
                        eleValueStr+=inputElements[c].value+'%';
                    // }

                }

                let keyNa = 'pl'+(b+1);
                personalLoan[keyNa] = eleValue;
                personalLoanAr.push(eleValueStr);

            }

            for(let hlb=0;hlb<inputArrhl.length;hlb++){
                // console.log(b);
                let divElem = document.getElementById(inputArrhl[hlb]);
                let inputElements = divElem.querySelectorAll(".hlAdd");
                let eleValue = [];
                let eleValueStr = "";

                for(let hlc=0;hlc<inputElements.length;hlc++){
                    // console.log(c);
                    eleValue.push(inputElements[hlc].value);
                    // eleValueStr+=inputElements[hlc].value+'%';

                    // if(hlc == 7 || hlc == 8){
                        // eleValueStr+=inputElements[hlc].id+'%';
                    // }else {
                        eleValueStr+=inputElements[hlc].value+'%';
                    // }

                }


                let keyNa = 'hl'+(hlb+1);
                homeLoan[keyNa] = eleValue;
                homeLoanAr.push(eleValueStr);

            }
            console.log(personalLoan);

            //wet lining
            let inputArrwetB = [];
            let inputArrwetS = [];
            let wetB = {};
            let wetBAr = [];
            let wetS = {};
            let wetSAr = [];

            const wetBInputsS = document.getElementsByClassName("wetBInputs");
            const wetSInputsS = document.getElementsByClassName("wetSInputs");

            // personalLoan_divRow_
            for(let wb=0;wb<wetBInputsS.length;wb++){
                console.log(wetBInputsS[wb]);
                inputArrwetB.push(wetBInputsS[wb].id);
            }
            for(let ws=0;ws<wetSInputsS.length;ws++){
                console.log(wetSInputsS[ws]);
                inputArrwetS.push(wetSInputsS[ws].id);
            }
            console.log(inputArr);

            for(let wbb=0;wbb<inputArrwetB.length;wbb++){
                // console.log(b);
                let divElem = document.getElementById(inputArrwetB[wbb]);
                let inputElements = divElem.querySelectorAll(".wetBAdd");
                let eleValue = [];
                let eleValueStr = "";

                for(let wbc=0;wbc<inputElements.length;wbc++){
                    // console.log(c);
                    eleValue.push(inputElements[wbc].value);
                    // if(c == 7 || c == 8){
                    //     eleValueStr+=inputElements[c].id+'%';
                    // }else {
                    eleValueStr+=inputElements[wbc].value+'%';
                    // }
                }
                let keyNa = 'wetB'+(wbb+1);
                wetB[keyNa] = eleValue;
              wetBAr.push(eleValueStr);
            }

            for(let wsb=0;wsb<inputArrwetS.length;wsb++){
                // console.log(b);
                let divElem = document.getElementById(inputArrwetS[wsb]);
                let inputElements = divElem.querySelectorAll(".wetSAdd");
                let eleValue = [];
                let eleValueStr = "";

                for(let wsc=0;wsc<inputElements.length;wsc++){
                    // console.log(c);
                    eleValue.push(inputElements[wsc].value);
                    // eleValueStr+=inputElements[hlc].value+'%';

                    // if(hlc == 7 || hlc == 8){
                    // eleValueStr+=inputElements[hlc].id+'%';
                    // }else {
                    eleValueStr+=inputElements[wsc].value+'%';
                    // }
                }

                let keyNa = 'wetS'+(wsb+1);
                wetS[keyNa] = eleValue;
                wetSAr.push(eleValueStr);
            }
            console.log(wetB);

            //Dry lining
            let inputArrdryB = [];
            let inputArrdryS = [];
            let dryB = {};
            let dryBAr = [];
            let dryS = {};
            let drySAr = [];

            const dryBInputsS = document.getElementsByClassName("dryBInputs");
            const drySInputsS = document.getElementsByClassName("drySInputs");

            // personalLoan_divRow_
            for(let db=0;db<dryBInputsS.length;db++){
                console.log(dryBInputsS[db]);
                inputArrdryB.push(dryBInputsS[db].id);
            }
            for(let ds=0;ds<drySInputsS.length;ds++){
                console.log(drySInputsS[ds]);
                inputArrdryS.push(drySInputsS[ds].id);
            }
            console.log(inputArr);

            for(let dbb=0;dbb<inputArrdryB.length;dbb++){
                // console.log(b);
                let divElem = document.getElementById(inputArrdryB[dbb]);
                let inputElements = divElem.querySelectorAll(".dryBAdd");
                let eleValue = [];
                let eleValueStr = "";

                for(let dbc=0;dbc<inputElements.length;dbc++){
                    // console.log(c);
                    eleValue.push(inputElements[dbc].value);
                    // if(c == 7 || c == 8){
                    //     eleValueStr+=inputElements[c].id+'%';
                    // }else {
                    eleValueStr+=inputElements[dbc].value+'%';
                    // }
                }
                let keyNa = 'dryB'+(dbb+1);
                dryB[keyNa] = eleValue;
                dryBAr.push(eleValueStr);
            }

            for(let dsb=0;dsb<inputArrdryS.length;dsb++){
                // console.log(b);
                let divElem = document.getElementById(inputArrdryS[dsb]);
                let inputElements = divElem.querySelectorAll(".drySAdd");
                let eleValue = [];
                let eleValueStr = "";

                for(let dsc=0;dsc<inputElements.length;dsc++){
                    // console.log(c);
                    eleValue.push(inputElements[dsc].value);
                    // eleValueStr+=inputElements[hlc].value+'%';

                    // if(hlc == 7 || hlc == 8){
                    // eleValueStr+=inputElements[hlc].id+'%';
                    // }else {
                    eleValueStr+=inputElements[dsc].value+'%';
                    // }
                }

                let keyNa = 'dryS'+(dsb+1);
                dryS[keyNa] = eleValue;
                drySAr.push(eleValueStr);
            }
            console.log(dryB);

            //Erosion
            let inputArrerL = [];
            let inputArrerF = [];
            let erL = {};
            let erLAr = [];
            let erF = {};
            let erFAr = [];

            const erLInputsS = document.getElementsByClassName("erLInputs");
            const erFInputsS = document.getElementsByClassName("erFInputs");
            // personalLoan_divRow_
            for(let erLa=0;erLa<erLInputsS.length;erLa++){
                console.log(erLInputsS[erLa]);
                inputArrerL.push(erLInputsS[erLa].id);
            }
            for(let erFa=0;erFa<erFInputsS.length;erFa++){
                console.log(erFInputsS[erFa]);
                inputArrerF.push(erFInputsS[erFa].id);
            }
            console.log(inputArr);

            for(let erLb=0;erLb<inputArrerL.length;erLb++){
                // console.log(b);
                let divElem = document.getElementById(inputArrerL[erLb]);
                let inputElements = divElem.querySelectorAll(".erLAdd");
                let eleValue = [];
                let eleValueStr = "";

                for(let erLc=0;erLc<inputElements.length;erLc++){
                    // console.log(c);
                    eleValue.push(inputElements[erLc].value);
                    // if(c == 7 || c == 8){
                    //     eleValueStr+=inputElements[c].id+'%';
                    // }else {
                    eleValueStr+=inputElements[erLc].value+'%';
                    // }

                }

                let keyNa = 'erL'+(erLb+1);
                erL[keyNa] = eleValue;
                erLAr.push(eleValueStr);

            }

            for(let erFb=0;erFb<inputArrerF.length;erFb++){
                // console.log(b);
                let divElem = document.getElementById(inputArrerF[erFb]);
                let inputElements = divElem.querySelectorAll(".erFAdd");
                let eleValue = [];
                let eleValueStr = "";

                for(let erFc=0;erFc<inputElements.length;erFc++){
                    // console.log(c);
                    eleValue.push(inputElements[erFc].value);
                    // eleValueStr+=inputElements[hlc].value+'%';

                    // if(hlc == 7 || hlc == 8){
                    // eleValueStr+=inputElements[hlc].id+'%';
                    // }else {
                    eleValueStr+=inputElements[erFc].value+'%';
                    // }

                }


                let keyNa = 'erF'+(erFb+1);
                erF[keyNa] = eleValue;
                erFAr.push(eleValueStr);

            }
            console.log(erF);

            var form = $("#q1_form");
            var formData = new FormData(form[0]);

            // formData.append('personalLoan',JSON.stringify(personalLoan));
            formData.append('personalLoan',personalLoanAr);
            formData.append('homeLoan',homeLoanAr);

            formData.append('wetB',wetBAr);
            formData.append('wetS',wetSAr);

            formData.append('dryB',dryBAr);
            formData.append('dryS',drySAr);
            //
            formData.append('erL',erLAr);
            formData.append('erF',erFAr);
            //formData.append('personalLoan',personalLoan);

            this.disabled = true;
            this.innerHTML = '<i class="fa fa-spinner fa-spin"></i>';


            Swal.fire({
                title: "Update",
                text: "Are you sure want to Update the record?",
                icon: "warning",
                buttons: true,
                dangerMode: true,
                allowOutsideClick: false,
                allowEscapeKey: false,
                closeOnClickOutside: false,
                showCancelButton: true,

            })
                .then((value) => {

                    if (value.isConfirmed) {


                        $.ajax({

                            type: "POST",
                            url: 'furnace_api.php',
                            async: false,
                            data: formData,
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

                                            document.getElementById("form_btn").disabled = false;
                                            document.getElementById("form_btn").innerHTML = 'Add';
                                        });

                                }
                            },
                            error: function () {

                                Swal.fire('Check Your Network!');
                                document.getElementById("form_btn").disabled = false;
                                document.getElementById("form_btn").innerHTML = 'Add';
                            }

                        });
                    }


                });




        } else {
            document.getElementById("form_btn").disabled = false;
            document.getElementById("form_btn").innerHTML = 'Add';

        }

    });


    var loadFile = function(event) {
        var image = document.getElementById('output');
        image.src = URL.createObjectURL(event.target.files[0]);
    };


    // register jQuery extension
    jQuery.extend(jQuery.expr[':'], {
        focusable: function (el, index, selector) {
            return $(el).is('a, button, :input, [tabindex]');
        }
    });

    $(document).on('keypress', 'input,select', function (e) {
        if (e.which == 13) {
            e.preventDefault();
            // Get all focusable elements on the page
            var $canfocus = $(':focusable');
            var index = $canfocus.index(document.activeElement) + 1;
            if (index >= $canfocus.length) index = 0;
            $canfocus.eq(index).focus();
        }
    });

    //Furnance & Vibrator
    //var personalLoanCount = <?php //echo $plCount?>// + 1;
    var personalLoanCount = <?php echo $plCount?>;
    if(personalLoanCount == 0){
        personalLoanCount = 1;
    }
    var personalLoanCounts = <?php echo $plCount?> + 1;


    var homeLoanCount = <?php echo $hlCount?>;
    if(homeLoanCount == 0){
        homeLoanCount = 1;
    }
    var homeLoanCounts = <?php echo $hlCount?> + 1;


    function addPL() {
        const headingClassCheck = document.getElementsByClassName("personalLoan_divRow_heading");
        if (headingClassCheck.length > 0) {
            personalLoanCount = personalLoanCount + 1;
        }

        var divRow = document.createElement("div");
        divRow.classList.add("row", "personalLoanInputs");
        divRow.setAttribute("id", 'personalLoan_divRow_' + personalLoanCounts);

        let heading2 = document.createElement("h2");
        heading2.innerHTML = "Bottom Layer " + personalLoanCount;
        heading2.classList.add("personalLoan_divRow_heading", "col-12"); // Added col-12 class for full width

        divRow.append(heading2);

        // Create a line break after the heading
        let lineBreak = document.createElement("br");
        divRow.append(lineBreak);

        let labelArr = ["pressure_", "qty_","fork_start_time_","fork_close_time_","vibrator_start_time_","vibrator_close_time_"];
        let placeholders = ["Pressure", "Qty","Fork Start Time","Fork Total Time","Vibrator Start Time","Vibrator Close Time"];

        for (let i = 0; i < labelArr.length; i++) {
            let divcol = document.createElement("div");
            divcol.classList.add("col-md-4");

            let divInput = document.createElement("div");
            divInput.classList.add("form-group"); // Add form-group class for proper alignment

            let textL = labelArr[i];
            // let resultTxts = textL.replaceAll("hl", "");
            let resultTxt = textL.replaceAll("_", " ");

            let formLabel = document.createElement("label");
            formLabel.innerHTML = resultTxt.toUpperCase();

            let formInput = document.createElement("input");
            formInput.classList.add("form-control", "plAdd");
            formInput.setAttribute("id", labelArr[i] + personalLoanCount);
            // formInput.setAttribute("type", labelArr[i] === "qty_" ? "number" : "time");
            if (labelArr[i] === "pressure_" || labelArr[i] === "total_weight_") {
                formInput.setAttribute("type", "text");
            } else {
                formInput.setAttribute("type", labelArr[i] === "qty_" ? "number" : "time");
            }
            if(labelArr[i] === "pressure_"){
                formInput.setAttribute("value", "4.5-6 PSI")
            }

            formInput.setAttribute("name", labelArr[i] + personalLoanCount);
            formInput.setAttribute("placeholder", placeholders[i]);
            formInput.style.color = "black";
            // Add border color styling to the input fields
            formInput.style.borderColor = "black";

            divInput.append(formLabel);
            divInput.append(formInput);
            divcol.append(divInput);
            divRow.append(divcol);
        }

        let divcol = document.createElement("div");
        divcol.classList.add("col-md-4");

        let divInput = document.createElement("div");
        divInput.classList.add("form-group"); // Add form-group class for proper alignment

        let btnRe = document.createElement("button");
        btnRe.innerHTML = "Remove";
        btnRe.classList.add("btn", "btn-danger", "w-30");
        btnRe.setAttribute("onclick", "removeEle('personalLoan_divRow_" + personalLoanCounts + "','pl')");
        btnRe.setAttribute("type", "button");
        btnRe.style.marginTop = "30px";
        divInput.append(btnRe);
        divcol.append(divInput);
        divRow.append(divcol);

        personalLoanCounts++;

        document.getElementById("personalLoan_div").append(divRow);
    }

    function addHL(){

        const headingClassCheck = document.getElementsByClassName("homeLoan_divRow_heading");
        if(headingClassCheck.length > 0){
            homeLoanCount = homeLoanCount+1;
            // personalLoanCount = personalLoanCount+headingClassCheck.length;
        }

        var divRow = document.createElement("div");
        divRow.classList.add("row","homeLoanInputs");
        divRow.setAttribute("id",'homeLoan_divRow_'+homeLoanCounts);

        let heading2 = document.createElement("h2");
        heading2.innerHTML = "Side Layer "+ homeLoanCount;
        heading2.classList.add("homeLoan_divRow_heading", "col-12"); // Added col-12 class for full width
        divRow.append(heading2);

        let labelArr = ["sl_pressure_", "sl_qty_","sl_fork_start_time","sl_fork_close_time","sl_vibrator_start_time","sl_vibrator_close_time"];
        let placeholders = ["Pressure", "Qty","Fork Start Time","Fork Close Time","Vibrator Start Time","Vibrator Close Time"];
        for(let i = 0;i<labelArr.length;i++){

            let divcol = document.createElement("div");
            divcol.classList.add("col-md-4");

            let divInput = document.createElement("div");
            divInput.classList.add("input-block", "mb-3");

            let textL = labelArr[i];
            let resultTxts = textL.replaceAll("sl", "");
            let resultTxt = resultTxts.replaceAll("_", " ");


            let formLabel = document.createElement("label");
            formLabel.innerHTML = resultTxt.toUpperCase();


            let formInput = document.createElement("input");
            formInput.classList.add("form-control","hlAdd");
            formInput.setAttribute("id",labelArr[i]+homeLoanCounts);
            // formInput.setAttribute("type", labelArr[i] === "sl_qty_" ? "number" : "time");
            if (labelArr[i] === "sl_pressure_") {
                formInput.setAttribute("type", "text");
            } else {
                formInput.setAttribute("type", labelArr[i] === "sl_qty_" ? "number" : "time");
            }
            if(labelArr[i] === "sl_pressure_"){
                formInput.setAttribute("value", "4.5-6 PSI")
            }
            formInput.setAttribute("name",labelArr[i]+homeLoanCounts);
            formInput.setAttribute("placeholder", placeholders[i]);
            formInput.style.color = "black";
            // Add border color styling to the input fields
            formInput.style.borderColor = "black";

            divInput.append(formLabel);
            divInput.append(formInput);
            divcol.append(divInput);
            divRow.append(divcol);
        }
        let divcol = document.createElement("div");
        divcol.classList.add("col-md-4");

        let divInput = document.createElement("div");
        divInput.classList.add("input-block", "mb-3");

        let btnRe = document.createElement("button");
        btnRe.innerHTML = "Remove";
        btnRe.classList.add("btn","btn-danger","w-30");
        btnRe.setAttribute("onclick","removeEle('homeLoan_divRow_"+homeLoanCounts+"','hl')");
        btnRe.setAttribute("type","button");

        divcol.append(btnRe);
        divRow.append(divcol);

        homeLoanCounts++;
        // personalLoanCount++;
        document.getElementById("homeLoan_div").append(divRow);

    }

    function removeEle(eleId,loanType) {
        document.getElementById(eleId).remove();

        if(loanType == "pl"){
            const headingClass = document.getElementsByClassName("personalLoan_divRow_heading");

            for(let i=0;i<headingClass.length;i++){
                headingClass[i].innerHTML = "Bottom Layer "+(i+1);
                personalLoanCount = i+1;
            }
        }

        if(loanType == "hl"){
            const headingClass = document.getElementsByClassName("homeLoan_divRow_heading");

            for(let i=0;i<headingClass.length;i++){
                headingClass[i].innerHTML = "Side Layer "+(i+1);
                homeLoanCount = i+1;
            }
        }

        if(loanType == "cl"){
            const headingClass = document.getElementsByClassName("cardLoan_divRow_heading");

            for(let i=0;i<headingClass.length;i++){
                headingClass[i].innerHTML = " "+(i+1);
                cardLoanCount = i+1;
            }
        }


        if(loanType == "appl"){
            const headingClass = document.getElementsByClassName("appLoan_divRow_heading");

            for(let i=0;i<headingClass.length;i++){
                headingClass[i].innerHTML = "App Loan "+(i+1);
                appLoanCount = i+1;
            }
        }


        if(loanType == "gl"){
            const headingClass = document.getElementsByClassName("goldLoan_divRow_heading");

            for(let i=0;i<headingClass.length;i++){
                headingClass[i].innerHTML = "Gold Loan "+(i+1);
                goldLoanCount = i+1;
            }
        }


        if(loanType == "al"){
            const headingClass = document.getElementsByClassName("autoLoan_divRow_heading");

            for(let i=0;i<headingClass.length;i++){
                headingClass[i].innerHTML = "Auto Loan "+(i+1);
                autoLoanCount = i+1;
            }
        }

        if(loanType == "ins"){
            const headingClass = document.getElementsByClassName("insurance_divRow_heading");

            for(let i=0;i<headingClass.length;i++){
                headingClass[i].innerHTML = "Insurance "+(i+1);
                insuranceCount = i+1;
            }
        }





    }


    //Laddle Wet Lining
    var wetBCount = <?php echo $wetBCount?>;
    if(wetBCount == 0){
        wetBCount = 1;
    }
    var wetBCounts = <?php echo $wetBCount?> + 1;

    var wetSCount = <?php echo $wetSCount?>;
    if(wetSCount == 0){
        wetSCount = 1;
    }
    var wetSCounts = <?php echo $wetSCount?> + 1;

    function wetB() {
        // alert('test');
        const headingClassCheck = document.getElementsByClassName("wetB_divRow_heading");
        if (headingClassCheck.length > 0) {
            wetBCount = wetBCount + 1;
        }

        var divRow = document.createElement("div");
        divRow.classList.add("row", "wetBInputs");
        divRow.setAttribute("id", 'wetB_divRow_' + wetBCounts);

        let heading2 = document.createElement("h2");
        heading2.innerHTML = "Bottom Layer " + wetBCount;
        heading2.classList.add("wetB_divRow_heading", "col-12"); // Added col-12 class for full width

        divRow.append(heading2);

        // Create a line break after the heading
        let lineBreak = document.createElement("br");
        divRow.append(lineBreak);

        let labelArr = [ "qty_","dry_start_time_","dry_close_time_","liquid_start_time_","liquid_close_time_","water_usage_"];
        let placeholders = ["Qty","Dry Start Time","Dry Close Time","Liquid Start Time","Liquid Close Time","Water Usage"];

        for (let i = 0; i < labelArr.length; i++) {
            let divcol = document.createElement("div");
            divcol.classList.add("col-md-4");

            let divInput = document.createElement("div");
            divInput.classList.add("form-group"); // Add form-group class for proper alignment

            let textL = labelArr[i];
            // let resultTxts = textL.replaceAll("hl", "");
            let resultTxt = textL.replaceAll("_", " ");

            let formLabel = document.createElement("label");
            formLabel.innerHTML = resultTxt.toUpperCase();

            let formInput = document.createElement("input");
            formInput.classList.add("form-control", "wetBAdd");
            formInput.setAttribute("id", labelArr[i] + wetBCount);
            // formInput.setAttribute("type", labelArr[i] === "qty_" ? "number" : "time");
            if (labelArr[i] === "water_usage_" || labelArr[i] === "total_weight_") {
                formInput.setAttribute("type", "text");
            } else {
                formInput.setAttribute("type", labelArr[i] === "qty_" ? "number" : "time");
            }
            formInput.setAttribute("name", labelArr[i] + wetBCount);
            formInput.setAttribute("placeholder", placeholders[i]);
            formInput.style.color = "black";
            // Add border color styling to the input fields
            formInput.style.borderColor = "black";

            divInput.append(formLabel);
            divInput.append(formInput);
            divcol.append(divInput);
            divRow.append(divcol);
        }

        let divcol = document.createElement("div");
        divcol.classList.add("col-md-4");

        let divInput = document.createElement("div");
        divInput.classList.add("form-group"); // Add form-group class for proper alignment

        let btnRe = document.createElement("button");
        btnRe.innerHTML = "Remove";
        btnRe.classList.add("btn", "btn-danger", "w-30");
        btnRe.setAttribute("onclick", "removeEle('wetB_divRow_" + wetBCounts + "','wetB')");
        btnRe.setAttribute("type", "button");
        btnRe.style.marginTop = "30px";
        divInput.append(btnRe);
        divcol.append(divInput);
        divRow.append(divcol);

        wetBCounts++;

        document.getElementById("wetB_div").append(divRow);
    }

    function wetS(){

        const headingClassCheck = document.getElementsByClassName("wetS_divRow_heading");
        if(headingClassCheck.length > 0){
            wetSCount = wetSCount+1;
            // personalLoanCount = personalLoanCount+headingClassCheck.length;
        }

        var divRow = document.createElement("div");
        divRow.classList.add("row","wetSInputs");
        divRow.setAttribute("id",'wetS_divRow_'+wetSCounts);

        let heading2 = document.createElement("h2");
        heading2.innerHTML = "Side Layer "+ wetSCount;
        heading2.classList.add("wetS_divRow_heading", "col-12"); // Added col-12 class for full width
        divRow.append(heading2);

        let labelArr = ["wetS_qty_","wetS_dry_start_time_","wetS_dry_close_time_","wetS_liquid_start_time_","wetS_liquid_close_time_","wetS_water_usage_"];
        let placeholders = ["Qty","Dry Start Time","Dry Close Time","Liquid Start Time","Liquid Close Time","Water Usage"];
        for(let i = 0;i<labelArr.length;i++){

            let divcol = document.createElement("div");
            divcol.classList.add("col-md-4");

            let divInput = document.createElement("div");
            divInput.classList.add("input-block", "mb-3");

            let textL = labelArr[i];
            let resultTxts = textL.replaceAll("wetS", "");
            let resultTxt = resultTxts.replaceAll("_", " ");


            let formLabel = document.createElement("label");
            formLabel.innerHTML = resultTxt.toUpperCase();


            let formInput = document.createElement("input");
            formInput.classList.add("form-control","wetSAdd");
            formInput.setAttribute("id",labelArr[i]+wetSCounts);
            // formInput.setAttribute("type", labelArr[i] === "sl_qty_" ? "number" : "time");
            if (labelArr[i] === "wetS_water_usage_" || labelArr[i] === "wetS_total_weight_") {
                formInput.setAttribute("type", "text");
            } else {
                formInput.setAttribute("type", labelArr[i] === "wetS_qty_" ? "number" : "time");
            }
            formInput.setAttribute("name",labelArr[i]+wetSCounts);
            formInput.setAttribute("placeholder", placeholders[i]);
            formInput.style.color = "black";
            // Add border color styling to the input fields
            formInput.style.borderColor = "black";

            divInput.append(formLabel);
            divInput.append(formInput);
            divcol.append(divInput);
            divRow.append(divcol);
        }
        let divcol = document.createElement("div");
        divcol.classList.add("col-md-4");

        let divInput = document.createElement("div");
        divInput.classList.add("input-block", "mb-3");

        let btnRe = document.createElement("button");
        btnRe.innerHTML = "Remove";
        btnRe.classList.add("btn","btn-danger","w-30");
        btnRe.setAttribute("onclick","removeEle('wetS_divRow_"+wetSCounts+"','wetS')");
        btnRe.setAttribute("type","button");

        divcol.append(btnRe);
        divRow.append(divcol);

        wetSCounts++;
        // personalLoanCount++;
        document.getElementById("wetS_div").append(divRow);

    }

    function removeEle(eleId,loanType) {
        document.getElementById(eleId).remove();

        if(loanType == "wetB"){
            const headingClass = document.getElementsByClassName("wetB_divRow_heading");

            for(let i=0;i<headingClass.length;i++){
                headingClass[i].innerHTML = "Bottom Layer "+(i+1);
                wetBCount = i+1;
            }
        }

        if(loanType == "wetS"){
            const headingClass = document.getElementsByClassName("wetS_divRow_heading");

            for(let i=0;i<headingClass.length;i++){
                headingClass[i].innerHTML = "Side Layer "+(i+1);
                wetSCount = i+1;
            }
        }
    }


    //Laddle Dry Lining
    var dryBCount = <?php echo $dryBCount?>;
    if(dryBCount == 0){
        dryBCount = 1;
    }
    var dryBCounts = <?php echo $dryBCount?> + 1;

    var drySCount = <?php echo $drySCount?>;
    if(drySCount == 0){
        drySCount = 1;
    }
    var drySCounts = <?php echo $drySCount?> + 1;

    function dryB() {
        const headingClassCheck = document.getElementsByClassName("dryB_divRow_heading");
        if (headingClassCheck.length > 0) {
            dryBCount = dryBCount + 1;
        }

        var divRow = document.createElement("div");
        divRow.classList.add("row", "dryBInputs");
        divRow.setAttribute("id", 'dryB_divRow_' + dryBCounts);

        let heading2 = document.createElement("h2");
        heading2.innerHTML = "Bottom Layer " + dryBCount;
        heading2.classList.add("dryB_divRow_heading", "col-12"); // Added col-12 class for full width

        divRow.append(heading2);

        // Create a line break after the heading
        let lineBreak = document.createElement("br");
        divRow.append(lineBreak);

        let labelArr = ["qty_","fork_start_time_","fork_close_time_"];
        let placeholders = ["Qty","Fork Start Time","Fork Close Time"];

        for (let i = 0; i < labelArr.length; i++) {
            let divcol = document.createElement("div");
            divcol.classList.add("col-md-4");

            let divInput = document.createElement("div");
            divInput.classList.add("form-group"); // Add form-group class for proper alignment

            let textL = labelArr[i];
            // let resultTxts = textL.replaceAll("hl", "");
            let resultTxt = textL.replaceAll("_", " ");

            let formLabel = document.createElement("label");
            formLabel.innerHTML = resultTxt.toUpperCase();

            let formInput = document.createElement("input");
            formInput.classList.add("form-control", "dryBAdd");
            formInput.setAttribute("id", labelArr[i] + dryBCount);
            // formInput.setAttribute("type", labelArr[i] === "qty_" ? "number" : "time");
            if (labelArr[i] === "pressure_" || labelArr[i] === "total_weight_") {
                formInput.setAttribute("type", "text");
            } else {
                formInput.setAttribute("type", labelArr[i] === "qty_" ? "number" : "time");
            }
            formInput.setAttribute("name", labelArr[i] + dryBCount);
            formInput.setAttribute("placeholder", placeholders[i]);
            formInput.style.color = "black";
            // Add border color styling to the input fields
            formInput.style.borderColor = "black";

            divInput.append(formLabel);
            divInput.append(formInput);
            divcol.append(divInput);
            divRow.append(divcol);
        }

        let divcol = document.createElement("div");
        divcol.classList.add("col-md-4");

        let divInput = document.createElement("div");
        divInput.classList.add("form-group"); // Add form-group class for proper alignment

        let btnRe = document.createElement("button");
        btnRe.innerHTML = "Remove";
        btnRe.classList.add("btn", "btn-danger", "w-30");
        btnRe.setAttribute("onclick", "removeEle('dryB_divRow_" + dryBCounts + "','dryB')");
        btnRe.setAttribute("type", "button");
        btnRe.style.marginTop = "30px";
        divInput.append(btnRe);
        divcol.append(divInput);
        divRow.append(divcol);

        dryBCounts++;

        document.getElementById("dryB_div").append(divRow);
    }

    function dryS(){

        const headingClassCheck = document.getElementsByClassName("dryS_divRow_heading");
        if(headingClassCheck.length > 0){
            drySCount = drySCount+1;
            // personalLoanCount = personalLoanCount+headingClassCheck.length;
        }

        var divRow = document.createElement("div");
        divRow.classList.add("row","drySInputs");
        divRow.setAttribute("id",'dryS_divRow_'+drySCounts);

        let heading2 = document.createElement("h2");
        heading2.innerHTML = "Side Layer "+ drySCount;
        heading2.classList.add("dryS_divRow_heading", "col-12"); // Added col-12 class for full width
        divRow.append(heading2);

        let labelArr = ["dryS_qty_","dryS_fork_start_time","dryS_fork_close_time"];
        let placeholders = ["Qty","Fork Start Time","Fork Close Time"];
        for(let i = 0;i<labelArr.length;i++){

            let divcol = document.createElement("div");
            divcol.classList.add("col-md-4");

            let divInput = document.createElement("div");
            divInput.classList.add("input-block", "mb-3");

            let textL = labelArr[i];
            let resultTxts = textL.replaceAll("dryS", "");
            let resultTxt = resultTxts.replaceAll("_", " ");


            let formLabel = document.createElement("label");
            formLabel.innerHTML = resultTxt.toUpperCase();


            let formInput = document.createElement("input");
            formInput.classList.add("form-control","drySAdd");
            formInput.setAttribute("id",labelArr[i]+drySCounts);
            // formInput.setAttribute("type", labelArr[i] === "sl_qty_" ? "number" : "time");
            if (labelArr[i] === "dryS_pressure_" || labelArr[i] === "dryS_total_weight_") {
                formInput.setAttribute("type", "text");
            } else {
                formInput.setAttribute("type", labelArr[i] === "dryS_qty_" ? "number" : "time");
            }
            formInput.setAttribute("name",labelArr[i]+drySCounts);
            formInput.setAttribute("placeholder", placeholders[i]);
            formInput.style.color = "black";
            // Add border color styling to the input fields
            formInput.style.borderColor = "black";

            divInput.append(formLabel);
            divInput.append(formInput);
            divcol.append(divInput);
            divRow.append(divcol);
        }
        let divcol = document.createElement("div");
        divcol.classList.add("col-md-4");

        let divInput = document.createElement("div");
        divInput.classList.add("input-block", "mb-3");

        let btnRe = document.createElement("button");
        btnRe.innerHTML = "Remove";
        btnRe.classList.add("btn","btn-danger","w-30");
        btnRe.setAttribute("onclick","removeEle('dryS_divRow_"+drySCounts+"','dryS')");
        btnRe.setAttribute("type","button");

        divcol.append(btnRe);
        divRow.append(divcol);

        drySCounts++;
        // personalLoanCount++;
        document.getElementById("dryS_div").append(divRow);

    }

    function removeEle(eleId,loanType) {
        document.getElementById(eleId).remove();

        if(loanType == "dryB"){
            const headingClass = document.getElementsByClassName("dryB_divRow_heading");

            for(let i=0;i<headingClass.length;i++){
                headingClass[i].innerHTML = "Bottom Layer "+(i+1);
                dryBCount = i+1;
            }
        }

        if(loanType == "dryS"){
            const headingClass = document.getElementsByClassName("dryS_divRow_heading");

            for(let i=0;i<headingClass.length;i++){
                headingClass[i].innerHTML = "Side Layer "+(i+1);
                drySCount = i+1;
            }
        }

    }


    //Erosion Laddle Lining
    var erLCount = <?php echo $erLCount?>;
    if(erLCount == 0){
        erLCount = 1;
    }
    var erLCounts = <?php echo $erLCount?> + 1;

    var erFCount = <?php echo $erFCount?>;
    if(erFCount == 0){
        erFCount = 1;
    }
    var erFCounts = <?php echo $erFCount?> + 1;

    function erL() {
        const headingClassCheck = document.getElementsByClassName("erL_divRow_heading");
        if (headingClassCheck.length > 0) {
            erLCount = erLCount + 1;
        }

        var divRow = document.createElement("div");
        divRow.classList.add("row", "erLInputs");
        divRow.setAttribute("id", 'erL_divRow_' + erLCounts);

        let heading2 = document.createElement("h2");
        heading2.innerHTML = "Bottom Layer " + erLCount;
        heading2.classList.add("erL_divRow_heading", "col-12"); // Added col-12 class for full width

        divRow.append(heading2);

        // Create a line break after the heading
        let lineBreak = document.createElement("br");
        divRow.append(lineBreak);

        let labelArr = ["lcapacity_", "heat_undergone_","no_of_patching_","erosion_factor_","material_consumption_","dimension_after_patching_"];
        let placeholders = ["laddle Capacity", "Heat Undergone","No Of Patching","Erosion Factor","Material Consumption","Dimension After Patching"];

        for (let i = 0; i < labelArr.length; i++) {
            let divcol = document.createElement("div");
            divcol.classList.add("col-md-4");

            let divInput = document.createElement("div");
            divInput.classList.add("form-group"); // Add form-group class for proper alignment

            let textL = labelArr[i];
            // let resultTxts = textL.replaceAll("hl", "");
            let resultTxt = textL.replaceAll("_", " ");

            let formLabel = document.createElement("label");
            formLabel.innerHTML = resultTxt.toUpperCase();

            let formInput = document.createElement("input");
            formInput.classList.add("form-control", "erLAdd");
            formInput.setAttribute("id", labelArr[i] + erLCount);
            // formInput.setAttribute("type", labelArr[i] === "qty_" ? "number" : "time");
            if (labelArr[i] === "pressure_" || labelArr[i] === "total_weight_") {
                formInput.setAttribute("type", "text");
            } else {
                formInput.setAttribute("type", labelArr[i] === "qty_" ? "text" : "text");
            }
            if(labelArr[i] === "pressure_"){
                formInput.setAttribute("value", "4.5-6 PSI")
            }
            formInput.setAttribute("name", labelArr[i] + erLCount);
            formInput.setAttribute("placeholder", placeholders[i]);
            formInput.style.color = "black";
            // Add border color styling to the input fields
            formInput.style.borderColor = "black";

            divInput.append(formLabel);
            divInput.append(formInput);
            divcol.append(divInput);
            divRow.append(divcol);
        }

        let divcol = document.createElement("div");
        divcol.classList.add("col-md-4");

        let divInput = document.createElement("div");
        divInput.classList.add("form-group"); // Add form-group class for proper alignment

        let btnRe = document.createElement("button");
        btnRe.innerHTML = "Remove";
        btnRe.classList.add("btn", "btn-danger", "w-30");
        btnRe.setAttribute("onclick", "removeEle('erL_divRow_" + erLCounts + "','erL')");
        btnRe.setAttribute("type", "button");
        btnRe.style.marginTop = "30px";
        divInput.append(btnRe);
        divcol.append(divInput);
        divRow.append(divcol);

        erLCounts++;

        document.getElementById("erL_div").append(divRow);
    }

    function erF(){

        const headingClassCheck = document.getElementsByClassName("erF_divRow_heading");
        if(headingClassCheck.length > 0){
            erFCount = erFCount+1;
            // personalLoanCount = personalLoanCount+headingClassCheck.length;
        }

        var divRow = document.createElement("div");
        divRow.classList.add("row","erFInputs");
        divRow.setAttribute("id",'erF_divRow_'+erFCounts);

        let heading2 = document.createElement("h2");
        heading2.innerHTML = "Side Layer "+ erFCount;
        heading2.classList.add("erF_divRow_heading", "col-12"); // Added col-12 class for full width
        divRow.append(heading2);

        let labelArr = ["erF_lcapacity_", "erF_heat_undergone_","erF_no_of_patching_","erF_erosion_factor_","erF_material_consumption_","erF_dimension_after_patching_"];
        let placeholders = ["laddle Capacity", "Heat Undergone","No Of Patching","Erosion Factor","Material Consumption","Dimension After Patching"];
        for(let i = 0;i<labelArr.length;i++){

            let divcol = document.createElement("div");
            divcol.classList.add("col-md-4");

            let divInput = document.createElement("div");
            divInput.classList.add("input-block", "mb-3");

            let textL = labelArr[i];
            let resultTxts = textL.replaceAll("erF", "");
            let resultTxt = resultTxts.replaceAll("_", " ");


            let formLabel = document.createElement("label");
            formLabel.innerHTML = resultTxt.toUpperCase();


            let formInput = document.createElement("input");
            formInput.classList.add("form-control","erFAdd");
            formInput.setAttribute("id",labelArr[i]+erFCounts);
            // formInput.setAttribute("type", labelArr[i] === "sl_qty_" ? "number" : "time");
            if (labelArr[i] === "erF_pressure_") {
                formInput.setAttribute("type", "text");
            } else {
                formInput.setAttribute("type", labelArr[i] === "erF_qty_" ? "number" : "text");
            }
            formInput.setAttribute("name",labelArr[i]+erFCounts);
            formInput.setAttribute("placeholder", placeholders[i]);
            formInput.style.color = "black";
            // Add border color styling to the input fields
            formInput.style.borderColor = "black";

            divInput.append(formLabel);
            divInput.append(formInput);
            divcol.append(divInput);
            divRow.append(divcol);
        }
        let divcol = document.createElement("div");
        divcol.classList.add("col-md-4");

        let divInput = document.createElement("div");
        divInput.classList.add("input-block", "mb-3");

        let btnRe = document.createElement("button");
        btnRe.innerHTML = "Remove";
        btnRe.classList.add("btn","btn-danger","w-30");
        btnRe.setAttribute("onclick","removeEle('erF_divRow_"+erFCounts+"','erF')");
        btnRe.setAttribute("type","button");

        divcol.append(btnRe);
        divRow.append(divcol);

        drySCounts++;
        // personalLoanCount++;
        document.getElementById("erF_div").append(divRow);

    }

    function removeEle(eleId,loanType) {
        document.getElementById(eleId).remove();

        if(loanType == "erL"){
            const headingClass = document.getElementsByClassName("erL_divRow_heading");

            for(let i=0;i<headingClass.length;i++){
                headingClass[i].innerHTML = "Bottom Layer "+(i+1);
                erLCount = i+1;
            }
        }

        if(loanType == "erF"){
            const headingClass = document.getElementsByClassName("erF_divRow_heading");

            for(let i=0;i<headingClass.length;i++){
                headingClass[i].innerHTML = "Side Layer "+(i+1);
                erFCount = i+1;
            }
        }

    }
    // var acc = document.getElementsByClassName("accordion");
    // var d;
    //
    // for (d = 0; d < acc.length; d++) {
    //     acc[d].addEventListener("click", function() {
    //         this.classList.toggle("active");
    //         var panel = this.nextElementSibling;
    //         if (panel.style.maxHeight) {
    //             panel.style.maxHeight = null;
    //         } else {
    //             panel.style.maxHeight = panel.scrollHeight + "px";
    //         }
    //     });
    // }
</script>

</body>
</html>

