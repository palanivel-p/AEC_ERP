<?php Include("../includes/connection.php");

error_reporting(0);
$page= $_GET['page_no'];
$sh_id= $_GET['sh_id'];
$f_date = $_GET['f_date'];
$t_date = $_GET['t_date'];
$vehicle_no = $_GET['vehicle_no'];
$lr_no = $_GET['lr_no'];

if($f_date == ''){
    $f_date = date('Y-m-01');
}
if($t_date == ''){
    $t_date = date('Y-m-d');
}
$from_date = date('Y-m-d 00:00:00',strtotime($f_date));
$to_date = date('Y-m-d 23:59:59',strtotime($t_date));
if($sh_id != ""){
    $sh_idSql= " AND shipping_id = '".$sh_id."'";
}
else{
    $sh_idSql ="";
}
if($lr_no != ""){
    $lr_noSql= " AND shipping_id = '".$lr_no."'";
}
else{
    $lr_noSql ="";
}
if($vehicle_no != ""){
    $vehicle_noSql= " AND shipping_id = '".$vehicle_no."'";
}
else{
    $vehicle_noSql ="";
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
    <title>Delivery challan</title>
    <link rel="icon" type="image/png" sizes="16x16" href="https://bhims.ca/piloting/img/favicon_New.png">
    <link href="../vendor/jqvmap/css/jqvmap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="../vendor/chartist/css/chartist.min.css">
    <link href="../vendor/jqvmap/css/jqvmap.min.css" rel="stylesheet">
    <link href="../vendor/bootstrap-select/dist/css/bootstrap-select.min.css" rel="stylesheet">
    <link href="../css/style.css" rel="stylesheet">
    <link href="../vendor/owl-carousel/owl.carousel.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css" integrity="sha512-z3gLpd7yknf1YoNbCzqRKc4qyor8gaKU1qmn+CShxbuBusANI9QpRohGBreCFkKxLhei6S9CQXFEbbKuqLg0DA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">    <link href="../vendor/bootstrap-daterangepicker/daterangepicker.css" rel="stylesheet">
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
    $header_name ="Delivery challan";
    Include ('../includes/header.php') ?>

    <div class="content-body">
        <div class="page-titles" style="margin-left: 21px;">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="javascript:void(0)">Table</a></li>
                <li class="breadcrumb-item active"><a href="javascript:void(0)">Delivery challan</a></li>
            </ol>
        </div>

        <div class="col-lg-12">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">Delivery challan List</h4>
                    <div style="display: flex;justify-content: flex-end;">
                        <form class="form-inline">
                            <!--                            <div class="form-group mx-sm-3 mb-2">-->
                            <!--                                <input type="text" class="form-control" placeholder="Search By Name" name="search" id="search" style="border-radius:20px;color:black;" >-->
                            <!--                            </div>-->
                            <!--                            <button type="submit" class="btn btn-primary mb-2">Search</button>-->
                        </form>
<!--                        <button type="button" class="btn btn-primary mb-2" data-toggle="modal" data-target="#career_list" onclick="addTitle()">ADD</button>-->
                        <button type="button" class="btn btn-primary mb-2" data-toggle="modal" data-target="#invoice_filter" style="margin-left: 20px;">FILTER</button>
                        <button type="button" class="pdf_download btn btn-primary mb-2" id="pdf" style="margin-left: 20px;">PDF</button>
<!--                                                <button class="pdf_download btn btn-success" type="button" id="pdf">PDF</button>-->
                        <button type="button" class="excel_download btn btn-rounded btn-success" style="margin-left: 20px;"><span class="btn-icon-left text-success"><i class="fa fa-download color-success"></i>
            </span>Excel</button>
                    </div>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-responsive-md" style="text-align: center;">
                            <thead>
                            <tr>
                                <th class="width80"><strong>#</strong></th>
                                <th><strong>Sale Id</strong></th>
                                <th><strong>Delivery challan Id</strong></th>
                                <th><strong>Dispatched Through</strong></th>
                                <th><strong>Destination</strong></th>
                                <th><strong> Vehicle No</strong></th>
                                <th><strong>Delivery challan Date</strong></th>
                                <th><strong>Delivery Date </strong></th>
                                <th><strong>Supplier Name</strong></th>
                                <th><strong>Shipping Amount</strong></th>
                                <th><strong>Other Charges</strong></th>
                                <th><strong>Total Paid</strong></th>
                                <th><strong>Total Due</strong></th>
                                <th><strong>Delivery challan Download</strong></th>
                                <th><strong>View</strong></th>
                                <th><strong>Action</strong></th>

                            </tr>
                            </thead>
                            <?php
                             $sql = "SELECT * FROM sale_shipment ORDER BY id DESC LIMIT $start,10";

//                            if($email == "" && $s_code == "" && $mobile== "" && $s_name == "") {
//                                $sql = "SELECT * FROM supplier  ORDER BY id  LIMIT $start,10";
//                            }
//                            else {
//                                $sql = "SELECT * FROM supplier WHERE id > 0 $emailSql$mobileSql$sCodeSql$sNameSql ORDER BY id  LIMIT $start,10";
//                            }
                            $result = mysqli_query($conn, $sql);
                            if (mysqli_num_rows($result)>0) {
                            $sNo = $start;
                            while($row = mysqli_fetch_assoc($result)) {

                            $sNo++;
                            $shipment_id= $row['shipping_id'];
                            $sqlamount="SELECT SUM(pay_made) AS pay_made  FROM sale_dc WHERE repayment_id='$shipment_id'";
                            $resamount=mysqli_query($conn,$sqlamount);
                            if(mysqli_num_rows($resamount)>0){
                                $arrayamount=mysqli_fetch_array($resamount);
                                $totalAmount=$arrayamount['pay_made'];
                            }
                            $grand_total= $row['shipping_amount'];
                            $balance_amount= $grand_total - $totalAmount;
                            if($totalAmount == 0){
                                $totalAmount = 'NA';
                            }
                            $s_date = $row['date'];
                            $shipment_date = date('d-m-Y', strtotime($s_date));
                            $d_date = $row['delivery_date'];
                            $delivery_date = date('d-m-Y', strtotime($d_date));
                            ?>
                            <tbody>
                            <tr>
                                <td><strong><?php echo $sNo;?></strong></td>
                                <td><?php echo $row['sale_id']?></td>
                                <td><?php echo $row['shipping_id']?></td>
<!--                                <td>--><?php //echo $row['dispatch_doc']?><!--</td>-->
                                <td><?php echo $row['dispatched_through']?></td>
                                <td> <?php echo $row['destination']?> </td>
<!--                                <td> --><?php //echo $row['bl_no']?><!-- </td>-->
                                <td> <?php echo $row['vehicle_no']?> </td>
                                <td> <?php echo $shipment_date?> </td>
                                <td><?php echo $delivery_date?></td>
                                <td> <?php echo $row['supplier_name']?> </td>
                                <td> <?php echo $row['shipping_amount']?> </td>
                                <td> <?php echo $row['other_charges']?> </td>
                                <td> <?php echo $totalAmount?> </td>
                                <td> <?php echo $balance_amount?> </td>
                                <td> <a href="invoice.php?sale_id=<?php echo $row['sale_id'] ?>"><span class="badge badge-pill badge-primary">Download</span></a></td>
                                <td class="text-center">
                                    <div class="dropdown">
                                        <a href="<?php echo $website?>/sale_shipment/show_file.php?shipping_id=<?php echo $row['shipping_id']?>"
                                           class="btn btn-primary shadow btn-xs sharp me-1"><i
                                                    class="fa fa-eye"></i></a>
                                    </div>
                    </div>
                    </td>
                                <td>
                                    <div class="dropdown">
                                        <button type="button" class="btn btn-success light sharp" data-toggle="dropdown">
                                            <svg width="20px" height="20px" viewbox="0 0 24 24" version="1.1"><g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd"><rect x="0" y="0" width="24" height="24"></rect><circle fill="#000000" cx="5" cy="12" r="2"></circle><circle fill="#000000" cx="12" cy="12" r="2"></circle><circle fill="#000000" cx="19" cy="12" r="2"></circle></g></svg>
                                        </button>
                                        <div class="dropdown-menu">
                                            <a class="dropdown-item" data-toggle="modal" data-target="#repayment_list" style="cursor: pointer" onclick="repayment('<?php echo $row['sale_id']?>','<?php echo $row['shipping_id']?>','<?php echo $row['shipping_amount']?>','<?php echo $totalAmount?>','<?php echo $balance_amount?>')">Create Payment</a>
                                            <a class="dropdown-item" data-toggle="modal" data-target="#career_list" style="cursor: pointer" onclick="editTitle('<?php echo $row['shipping_id'];?>')">Edit</a>
                                            <?php
                                            if($_COOKIE['role'] == 'Super Admin') {
                                            ?>
                                            <a class="dropdown-item" style="cursor: pointer" onclick="delete_model('<?php echo $row['shipping_id'];?>')">Delete</a>
                                                <?php
                                            }
                                            ?>
                                        </div>
                                    </div>
                                </td>
                            </tr>

                            <?php } }
                            ?>
                            </tbody>
                        </table>
                        <div class="col-12 pl-3" style="display: flex;justify-content: center;">
                            <nav>
                                <ul class="pagination pagination-gutter pagination-primary pagination-sm no-bg">
                                    <?php
                                    $prevPage=abs($page-1);
                                    if($prevPage==0)
                                    {
                                        ?>
                                        <li class="page-item page-indicator"><a class="page-link" href="javascript:void(0);"><i class="fa-solid fa-less-than"></i></a></li>
                                        <?php
                                    }
                                    else
                                    {
                                        ?>
                                        <li class="page-item page-indicator"><a class="page-link" href="?page_no=<?php echo $prevPage?>"><i class="fa-solid fa-less-than"></i></a></li>
                                        <?php
                                    }

//                                    $sql = 'SELECT COUNT(id) as count FROM sale_shipment WHERE id>0 $addedBy';
                                    $sql = "SELECT COUNT(id) as count FROM sale_shipment ";

                                    $result = mysqli_query($conn, $sql);

                                    if (mysqli_num_rows($result)) {

                                        $row = mysqli_fetch_assoc($result);
                                        $count = $row['count'];
                                        $show = 10;

                                        $get = $count / $show;

                                        $pageFooter = floor($get);

                                        if ($get > $pageFooter) {
                                            $pageFooter++;
                                        }

                                        for ($i = 1; $i <= $pageFooter; $i++) {
                                            if($i==$page) {
                                                $active = "active";
                                            }
                                            else {
                                                $active = "";
                                            }
                                            if($i<=($pageSql+10) && $i>$pageSql || $pageFooter<=10) {
                                                ?>
                                                <li class="page-item <?php echo $active ?>"><a class="page-link"
                                                                                               href="?page_no=<?php echo $i ?>"><?php echo $i ?></a>
                                                </li>
                                                <?php
                                            }
                                        }

                                        $nextPage=$page+1;

                                        if($nextPage>$pageFooter)
                                        {
                                            ?>
                                            <li class="page-item page-indicator"><a class="page-link" href="javascript:void(0);"><i class="fa-solid fa-greater-than"></i></a></li>
                                            <?php
                                        }
                                        else
                                        {
                                            ?>
                                            <li class="page-item page-indicator"><a class="page-link" href="?page_no=<?php echo $nextPage ?>"><i class="fa-solid fa-greater-than"></i></a></li>
                                            <?php
                                        }
                                    }
                                    ?>
                                </ul>
                            </nav>
                        </div>
                    </div>
                </div>
            </div>
        </div>


        <div class="modal fade" id="career_list"  data-keyboard="false" data-backdrop="static">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="titles">Delivery challan</h5>
                        <button type="button" class="close" data-dismiss="modal"><span>&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="basic-form" style="color: black;">
                            <form id="purchase_form" autocomplete="off">
                                <div class="form-row">

                                    <div class="form-group col-md-6">
                                        <label>Date *</label>
                                        <input type="date" class="form-control" placeholder="Date" id="date" name="date" style="border-color: #181f5a;color: black">
                                        <input type="hidden" class="form-control"  id="api" name="api">
                                        <input type="hidden" class="form-control" placeholder="sale Id" id="s_id" name="s_id" value="<?php echo $sale_id?>">                                  <input type="hidden" class="form-control"  id="old_pa_id" name="old_pa_id">
                                        <input type="hidden" class="form-control"  id="shipping_id" name="shipping_id">
                                    </div>
                                    <div class="form-group col-md-6">
                                        <label>Terms of Delivery</label>
                                        <select data-search="true" class="form-control tail-select w-full" id="payment_terms" name="payment_terms" style="border-color: #181f5a;color: black">
                                            <option value=''>Select Day</option>
                                            <option value='0'>Immidiate</option>
                                            <option value='15'>15 Days</option>
                                            <option value='30'>30 Days</option>
                                            <option value='45'>45 Days</option>
                                            <option value='60'>60 Days</option>
                                            <option value='75'>75 Days</option>
                                            <option value='90'>90 Days</option>
                                            <option value='105'>105 Days</option>
                                            <option value='120'>120 Days</option>

                                        </select>
                                    </div>

                                    <div class="form-group col-md-6">
                                        <label>Expected Delivery Date *</label>
                                        <input type="date" class="form-control"  id="d_date" name="d_date" style="border-color: #181f5a;color: black">
                                    </div>
                                    <div class="form-group col-md-6">
                                        <label>Dispatched through *</label>
                                        <input type="text" class="form-control" placeholder="Dispatched through" id="d_through" name="d_through" style="border-color: #181f5a;color: black">
                                    </div>
                                    <div class="form-group col-md-6">
                                        <label>Destination *</label>
                                        <input type="text" class="form-control" placeholder="Destination" id="destination" name="destination" style="border-color: #181f5a;color: black">
                                    </div>
                                    <div class="form-group col-md-6">
                                        <label>Supplier Name</label>
                                        <input type="text" class="form-control" placeholder="Supplier Name" id="supplier_name" name="supplier_name" style="border-color: #181f5a;color: black">
                                    </div>
                                    <div class="form-group col-md-6">
                                        <label>Vehicle No *</label>
                                        <input type="text" class="form-control" placeholder="Motor Vehicle No" id="vehicle_no" name="vehicle_no" style="border-color: #181f5a;color: black">
                                    </div>
                                    <!--                                    <div class="form-group col-md-6">-->
                                    <!--                                        <label>Terms of Delivery </label>-->
                                    <!--                                        <input type="text" class="form-control" placeholder="Terms of Delivery" id="t_delivery" name="t_delivery" style="border-color: #181f5a;color: black">-->
                                    <!--                                    </div>-->
                                    <div class="form-group col-md-6">
                                        <label>Shipping Amount *</label>
                                        <input type="number" class="form-control" placeholder="Shipping Amount" id="shipping_amount" name="shipping_amount" style="border-color: #181f5a;color: black">
                                    </div>
                                    <div class="form-group col-md-6">
                                        <label>Other Charges</label>
                                        <input type="number" class="form-control" placeholder="Other Charges" id="other_charges" name="other_charges" style="border-color: #181f5a;color: black">
                                    </div>


                                </div>
                            </form>
                        </div>


                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-danger light" data-dismiss="modal" style="background-color: red; color: white;">Close</button>
                        <button type="button" class="btn btn-primary" id="addbtn">ADD</button>
                    </div>
                </div>
            </div>
        </div>

    </div>

    <?php Include ('../includes/footer.php') ?>
    <div class="modal fade" id="invoice_filter"  data-keyboard="false" data-backdrop="static">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <!-- <h5 class="modal-title" id="title">pay Details</h5> -->

                    <button type="button" class="close" data-dismiss="modal"><span>&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="basic-form" style="color: black;">
                        <form id="filter_form" autocomplete="off">
                            <div class="form-row">

                                <div class="form-group col-md-6">
                                    <label>From Date </label>
                                    <input type="date"  class="form-control" id="f_date" name="f_date" style="border-color: #181f5a;color: black">
                                </div>
                                <div class="form-group col-md-6">
                                    <label>To Date </label>
                                    <input type="date"  class="form-control" id="t_date" name="t_date" style="border-color: #181f5a;color: black">
                                </div>
                                <div class="form-group col-md-12">
                                    <label>Delivery challan Id </label>
                                    <input type="text"  class="form-control" placeholder="Delivery challan Id" id="sh_id" name="sh_id" style="border-color: #181f5a;color: black">
                                </div>
                                <div class="form-group col-md-12">
                                    <label>Supplier Name</label>
                                    <input type="text"  class="form-control" placeholder="Supplier Name" id="supplier_name" name="supplier_name" style="border-color: #181f5a;color: black">
                                </div>

                                <div class="form-group col-md-12">
                                    <label>Vehicle No </label>
                                    <input type="text"  class="form-control" placeholder="Vehicle No" id="vehicle_no" name="vehicle_no" style="border-color: #181f5a;color: black">
                                </div>

                                <button type="submit" class="btn btn-primary mb-2">Search</button>
                            </div>
                        </form>
                    </div>

                </div>
                <!--                <div class="modal-footer">-->
                <!--                    <button type="button" class="btn btn-danger light" data-dismiss="modal" style="background-color: red; color: white;">Close</button>-->
                <!--                    <button type="submit" class="btn btn-primary" id="filter">Filter</button>-->
                <!--                </div>-->
            </div>
        </div>
    </div>
<div class="modal fade" id="repayment_list"  data-keyboard="false" data-backdrop="static">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="title">Repayment</h5>
                <button type="button" class="close" data-dismiss="modal"><span>&times;</span>
                </button>
            </div>
            <div class="modal-body">

                <div class="basic-form" style="color: black;">
                    <form id="repayment_form" autocomplete="off">
                        <div class="form-row">
                            <div class="form-group col-md-6" id="payment_date">
                                <label>Payment Date *</label>
                                <input type="date" class="form-control" id="repayment_date" name="repayment_date" style="border-color: #181f5a;color: black">
                                <input type="hidden" class="form-control"  id="apii" name="apii">
                                <input type="hidden" class="form-control"  id="old_pa_id" name="old_pa_id">
                                <input type="hidden" class="form-control"  id="repayment_id" name="repayment_id">
                                <input type="hidden" class="form-control"  id="pur_id" name="pur_id">
                            </div>
                            <div class="form-group col-md-6" id="re">
                                <label>Purchase Id</label>
                                <input type="text" class="form-control"  id="Purch_id" name="Purch_id" readonly style="border-color: #181f5a;color: black">
                            </div>
                            <div class="form-group col-md-6" id="ref_no">
                                <label>Grand Total</label>
                                <input type="text" class="form-control"  id="g_total" name="g_total" readonly style="border-color: #181f5a;color: black">
                            </div>
                            <div class="form-group col-md-6" id="ref_n">
                                <label>Due Amount</label>
                                <input type="text" class="form-control"  id="due_amount" name="due_amount" readonly style="border-color: #181f5a;color: black">
                            </div>
                            <div class="form-group col-md-6" id="ref_">
                                <label>Paid Amount</label>
                                <input type="text" class="form-control"  id="paid_amount" name="paid_amount" readonly style="border-color: #181f5a;color: black">
                            </div>
                            <div class="form-group col-md-6" id="pay_mades">
                                <label>Payment Made *</label>
                                <input type="number" class="form-control" placeholder="Payment Made" id="pay_made" name="pay_made" style="border-color: #181f5a;color: black">
                            </div>
                            <div class="form-group col-md-6" id="repayment_modes">
                                <label>Payment Mode </label>
                                <select  class="form-control" id="repayment_mode" name="repayment_mode" style="border-color: #181f5a;color: black;text-transform: uppercase;">
                                    <option value=''>Select Pay Mode</option>
                                    <option value='Cheque'>Cheque</option>
                                    <option value='Cash'>Cash</option>
                                    <option value='NEFT'>NEFT</option>
                                    <option value='RTGS'>RTGS</option>
                                    <option value='UPI'>UPI</option>
                                </select>
                            </div>

                                    <div class="form-group col-md-6" id="bank_names">
                                        <label>Bank Name *</label>
                                        <select class="form-control" id="bank_name" name="bank_name" style="border-color: #181f5a;color: black;text-transform: uppercase;">
                                            <option value="">Select Bank Name </option>
                                            <?php
                                            $sqlCheque = "SELECT * FROM `company_profile`";
                                            $resCheque = mysqli_query($conn, $sqlCheque);
                                            $rowCheque = mysqli_fetch_assoc($resCheque);
                                            $bank_name =  $rowCheque['bank_name'];
                                            $bank_name2 =  $rowCheque['bank_name2'];
                                            ?>
                                            <option value='<?php echo $bank_name; ?>'><?php echo strtoupper($bank_name); ?></option>
                                            <option value='<?php echo $bank_name2; ?>'><?php echo strtoupper($bank_name2); ?></option>
                                            <?php

                                            ?>
                                        </select>
                                    </div>

<!--                            <div class="form-group col-md-6" id="ref_nos_c">-->
<!--                                <label>Cheque Reference No</label>-->
<!--                                <select  class="form-control" id="ref_no_c" name="ref_no_c" style="border-color: #181f5a;color: black;text-transform: uppercase;">-->
<!--                                    <option value="">Select Cheque No</option>-->
<!--                                </select>-->
<!--                            </div>-->
                            <div class="form-group col-md-6" id="ref_nos">
                                <label>Reference No *</label>
                                <input type="text" class="form-control" placeholder="Reference No" id="ref_no" name="ref_no" style="border-color: #181f5a;color: black">
                            </div>

                            <div class="form-group col-md-6" id="Notess">
                                <label>Notes</label>
                                <input type="text" class="form-control" placeholder="Notes" id="notes" name="notes" style="border-color: #181f5a;color: black">
                            </div>

                        </div>
                    </form>
                </div>

            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-danger light" data-dismiss="modal" style="background-color: red; color: white;text-transform: uppercase">Close</button>
                <button type="button" class="btn btn-primary" id="repay_btn">ADD</button>
            </div>
        </div>
    </div>
</div>

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

    //due date
    $(document).ready(function() {
        $("#payment_terms").change(function() {
            const inputDateValue = document.getElementById("date").value;
            const payment_days = parseInt(document.getElementById("payment_terms").value);
            if (!isNaN(payment_days)) {
                const d = new Date(inputDateValue);
                d.setDate(d.getDate() + payment_days);
                const formattedDate = d.toISOString().split('T')[0];
                $('#d_date').val(formattedDate);
            }
        });
    });


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
        $("#title").html("Add Supplier");
        $('#career_form')[0].reset();
        $('#api').val("add_api.php")
        // $('#game_id').prop('readonly', false);
    }

    function editTitle(data) {

        $("#title").html("Edit Delivery challan- "+data);
        $('#purchase_form')[0].reset();
        $('#api').val("edit_api.php");

        $.ajax({
            type: "POST",
            url: "view_api.php",
            data: 'shipping_id='+data,
            dataType: "json",
            success: function(res){
                if(res.status=='success')
                {
                    $("#date").val(res.date);
                    $("#payment_terms").val(res.terms_delivery);
                    $("#d_note").val(res.d_note);
                    $("#d_through").val(res.dispatched_through);
                    $("#d_date").val(res.delivery_date);
                    $('#destination').val(res.destination);
                    $('#bl_no').val(res.bl_no);
                    $('#vehicle_no').val(res.vehicle_no);
                    $('#shipping_amount').val(res.shipping_amount);
                    $('#other_charges').val(res.other_charges);
                    $('#supplier_name').val(res.supplier_name);


                    // $(".summernote").code("your text");
                    $("#old_pa_id").val(res.shipping_id);
                    $("#shipping_id").val(res.shipping_id);

                    var edit_model_title = "Edit Delivery challan - "+data;
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
    $("#purchase_form").validate(
        {
            ignore: '.ignore',
            // Specify validation rules
            rules: {

                shipping_amount: {
                    required: true
                },
                vehicle_no: {
                    required: true
                },
                destination: {
                    required: true
                },
                d_through: {
                    required: true
                },
                d_date: {
                    required: true
                },
                payment_terms: {
                    required: true
                },
                date: {
                    required: true
                },
            },
            // Specify validation error messages
            messages: {
                shipping_amount: "*This field is required",
                vehicle_no: "*This field is required",
                destination: "*This field is required",
                d_through: "*This field is required",
                d_date: "*This field is required",
                payment_terms: "*This field is required",
                date: "*This field is required",
                d_note: "*This field is required",
            }
            // Make sure the form is submitted to the destination defined
        });

    //add data

    $('#addbtn').click(function () {

        $("#purchase_form").valid();

        if($("#purchase_form").valid()==true) {

            var api = $('#api').val();

            this.disabled = true;
            this.innerHTML = '<i class="fa fa-spinner fa-spin"></i>';
            $.ajax({

                type: "POST",
                url: "edit_api.php",
                data: $('#purchase_form').serialize(),
                dataType: "json",
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

                                document.getElementById("addbtn").disabled = false;
                                document.getElementById("addbtn").innerHTML = 'Add';
                            });

                    }
                },
                error: function () {

                    Swal.fire('Check Your Network!');
                    document.getElementById("addbtn").disabled = false;
                    document.getElementById("addbtn").innerHTML = 'Add';
                }

            });



        } else {
            document.getElementById("addbtn").disabled = false;
            document.getElementById("addbtn").innerHTML = 'Add';

        }


    });


    document.addEventListener('DOMContentLoaded', function () {
        const repayment_mode = document.getElementById('repayment_mode');
        const payment_date = document.getElementById('payment_date');
        const pay_mades = document.getElementById('pay_mades');
        const repayment_modes = document.getElementById('repayment_modes');
        const ref_nos_c = document.getElementById('ref_nos_c');
        const ref_nos = document.getElementById('ref_nos');
        const Notess = document.getElementById('Notess');
        const re = document.getElementById('re');
        const ref_no = document.getElementById('ref_no');
        const ref_n = document.getElementById('ref_n');
        const ref_ = document.getElementById('ref_');
        const bank_names = document.getElementById('bank_names');

        // Add an event listener to the dropdown
        repayment_mode.addEventListener('change', function () {

            a(repayment_mode.value);

        });

        // function a(values) {
        //     if (values === 'Cheque') {
        //         // Hide the input field when 'Hide Input Field' is selected
        //         ref_nos.style.display = 'block';
        //         payment_date.style.display = 'block';
        //         pay_mades.style.display = 'block';
        //         repayment_modes.style.display = 'block';
        //         Notess.style.display = 'block';
        //         ref_nos_c.style.display = 'block';
        //         re.style.display = 'block';
        //         ref_no.style.display = 'block';
        //         ref_n.style.display = 'block';
        //         ref_.style.display = 'block';
        //         bank_names.style.display = 'block';
        //     }
        //     else {
        //         // Show the input field for other selections
        //         ref_nos_c.style.display = 'none';
        //         payment_date.style.display = 'block';
        //         pay_mades.style.display = 'block';
        //         repayment_modes.style.display = 'block';
        //         Notess.style.display = 'block';
        //         ref_nos.style.display = 'block';
        //         re.style.display = 'block';
        //         ref_no.style.display = 'block';
        //         ref_n.style.display = 'block';
        //         ref_.style.display = 'block';
        //         bank_names.style.display = 'block';
        //     }
        // }
    });
    function repayment(data,repay_id ,gtotal, pamount, damount) {
        $("#title").html("Add Payment " + data);
        $('#repayment_form')[0].reset();
        $('#apii').val("repayment_api.php")
        $('#pur_id').val(data)
        $('#g_total').val(gtotal)
        $('#paid_amount').val(pamount)
        $('#due_amount').val(damount)
        $('#Purch_id').val(data)
        $('#repayment_id').val(repay_id)

        // Check if g_total is equal to or greater than paid_amount
        if (parseFloat(gtotal) <= parseFloat(pamount)) {
            $('#pay_made').prop('readonly', true).attr('max', gtotal - pamount);  // Set pay_made field to readonly and set max attribute to the allowed maximum value
        } else {
            $('#pay_made').prop('readonly', false).removeAttr('max');  // Remove readonly and max attribute if it was set
        }

        // Event listener for pay_made input
        $('#pay_made').on('input', function() {
            let payMade = parseFloat($(this).val());
            let grandTotal = parseFloat($('#g_total').val());
            let due_amount = parseFloat($('#due_amount').val());

            if (payMade > due_amount) {
                alert("Payment made cannot be greater than the grand total.");
                $(this).val('');  // Set the input value to the grand total
            }
        });
    }

    //add data
    $('#repay_btn').click(function () {
        $("#repayment_form").valid();
        if($("#repayment_form").valid()==true) {
            var api = $('#apii').val();
            //var loan_id = "<?php //echo $loan_id?>//";
            // var loan_id = 56
            this.disabled = true;
            this.innerHTML = '<i class="fa fa-spinner fa-spin"></i>';
            $.ajax({

                type: "POST",
                url: "repayment_api.php",
                data: $('#repayment_form').serialize(),
                // data: $('#repayment_form').serialize()+ '&' +$.param({loan_id:loan_id}),
                dataType: "json",
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

                                document.getElementById("repay_btn").disabled = false;
                                document.getElementById("repay_btn").innerHTML = 'Add';
                            });

                    }
                },
                error: function () {

                    Swal.fire('Check Your Network!');
                    document.getElementById("repay_btn").disabled = false;
                    document.getElementById("repay_btn").innerHTML = 'Add';
                }

            });

        } else {
            document.getElementById("repay_btn").disabled = false;
            document.getElementById("repay_btn").innerHTML = 'Add';

        }

    });


    //to validate form
    $("#repayment_form").validate(
        {
            ignore: '.ignore',
            // Specify validation rules
            rules: {
                repayment_date: {
                    required: true
                },
                pay_made: {
                    required: true
                },
                repayment_mode: {
                    required: true
                },
                bank_name: {
                    required: true
                },
                ref_no: {
                    required: true
                },


            },
            // Specify validation error messages
            messages: {
                repayment_date: "*This field is required",
                pay_made: "*This field is required",
                repayment_mode: "*This field is required",
                ref_no: "*This field is required",
                bank_name: "*This field is required",
                ref_no: "*This field is required",
            }
            // Make sure the form is submitted to the destination defined
        });
    //delete model
    function getchequename(bankname) {
// alert('hi');return false;
        if(bankname != ''){
            $.ajax({
                type: "POST",
                url: "getchequeno_api.php",
                data: 'bankname='+bankname,
                success: function(res){
                    $('#ref_no_c').html(res);
                    // alert(res);
                    // if(res.status=='success')
                    // {
                    //     var chequeno = res.cheque_no;


                    //     for(let i = 0;i<chequeno.length;i++){
                    //         var opt = document.createElement('option');
                    //         opt.value = chequeno[i];
                    //         opt.innerHTML = chequeno[i];

                    //         document.getElementById('expense_name').appendChild(opt);
                    //     }
                    //     if(category_sub != undefined){
                    //         $("#expense_name").val(expense_name);

                    //     }
                    //     $("#expense_name").trigger("change");
                    // }
                    // else if(res.status=='failure')
                    // {
                    //     Swal.fire("Invalid",  res.msg, "warning")
                    //     // .then((value) => {
                    //     //     window.window.location.reload();
                    //     // });
                    // }
                    // else if(res.status=='failure')
                    // {
                    //     Swal.fire("Failure",  res.msg, "error")
                    //     // .then((value) => {
                    //     //     window.window.location.reload();
                    //     //
                    //     // });
                    // }
                },
                error: function(){
                    Swal.fire("Check your network connection");
                    // window.window.location.reload();
                }
            });
        }
    }
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
                        data: 'shipping_id='+data,
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
        window.location.href = "excel_download.php?&s_name=<?php echo '$s_name'?>&s_code=<?php echo '$s_code'?>&mobile=<?php echo '$mobile'?>&email=<?php echo '$email'?>";
    });
    $(document).on("click", ".pdf_download", function () {
        window.location.href = "pdf_download.php?&s_name=<?php echo '$s_name'?>&s_code=<?php echo '$s_code'?>&mobile=<?php echo '$mobile'?>&email=<?php echo '$email'?>";
    });
</script>


</body>
</html>
