
<?php Include("../includes/connection.php");
date_default_timezone_set("Asia/kolkata");

error_reporting(0);
$page= $_GET['page_no'];
$pur_id= $_GET['pur_id'];
$f_date = $_GET['f_date'];
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
    $pur_idSql= " AND so_id = '".$pur_id."'";

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
$so_id= $_GET['so_id'];
$sqlsale = "SELECT * FROM so WHERE so_id ='$so_id'";
$ressale = mysqli_query($conn, $sqlsale);
$rowsale = mysqli_fetch_assoc($ressale);
$so_date =  $rowsale['so_date'];
$due_date =  $rowsale['due_date'];
$customer =  $rowsale['customer'];
$e_way =  $rowsale['e_way'];
$payment_terms =  $rowsale['payment_terms'];
$discountss =  $rowsale['discount'];
$discounts=  str_replace("%","",$discountss);
$payment_status =  $rowsale['status'];
$status =  $rowsale['payment_status'];
$grand_total =  $rowsale['grand_total'];
$po_no =  $rowsale['po_no'];
$po_date =  $rowsale['po_date'];
$notes=$rowsale['notes'];
$total_tax=$rowsale['total_tax'];
$tds=$rowsale['tds'];

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width,initial-scale=1">
    <title>Edit so profile</title>

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

    $header_name ="Edit so";
    Include ('../includes/header.php')

    ?>

    <div class="content-body">
        <div class="page-titles" style="margin-left: 21px;">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="javascript:void(0)">Table</a></li>
                <li class="breadcrumb-item active"><a href="javascript:void(0)">Edit so</a></li>
            </ol>

        </div>

        <div class="col-lg-12">
            <div class="card">
                <div class="card-body">
                    <div class="col-lg-12">

                    </div>
                    <div class="basic-form" style="color: black;">
                        <form id="staff_form" autocomplete="off">
                            <div class="form-row">

                                <div class="form-group col-md-4">
                                    <label> so Date *</label>
                                    <input type="date" class="form-control" id="so_date" name="so_date" value="<?php echo $so_date?>" style="border-color: #181f5a;color: black;text-transform: uppercase">
                                    <input type="hidden" class="form-control"  id="api" name="api">
                                    <input type="hidden" class="form-control"  id="old_pa_id" name="old_pa_id">
                                    <input type="hidden" class="form-control"  id="so_id" name="so_id" value="<?php echo $so_id?>">
                                    <input type="hidden" class="form-control"  id="add_id" name="add_id" value="0">
                                </div>
                                <div class="form-group col-md-4">
                                    <label> PO No *</label>
                                    <input type="text" class="form-control" placeholder="PO No" id="po_no" name="po_no" value="<?php echo $po_no?>" style="border-color: #181f5a;color: black;text-transform: uppercase">
                                </div>
                                <div class="form-group col-md-4">
                                    <label> PO Date *</label>
                                    <input type="date" class="form-control" id="po_date" name="po_date" value="<?php echo $po_date?>"  style="border-color: #181f5a;color: black;text-transform: uppercase">
                                </div>
                                <div class="form-group col-md-4">
                                    <label for="customer">customer *</label>
                                    <select data-search="true" class="form-control js-example-disabled-results tail-select w-full" id="customer" name="customer" style="border-color: #181f5a; color: black" onclick="customerfun(this.value)">
                                        <option value="">Select customer</option>
                                        <?php
                                        $sqlcustomer = "SELECT * FROM `customer`";
                                        $resultcustomer = mysqli_query($conn, $sqlcustomer);

                                        if (mysqli_num_rows($resultcustomer) > 0) {
                                            while ($rowcustomer = mysqli_fetch_array($resultcustomer)) {
                                                $selected = ($customer == $rowcustomer['customer_id']) ? 'selected' : '';
                                                ?>
                                                <option value='<?php echo $rowcustomer['customer_id'].'_'.$rowcustomer['supply_place']; ?>' <?php echo $selected; ?>>
                                                    <?php echo strtoupper($rowcustomer['customer_name']); ?>
                                                </option>
                                                <?php
                                            }
                                        }
                                        ?>
                                    </select>
                                </div>


                                <div class="form-group col-md-4">
                                    <label>Payment terms *</label>
                                    <select data-search="true" class="form-control tail-select w-full" id="payment_terms" name="payment_terms"  style="border-color: #181f5a;color: black">
                                        <option value='' <?php echo ($payment_terms == '') ? 'selected' : ''; ?>>Select Status</option>
                                        <option value='0' <?php echo ($payment_terms == '0') ? 'selected' : ''; ?>>Immidiate</option>
                                        <option value='15' <?php echo ($payment_terms == '15') ? 'selected' : ''; ?>>15 Days</option>
                                        <option value='30' <?php echo ($payment_terms == '30') ? 'selected' : ''; ?>>30 Days</option>
                                        <option value='45' <?php echo ($payment_terms == '45') ? 'selected' : ''; ?>>45 Days</option>
                                        <option value='60' <?php echo ($payment_terms == '60') ? 'selected' : ''; ?>>60 Days</option>
                                        <option value='75' <?php echo ($payment_terms == '75') ? 'selected' : ''; ?>>75 Days</option>
                                        <option value='90' <?php echo ($payment_terms == '90') ? 'selected' : ''; ?>>90 Days</option>
                                        <option value='105' <?php echo ($payment_terms == '105') ? 'selected' : ''; ?>>105 Days</option>
                                        <option value='120' <?php echo ($payment_terms == '120') ? 'selected' : ''; ?>>120 Days</option>

                                    </select>
                                </div>
                                <div class="form-group col-md-4">
                                    <label>Due Date *</label>
                                    <input type="date" class="form-control" id="d_date" name="d_date" value="<?php echo $due_date?>" style="border-color: #181f5a;color: black;text-transform: uppercase">
                                </div>
                                <div class="form-group col-md-12">
                                    <label> Search Product </label>
                                    <input type="text" class="form-control"  id="productName" name="productName" placeholder="Search Product" style="border-color: #181f5a;color: black;text-transform: uppercase">
                                    <ul class="productListUl" id="productListUl" style="display: none">
                                    </ul>
                                </div>
                                <div class="form-group col-md-12" style="font-size: 15px">
                                    <h5>Order items </h5>
                                    <div class="table-responsive">
                                        <table class="table table-hover">
                                            <thead class="bg-gray-300">
                                            <tr><th scope="col">#</th>
                                                <th scope="col">Product Id</th>
                                                <th scope="col"> Code</th>
                                                <th scope="col">Name</th>
                                                <th scope="col">Price</th>
                                                <th scope="col">Stock</th>
                                                <th scope="col">Unit</th>
                                                <th scope="col">Quantity</th>
                                                <th scope="col">Discount(%)</th>
                                                <th scope="col">Discount Value</th>
                                                <th scope="col">Tax(%)</th>
                                                <th scope="col">Tax Value</th>
                                                <th scope="col">Subtotal</th>
                                                <th scope="col">Edit</th>
                                                <th scope="col">Delete</th>
                                            </tr>
                                            </thead>
                                            <tbody id="tb">
                                            <?php
                                            $sql = "SELECT * FROM so_details WHERE so_id ='$so_id'";
                                            $result = mysqli_query($conn, $sql);
                                            $product_ids = "";
                                            $product_obj = "";
                                            $sNo = 0;
                                            if (mysqli_num_rows($result)>0) {

                                                while($row = mysqli_fetch_assoc($result)) {

                                                    $sNo++;
                                                    $so_id=$row['so_id'];
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

                                                    $product_ids .= $row['product_id'].",";
                                                    $taxValues = (18/100) * intval($unit_cost);

                                                    $product_objs .= "$product_id,$unit_cost,$qty,$discount1,$discount_Type,$tax_value,$unit,$results"."#";

//                                                    if($discount_Type == 1){
//                                                        $persymbl = '%';
//                                                    }
//                                                    elseif ($discount_Type == 2){
//                                                        $persymbl = '';
//                                                    }
                                                    $sqlProduct = "SELECT * FROM product WHERE product_id ='$product_id'";
                                                    $resProduct = mysqli_query($conn, $sqlProduct);
                                                    $rowProduct = mysqli_fetch_assoc($resProduct);
                                                    $stock_qty =  $rowProduct['stock_qty'];
                                                    $product_unit =  $rowProduct['product_unit'];
                                                    ?>
                                                    <tr>
                                                        <td><?php echo $sNo;?></td>
                                                        <td><?php echo $product_id?></td>
                                                        <td><?php echo $product_code?></td>
                                                        <td><?php echo $product_name?></td>
                                                        <td id="<?php echo $product_id.'_price'?>"><?php echo $unit_cost?></td>

                                                        <td>
                                                            <span id="<?php echo $product_id . '_stkidv' ?>"><?php echo $stock_qty ?></span>
                                                            <span id="<?php echo $product_id . '_stkidu' ?>">-<?php echo $product_unit ?></span>
                                                        </td>

                                                        <td id="<?php echo $product_id.'_bunit'?>"><?php echo $unit?></td>
                                                        <td id="<?php echo $product_id.'_quantity'?>"><?php echo $qty?></td>
                                                        <td>
                                                            <span id="<?php echo $product_id.'_dis' ?>"><?php echo $discount1?></span>
                                                            <span id="<?php echo $product_id.'_psym'?>"><?php echo $dis_symbl?></span>
                                                            <!--    <span>/</span>-->
                                                            <!--     <span id="--><?php //echo $product_id.'_disPercentage' ?><!--">0</span>-->
                                                        </td>
                                                        <td><span id="<?php echo $product_id.'_disPercentage' ?>"><?php echo round($discount_value)?></span></td>
                                                        <td><span id="<?php echo $product_id.'_tax' ?>"><?php echo $tax?></span></td>
                                                        <td><span id="<?php echo $product_id.'_taxValue' ?>"><?php echo round($tax_value)?></span></td>
                                                        <td id="<?php echo $product_id.'_totAmout' ?>"><?php echo round($sub_total)?></td>
                                                        <td style="display: none">
                                                            <input type="text" id="<?php echo $product_id.'_descrip' ?>">
                                                            <input type="text" id="<?php echo $product_id.'_description' ?>">
                                                        </td>
                                                        <td>
                                                            <i data-toggle="modal" data-target="#sale_list" onclick="editTitle('<?php echo $product_id; ?>')" class="fa fa-edit edit-icon" style="cursor: pointer;"></i>
                                                        </td>
                                                        <td>
                                                            <i class="fa fa-trash trash-icon" style="cursor: pointer;" onclick="removeProduct(this, '<?php echo $product_id; ?>')"></i>
                                                        </td>
                                                    </tr>
                                                <?php } }
                                            $product_objss = rtrim($product_objs, "#");
                                            $product_idss = rtrim($product_ids, ",");
                                            ?>
                                            </tbody>

                                        </table>
                                    </div>
                                </div>

                                <div class="form-group col-md-4">
                                    <label>Discount </label>
                                    <input type="number" class="form-control" placeholder="Discount" id="discount" name="discount" value="<?php echo $discountss?>" onkeyup="totalDiscount()" style="border-color: #181f5a;color: black">
                                    <!--                                    onkeyup="this.value = fnc(this.value, 0, 100)"-->
                                </div>
                                <div class="form-group col-md-4">
                                    <label>TDS </label>
                                    <input type="number" class="form-control" placeholder="TDS" id="tds" name="tds" value="<?php echo $tds?>" onkeyup="totalDiscount()" style="border-color: #181f5a;color: black">
                                    <!--                                    onkeyup="this.value = fnc(this.value, 0, 100)"-->
                                </div>
                                <div class="form-group col-md-4">
                                    <label>Total Tax </label>
                                    <input type="number" class="form-control" placeholder="Tax" id="tax" name="tax" readonly style="border-color: #181f5a;color: black">
                                </div>
                                <div class="form-group col-md-4">
                                    <label>Grand Total </label>
                                    <input type="number" class="form-control" placeholder="Grand Total" id="grand_total" name="grand_total"  value="<?php echo $grand_total?>" readonly style="border-color: #181f5a;color: black">
                                </div>
                                <div class="form-group col-md-4">
                                    <label> Status *</label>
                                    <select data-search="true" class="form-control tail-select w-full" id="payment_status" name="payment_status" style="border-color: #181f5a;color: black">
                                        <option value='' <?php echo ($status == '') ? 'selected' : ''; ?>>Select Status</option>
                                        <option value='1' <?php echo ($status == '1') ? 'selected' : ''; ?>>Received</option>
                                        <option value='2' <?php echo ($status == '2') ? 'selected' : ''; ?>>Partially Pending</option>
                                        <option value='3' <?php echo ($status == '3') ? 'selected' : ''; ?>>Pending</option>
                                        <option value='4' <?php echo ($status == '4') ? 'selected' : ''; ?>>Odered</option>

                                    </select>
                                </div>
                                <div class="form-group col-md-4">
                                    <label for="status">Payment Status *</label>
                                    <select data-search="true" class="form-control tail-select w-full" id="status" name="status" style="border-color: #181f5a; color: black">
                                        <option value='' <?php echo ($payment_status == '') ? 'selected' : ''; ?>>Select Status</option>
                                        <option value='1' <?php echo ($payment_status == '1') ? 'selected' : ''; ?>>Paid</option>
                                        <option value='2' <?php echo ($payment_status == '2') ? 'selected' : ''; ?>>Partially Paid</option>
                                        <option value='3' <?php echo ($payment_status == '3') ? 'selected' : ''; ?>>Unpaid</option>
                                    </select>
                                </div>

                                <div class="form-group col-md-4">
                                    <label>E-way Bill </label>
                                    <input type="text" class="form-control" placeholder="E-way Bill " id="e_way" name="e_way" value="<?php echo $e_way?>"  style="border-color: #181f5a;color: black">
                                </div>

                                <div class="form-group col-md-6">
                                    <label>Notes </label>
                                    <input type="text" class="form-control" placeholder="Notes" id="notes" name="notes" value="<?php echo $notes?>" style="border-color: #181f5a;color: black">
                                    <!--   <textarea class="form-control" placeholder="Notes" id="notes" name="notes" rows="4" cols="50" style="border-color: #181f5a;color: black"></textarea>-->
                                </div>

                            </div>
                        </form>
                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-danger light" data-dismiss="modal" onclick="navigateToPage()"style="background-color: red; color: white;text-transform: uppercase">Close</button>
                        <!--                        --><?php
                        //                        if($_COOKIE['role'] == 'Super Admin'){
                        //                            ?>
<!--                        <button type="button" class="btn btn-succes" id="verify_btn" onclick= "approve()" style="background-color: green; color: white;">Approve</button>-->
                        <!--                            --><?php
                        //                        }
                        //                        ?>
                        <button type="button" class="btn btn-primary" id="add_btn">ADD</button>
                    </div>

                </div>
            </div>
        </div>

        <div class="modal fade" id="sale_list"  data-keyboard="false" data-backdrop="static">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="titles">Unit</h5>
                        <button type="button" class="close" data-dismiss="modal"><span>&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="basic-form" style="color: black;">
                            <form id="purchase_form" autocomplete="off">
                                <div class="form-row">

                                    <div class="form-group col-md-12">
                                        <!--                                        <label>product Id </label>-->
                                        <input type="hidden" class="form-control" placeholder="Product Id" id="p_id" name="p_id" style="border-color: #181f5a;color: black;text-transform: uppercase">
                                        <input type="hidden" class="form-control"  id="api" name="api">
                                        <input type="hidden" class="form-control"  id="old_pa_id" name="old_pa_id">
                                        <input type="hidden" class="form-control"  id="edit_id" name="edit_id">
                                    </div>
                                    <div class="form-group col-md-12">
                                        <label> Quantity * </label>
                                        <input type="number" class="form-control" id="qtys" name="qtys" value="1" style="border-color: #181f5a;color: black;text-transform: uppercase">
                                    </div>
                                    <div class="form-group col-md-12">
                                        <label>Product Unit *</label>
                                        <select data-search="true" class="form-control tail-select w-full" id="unit" name="unit" style="border-color: #181f5a;color: black">
                                            <option value=""> Select Unit</option>
                                            <?php
                                            $sqlUnit = "SELECT * FROM `unit`";
                                            $resultUnit = mysqli_query($conn, $sqlUnit);
                                            if (mysqli_num_rows($resultUnit) > 0) {
                                                while ($rowUnit = mysqli_fetch_array($resultUnit)) {
                                                    ?>
                                                    <option
                                                            value='<?php echo $rowUnit['unit_subname']; ?>'><?php echo strtoupper($rowUnit['unit_name']); ?></option>
                                                    <?php
                                                }
                                            }
                                            ?>

                                        </select>
                                    </div>
                                    <div class="form-group col-md-12">
                                        <label>Discount Type </label>
                                        <select data-search="true" class="form-control tail-select w-full" id="type" name="type" style="border-color: #181f5a;color: black">
                                            <option value='1'>Percentage</option>
                                            <option value='2'>Fixed</option>

                                        </select>
                                    </div>
                                    <div class="form-group col-md-12">
                                        <label>Discount *</label>
                                        <input type="number" class="form-control" placeholder="Discount" id="dis" name="dis" value="0" style="border-color: #181f5a;color: black">
                                    </div>
                                    <div class="form-group col-md-12">
                                        <label>Tax (%)</label>
                                        <select  class="form-control" id="tax_type" name="tax_type" style="border-color: #181f5a;color: black">
                                            <option value=18>18%</option>
                                            <option value=12>12%</option>
                                            <option value=5>5%</option>
                                            <option value=0>0%</option>
                                        </select>
                                    </div>
                                    <div class="form-group col-md-12">
                                        <label>Description </label>
                                        <input type="text" class="form-control" placeholder="Description" id="desc" name="desc" style="border-color: #181f5a;color: black">
                                    </div>
                                    <div class="form-group col-md-12" style="display: none">
                                        <label>Stock </label>
                                        <input type="text" class="form-control" placeholder="Stock" id="stk" name="stk" style="border-color: #181f5a;color: black">
                                    </div>

                                </div>
                            </form>
                        </div>


                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-danger light" data-dismiss="modal" style="background-color: red; color: white;">Close</button>
                        <button type="button" class="btn btn-primary" id="addbtn">Save</button>
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

<script src="../vendor/select2/js/select2.full.min.js"></script>
<script src="../js/plugins-init/select2-init.js"></script>

<script>
    function navigateToPage() {
        window.location.href = "<?php echo $website; ?>/so/";
    }
    //due date
    $(document).ready(function() {
        $("#payment_terms").change(function() {
            const inputDateValue = document.getElementById("so_date").value;
            const payment_days = parseInt(document.getElementById("payment_terms").value);
            if (!isNaN(payment_days)) {
                const d = new Date(inputDateValue);
                d.setDate(d.getDate() + payment_days);
                const formattedDate = d.toISOString().split('T')[0];
                $('#d_date').val(formattedDate);
            }
        });
    });
</script>
<script>

    const productSearch = document.getElementById("productName");
    const productListUl =  document.getElementById("productListUl");
    const grand_total =  document.getElementById("grand_total");
    const discount =  document.getElementById("discount");
    const shipping =  document.getElementById("shipping");
    const order_tax =  document.getElementById("order_tax");


    var pro_obj = '<?php echo $product_objss?>';
    console.log(pro_obj);
    var pro_objs =  pro_obj .split("#");

    const productDetailArr = [];

    for(let q=0;q<pro_objs.length;q++){

        var pro_objes =  pro_objs[q].split(",");
        let product_obje = {
            product_id : pro_objes[0],
            price: Number(pro_objes[1]),
            qty: Number(pro_objes[2]),
            dis: Number(pro_objes[3]),
            disType: Number(pro_objes[4]),
            tax: Number(pro_objes[5]),
            unit: pro_objes[6],
            taxes: Number(pro_objes[7])
        };

        productDetailArr.push(product_obje);
    }

    console.log(productDetailArr);
    grandTotalCal(productDetailArr);


    //overall discount-grandtotal
    function totalDiscount(){
        var totaldiscount = grandTotalCal(productDetailArr);

        var g_total =  document.getElementById("grand_total").value;
        var discount_value =  document.getElementById("discount").value;
        var tds_value =  document.getElementById("tds").value;
        if(discount_value == ''){
            discount_value =0;
        }
        else{
            discount_value =discount_value;
        }
        if(tds_value == ''){
            tds_value =0;
        }
        else{
            tds_value =tds_value;
        }
        console.log(discount_value);
        console.log(tds_value);
        var tds_dis = Number(discount_value) + Number(tds_value);
        if(tds_dis > g_total){
            alert("tds / discount value higher than grand total");
        }
        else{
            grand_total.value = Number(g_total) - Number(tds_dis);
        }
        console.log(tds_dis);
        console.log(grand_total.value);
        g_total = g_total-discount_value;
        // grand_total.value = totaldiscount - ((a/100) * totaldiscount);
        // grand_total.value = totaldiscount - a;
    }


    totalDiscount();
    //Edit Product tax and discount
    function editTitle(data) {
        $('#purchase_form')[0].reset();
        var edit_model_title = "Edit So - "+data;

        let QUANTITY = document.getElementById(`${data}_quantity`).innerHTML;
        document.getElementById('qtys').value = Number(QUANTITY);

        let UNITS = document.getElementById(`${data}_bunit`).innerHTML;
        document.getElementById('unit').value = UNITS;
        $('#unit').trigger("change");
        console.log(UNITS);

        let DISCOUNTS = document.getElementById(`${data}_dis`).innerHTML;
        document.getElementById('dis').value = Number(DISCOUNTS);

        let DESCIPTIONS = document.getElementById(`${data}_description`).value;
        document.getElementById('desc').value = DESCIPTIONS;
        console.log(DESCIPTIONS);

        let STOCK = document.getElementById(`${data}_stkidv`).innerHTML;
        document.getElementById('stk').value = STOCK;
        console.log(STOCK);

        let obj = productDetailArr.find(o => o.product_id ===data);
        let TAX = obj.taxes;
        document.getElementById('tax_type').value = TAX;
        $('#tax_type').trigger("change");

        let dissym = document.getElementById(`${data}_psym`).innerHTML;
        // document.getElementById('type').value = dissym;
        // $('#type').trigger("change");
        if(dissym == '%'){
            document.getElementById('type').value = 1;
            $('#type').trigger("change");
        }
        else{
            document.getElementById('type').value = 2;
            $('#type').trigger("change");
        }
        console.log(dissym);

        $('#titles').html(edit_model_title);
        $('#addbtn').html("Save");
        $('#p_id').val(data);
        $('#sale_list').modal('show');

    }
    //to edit validate form
    $("#purchase_form").validate(
        {
            ignore: '.ignore',
            // Specify validation rules
            rules: {
                qtys: {
                    required: true
                },
                unit: {
                    required: true
                },
                dis: {
                    required: true
                },
            },
            messages: {
                qtys: "*This field is required",
                unit: "*This field is required",
                dis: "*This field is required",
            }
        });
    $('#addbtn').click(function () {
        if ($("#purchase_form").valid()) {
            const p_id = $('#p_id').val();
            const qtys = $('#qtys').val();
            const unit = $('#unit').val();
            const dis = Number($('#dis').val());
            const type = Number($('#type').val());
            const tax_type = Number($('#tax_type').val());
            const desc = $('#desc').val();
            const stk = $('#stk').val();

            let showAlert = false;  // Flag to show alert message

            if (unit === "MT") {
                let stkxqty = qtys * 1000;
                if (stk < stkxqty) {
                    showAlert = true;
                }
            } else if (unit === "bgs") {
                let stkxqty = qtys * 25;
                if (stk < stkxqty) {
                    showAlert = true;
                }
            } else if (unit === "mm") {
                let stkxqty = qtys * 12;
                if (stk < stkxqty) {
                    showAlert = true;
                }
            } else {
                let stkxqty = qtys;
                if (stk < stkxqty) {
                    showAlert = true;
                }
            }

            if (showAlert) {
                Swal.fire({
                    icon: 'error',
                    title: 'Stock is less than Quantity',
                    text: '',
                    confirmButtonText: 'OK'
                });
                return false;  // Exit the function without executing further code
            }
            const customer =  document.getElementById("customer").value;

            let customerArray = customer.split("_");
            console.log(customerArray[1]);
            console.log(customer);
            // if(gArray.length > 0){
            //     for(let i =0; i<gArray.length; i++){
            //         let obj = productDetailArr.find(o => o.product_id === gArray[i]);
            let txs = tax_type/2;
            if(customerArray[1] == 'Tamil Nadu') {
                $(`#${p_id}_tax`).text(`CGST - ${txs}%  SGST - ${txs}%`);
            }else{
                // document.getElementById(gArray[i] + "_tax").innerHTML = `IGST - ${tax_type}%`;
                $(`#${p_id}_tax`).text(`IGST - ${tax_type}%`);

            }
            //     }
            // }

            $(`#${p_id}_descrip`).text(desc);
            $(`#${p_id}_description`).val(desc);
            $(`#${p_id}_quantity`).text(qtys);
            // $(`#${p_id}_tax`).text(tax_type + '%');
            $(`#${p_id}_bunit`).text(unit);
            $('#purchase_form')[0].reset();


            // Update discount and tax elements
            $(`#${p_id}_dis`).text(dis);

            if (type == 1) {
                $(`#${p_id}_psym`).text('%'); // Set text to '%'
            } else if (type == 2) {
                $(`#${p_id}_psym`).text('₹'); // Set text to '₹'
            }


            // Get current total amount
            const subTotElement = document.getElementById(`${p_id}_totAmout`);
            const disPercentage = document.getElementById(`${p_id}_disPercentage`);


            let obj = productDetailArr.find(o => o.product_id === p_id);

            // let subTot = obj.price * qtys;
            let subTot;
            let subtotal_values;
            let subtotal_final;
            let disval_final;
            if (unit === "MT") {
                subTot = obj.price * (qtys * 1000);

                if (type == 1) {
                    subtotal_values = obj.price - ((dis / 100) * obj.price);

                } else if (type == 2) {
                    subtotal_values = obj.price - dis ;

                }
                subtotal_final = subtotal_values * (qtys * 1000);
                disval_final =  obj.price - subtotal_values;
                //changes
                obj.tax = ((tax_type/100) * Number(obj.price)) * (1000*qtys);

            }
            else if(unit === "bgs"){
                subTot = obj.price * (qtys * 25);

                if (type == 1) {
                    subtotal_values = obj.price - ((dis / 100) * obj.price);

                } else if (type == 2) {
                    subtotal_values = obj.price - dis ;

                }
                subtotal_final = subtotal_values * (qtys * 25);
                disval_final =  obj.price - subtotal_values;

                //changes
                obj.tax = ((tax_type/100) * Number(obj.price)) * (25*qtys);
            }
            else if(unit === "mm"){
                subTot = obj.price * (qtys * 12);

                if (type == 1) {
                    subtotal_values = obj.price - ((dis / 100) * obj.price);

                } else if (type == 2) {
                    subtotal_values = obj.price - dis ;

                }


                subtotal_final = subtotal_values * (qtys * 12);
                disval_final =  obj.price - subtotal_values;

                //changes
                obj.tax = ((tax_type/100) * Number(obj.price)) * (12*qtys);
            }
            else {
                subTot = obj.price * qtys;

                if (type == 1) {
                    subtotal_values = obj.price - ((dis / 100) * obj.price);

                } else if (type == 2) {
                    subtotal_values = obj.price - dis ;

                }


                subtotal_final = subtotal_values * qtys;
                disval_final =  obj.price - subtotal_values;

                //changes
                obj.tax = ((tax_type/100) * Number(obj.price * qtys));

            }

            var discountAmount;
            var discountAmounts;
            if (type == 1) {
                // discountAmount = (subTot * dis) / 100;


                //  discountAmount = obj.price - ((dis / 100) * obj.price);


                discountAmount = subTot - ((dis / 100) * subTot);
                discountAmounts = subTot - discountAmount;

            } else if (type == 2) {
                discountAmount = subTot - dis;
                // discountAmounts = discountAmount;
                discountAmounts = dis;

            }

            subTotElement.innerHTML = Math.round(subtotal_final);
            // subTotElement.innerHTML = Math.round(discountAmount);
            disPercentage.innerHTML = Math.round(disval_final);
            // disPercentage.innerHTML = Math.round(discountAmounts);
            //changes
            $(`#${p_id}_taxValue`).text(Math.round(obj.tax));
            // $(`#${p_id}_taxValue`).text(Math.round(qtys * obj.tax));
            console.log(Math.round(discountAmount));
            obj.dis = dis;
            // obj.dis_type = type;
            obj.disType = type;
            obj.qty = qtys;
            obj.unit = unit;
            obj.taxes = tax_type;


            grandTotalCal(productDetailArr);
            totalDiscount();
            $('#sale_list').modal('hide');
        }
    });

    //to validate form
    $("#staff_form").validate(
        {
            ignore: '.ignore',
            // Specify validation rules
            rules: {
                so_date: {
                    required: true
                },
                d_date: {
                    required: true
                },
                customer: {
                    required: true
                },
                product_name: {
                    required: true
                },
                payment_terms: {
                    required: true
                },
                grand_total: {
                    required: true
                },
                po_date: {
                    required: true
                },
                po_no: {
                    required: true
                },
                // notes: {
                //     required: true
                // },



            },
            // Specify validation error messages
            messages: {
                so_date: "*This field is required",
                d_date: "*This field is required",
                customer: "*This field is required",
                product_name: "*This field is required",
                payment_status: "*This field is required",
                status: "*This field is required",
                payment_terms: "*This field is required",
                grand_total: "*This field is required",
                po_date: "*This field is required",
                po_no: "*This field is required",
                notes: "*This field is required",
            }
            // Make sure the form is submitted to the destination defined
        });

    //add data

    $('#add_btn').click(function () {
        $("#staff_form").valid();
        if($("#staff_form").valid()==true) {
            // var api = $('#api').val();

            this.disabled = true;
            this.innerHTML = '<i class="fa fa-spinner fa-spin"></i>';

            const tableRows = document.getElementById("tb").getElementsByTagName("tr");
            const rowDataArray = [];

            for (let i = 0; i < tableRows.length; i++) {
                const row = tableRows[i];
                const productId = row.cells[1].textContent;
                const tax = row.cells[10].querySelector('#' + productId + '_tax');
                // const productDesc = row.cells[9].querySelector('#' + productId + '_descrip');
                const discountSpan = row.cells[8].querySelector('#' + productId + '_dis');
                const persymblSpan = row.cells[8].querySelector('#' + productId + '_psym');
                const stockuSpan = row.cells[5].querySelector('#' + productId + '_stkidu');
                const stockvSpan = row.cells[5].querySelector('#' + productId + '_stkidv');
                const rowData = {
                    sNo: row.cells[0].textContent,
                    // productId: row.cells[1].textContent,
                    productId: productId,
                    productCode: row.cells[2].textContent,
                    productName: row.cells[3].textContent,
                    netUnitCost: row.cells[4].textContent,
                    // stock: row.cells[4].textContent,
                    stockUnit: stockuSpan.textContent,
                    stockValue: stockvSpan.textContent,
                    unit: row.cells[6].textContent,
                    quantity: row.cells[7].textContent,
                    // discount: row.cells[7].textContent,
                    persymbl: persymblSpan.textContent,
                    discount: discountSpan.textContent,
                    discount_value: row.cells[9].textContent,
                    tax: tax.textContent,
                    // tax: row.cells[9].textContent,
                    tax_value: row.cells[11].textContent,
                    subtotal: row.cells[12].textContent,
                    productDesc: row.cells[13].textContent,
                    // productDesc: productDesc.textContent,
                    // Add other fields if needed
                };
                console.log(row.cells[12]);

                rowDataArray.push(rowData);


            }
            console.log(rowDataArray);
            $.ajax({

                type: "POST",
                url: "edit_api.php",
                data: $('#staff_form').serialize() + "&tableData=" + JSON.stringify(rowDataArray),

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
                                // window.window.location.reload();
                                window.location.href = "<?php echo $website; ?>/so/all_so.php";
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
                error: function (error) {
                    console.error("Error sending data:", error);
                }
            });

        } else {
            document.getElementById("add_btn").disabled = false;
            document.getElementById("add_btn").innerHTML = 'Add';

        }

    });


    $( document ).ready(function() {
        $('#search').val('<?php echo $search;?>');
        $('#branch_nameS').val('<?php echo $branch_nameS;?>');

        $("#product_name").change(function(){
            $('#product_name').val(''); // Clears the value of the input field
        });

    });
    var $disabledResults = $(".js-example-disabled-results");
    $disabledResults.select2();



    $(document).ready(function() {
        $('#productName').keyup(function(){
            $('#productListUl').empty();

            let valueProduct = this.value;

            if(valueProduct.length >= 1){
                $.ajax({
                    type: "POST",
                    url: "product_api.php",
                    data: 'product_id=' + valueProduct,
                    dataType: "json",
                    success: function (res) {
                        if (res.status == 'success') {
                            $('#productListUl').empty();

                            var product_id = res.product_id;
                            var product_name = res.product_name;
                            var product_price = res.product_price;
                            var product_stock = res.product_stock;
                            var product_tax = res.product_tax;
                            var product_unit = res.product_unit;
                            var product_varient = res.product_varient;
                            var product_code = res.product_code;
                            var product_brand = res.product_brand;

                            for(let i=0;i<product_id.length;i++){
                                const listUL = document.createElement("li");
                                listUL.innerHTML = `${product_name[i]} / ${product_code[i]} / ${product_brand[i]} / ${product_varient[i]}`; // Displaying variant names
                                listUL.setAttribute("onclick",`tableBuild("${product_id[i]}","${product_price[i]}","${product_name[i]}","${product_stock[i]}","${product_tax[i]}","${product_unit[i]}","${product_code[i]}")`);
                                listUL.style.cursor = "pointer";
                                productListUl.append(listUL);
                            }

                            productListUl.style.display = "block";
                            $('#product_name').val('');

                        } else if (res.status == 'failure') {
                            Swal.fire({
                                title: "Failure",
                                text: "No Products",
                                icon: "warning",
                                button: "OK",
                                allowOutsideClick: false,
                                allowEscapeKey: false,
                                closeOnClickOutside: false,
                            }).then((value) => {
                                $('#productListUl').empty();

                            });
                        }
                    },
                    error: function () {
                        Swal.fire("Check your network connection");
                    }
                });
            }
        });
    });


    var pro  = '<?php echo $product_idss?>';
    var pro_id =  pro .split(",");

    var gArray = [...pro_id];
    // gArray.push(pro_id);
    console.log(gArray);
    console.log(pro_id);
    var rowCounter = <?php echo $sNo?>;


    function tableBuild(product_id,product_price,product_name,product_stock,product_tax,product_unit,product_code) {
        var supply  = document.getElementById('customer').value;

        const myArray = supply.split("_");
        console.log(myArray);
        if(!gArray.includes(product_id)) {

            const tb = document.getElementById("tb");
            const tr = document.createElement("tr");
            rowCounter++;
            let productDetails = [];
            productDetails.push(product_id);
            productDetails.push(product_code);
            productDetails.push(product_name);
            productDetails.push(product_price);
            productDetails.push(product_stock);
            productDetails.push(product_unit);



            const sNo = document.createElement("td");
            sNo.innerHTML = rowCounter;
            tr.append(sNo);
            tb.append(tr);

            for (let i = 0; i < 6; i++) {
                const td = document.createElement("td");
                if (i === 4) {
                    const stockSpan = document.createElement("span");
                    stockSpan.setAttribute("id", `${product_id}_stkidv`);
                    stockSpan.innerHTML = productDetails[i];
                    td.append(stockSpan);

                    const idSpan = document.createElement("span");
                    idSpan.setAttribute("id", `${product_id}_stkidu`);
                    idSpan.innerHTML = "-" + product_unit;
                    td.append(idSpan);
                }
                else {
                    td.innerHTML = productDetails[i];
                }
                if (i === 3) {
                    td.setAttribute("id", `${product_id}_price`);
                }
                if (i === 5) {
                    td.setAttribute("id", `${product_id}_bunit`);
                }

                tr.append(td);
            }

            tb.append(tr);

            const quantity = document.createElement("td");
            quantity.setAttribute("id", `${product_id}_quantity`);
            quantity.innerHTML = 1;
            tr.appendChild(quantity);
            tb.append(tr);


            const discount = document.createElement("td");

            const discountValue = document.createElement('span');
            discountValue.innerHTML = '0';
            discountValue.setAttribute('id', `${product_id}_dis`);
            discount.appendChild(discountValue);

            const percentageSpan = document.createElement('span');
            percentageSpan.innerHTML = '%'; // Set text content to '%'
            percentageSpan.setAttribute('id', `${product_id}_psym`);
            discount.appendChild(percentageSpan);

            tr.append(discount);
            tb.append(tr);



            const discountPer = document.createElement("td");
            const discountPercentage = document.createElement('span');
            discountPercentage.innerHTML = 0; // Assuming percentage, adjust as needed
            discountPercentage.setAttribute('id', `${product_id}_disPercentage`);
            discountPer.appendChild(discountPercentage);
            tr.append(discountPer);
            tb.append(tr);

            const tax = document.createElement("td");
            const inputtax = document.createElement('span');
            // if(myArray[2]=='India'){
            if(myArray[1] == "Tamil Nadu"){
                // inputtax.innerHTML = `CGST - 9% <br> SGST - 9%`;
                let p_tax = product_tax/2;
                inputtax.innerHTML = `CGST - ${p_tax}% <br> SGST - ${p_tax}%`;
            }else{
                // inputtax.innerHTML = `IGST - 18%`;
                inputtax.innerHTML = `IGST - ${product_tax}%`;
            }
            // }
            // else{
            //     let other = 0;
            //     inputtax.innerHTML = `IGST - ${other}%`;
            //     product_tax = 0;
            // }

            inputtax.setAttribute('id', `${product_id}_tax`);
            tax.appendChild(inputtax);
            // const description = document.createElement('span');
            // description.innerHTML = ''; // Set text content to '%'
            // description.setAttribute('id', `${product_id}_descrip`);
            // description.setAttribute('style', `display:none`);
            // tax.appendChild(description);
            tr.append(tax);
            tb.append(tr);
            //changes
            let taxValues;
            if(product_unit == "MT"){
                taxValues = ((product_tax/100) * Number(product_price)) * 1000;

            }
            else if(product_unit == "bgs"){
                taxValues = ((product_tax/100) * Number(product_price)) * 25;
            }
            else if(product_unit == "mm"){
                taxValues = ((product_tax/100) * Number(product_price)) * 12;
            }
            else{
                taxValues = (product_tax/100) * Number(product_price);

            }


            const taxvalue = document.createElement("td");
            const inputtaxval = document.createElement('span');
            inputtaxval.innerHTML = Math.round(taxValues);
            inputtaxval.setAttribute('id', `${product_id}_taxValue`);
            taxvalue.appendChild(inputtaxval);
            tr.append(taxvalue);
            tb.append(tr);

            let subTotal;
            if(product_unit == "MT"){
                subTotal = Number(product_price) * 1000;

            }
            else if(product_unit == "bgs"){
                subTotal = Number(product_price) * 25;
            }
            else if(product_unit == "mm"){
                subTotal = Number(product_price) * 12;
            }
            else{
                subTotal = Number(product_price);
            }

            const total = document.createElement("td");
            let quantitys = $('.quantity-input').val('');
            let sub_total = Number(product_price) * 1;
            total.setAttribute('id', `${product_id}_totAmout`);
            total.innerHTML = Math.round(subTotal);
            $('#grand_total').val(sub_total);
            tr.append(total);

            const description = document.createElement("td");
            const desinput = document.createElement("input");
            const descriptionInput = document.createElement("input");
            desinput.innerHTML = '';
            desinput.setAttribute('id', `${product_id}_descrip`);
            descriptionInput.setAttribute('id', `${product_id}_description`);
            descriptionInput.setAttribute('type', `text`);
            description.appendChild(desinput);
            description.appendChild(descriptionInput);
            description.setAttribute('style', 'display: none');
            tr.append(description);
            tb.append(tr);

            const editCell = document.createElement("td");
            const editIcon = document.createElement("i");
            editIcon.setAttribute('data-toggle', `modal`);
            editIcon.setAttribute('data-target', `#sale_list`);
            editIcon.setAttribute('onclick', `editTitle("${product_id}")`);
            editIcon.classList.add("fa", "fa-edit", "edit-icon");
            editIcon.style.cursor = "pointer";

            editCell.appendChild(editIcon);
            tr.appendChild(editCell);
            tb.appendChild(tr);


            const trashBin = document.createElement("td");
            const trashBinIcon = document.createElement("i");
            trashBinIcon.classList.add("fa", "fa-trash", "trash-icon");
            trashBinIcon.style.cursor = "pointer";
            trashBinIcon.addEventListener("click", function () {
                tr.remove();
            });
            trashBinIcon.setAttribute('onclick', `removeProduct("${product_id}")`);

            trashBin.appendChild(trashBinIcon);
            tr.append(trashBin);

            tb.append(tr);

            productSearch.value = "";
            productListUl.style.display = "none";

            gArray.push(product_id);

            productDetailArr.push({
                product_id : product_id,
                price: product_price,
                qty: 1,
                dis: 0,
                disType: 1,
                tax: taxValues,
                unit: product_unit,
                taxes: product_tax
            });

            grandTotalCal(productDetailArr);

        }
        else {
            Swal.fire({
                title: "Error",
                text: "This product is already added",
                icon: "error",
                button: "OK",
                allowOutsideClick: false,
                allowEscapeKey: false,
                closeOnClickOutside: false,
            })
                .then((value) => {
                    // If needed, you can perform additional actions after the user clicks OK
                });
        }
    }


    function cart(oper,product_id,productprice) {
        const qtySpan = document.getElementById(`${product_id}_qty`);
        const totAmout = document.getElementById(`${product_id}_totAmout`);
        // const totdis = document.getElementById(`${product_id}_dis`);
        const totdisper = document.getElementById(`${product_id}_disPercentage`);
        // const tottax = document.getElementById(`${product_id}_tax`);


        let obj = productDetailArr.find(o => o.product_id === product_id);
        if(oper == "plus"){
            let p  = Number(qtySpan.innerHTML) + 1;
            qtySpan.innerHTML = p;
            obj.qty = p;


            let subTot =  obj.price * obj.qty;

            var discountAmount;
            var discountAmounts;
            if(obj.disType == 1){
                discountAmount = subTot - ((obj.dis/100) * subTot);
                discountAmounts = subTot - discountAmount;
            }else if(obj.disType == 2){
                discountAmount = subTot - obj.dis;
                // discountAmount = discountAmount;
                // discountAmount = obj.dis;
                discountAmounts = obj.dis;
            }
            totdisper.innerHTML =Math.round(discountAmounts);
            totAmout.innerHTML = Math.round(discountAmount + obj.tax);


        } else if (oper == "minus") {
            if (Number(qtySpan.innerHTML) > 1) {
                let m = Number(qtySpan.innerHTML) - 1;
                qtySpan.innerHTML = m;
                obj.qty = m;


                let subTot =  obj.price * obj.qty;

                var discountAmount;
                var discountAmounts;
                if(obj.disType == 1){
                    discountAmount = subTot - ((obj.dis/100) * subTot);
                    discountAmounts = subTot - discountAmount;
                    // discountAmount = (subTot * obj.dis) / 100;
                }else if(obj.disType == 2){
                    discountAmount = subTot - obj.dis;
                    // discountAmount = discountAmount;
                    // discountAmount = obj.dis;
                    discountAmounts = obj.dis;

                }
                totdisper.innerHTML =Math.round(discountAmounts);
                totAmout.innerHTML = Math.round(discountAmount + obj.tax);

                // updateValues();
            }
        }
        grandTotalCal(productDetailArr);

    }




    // function removeProduct(product_id) {
    //
    //     let obj = productDetailArr.findIndex(o => o.product_id === product_id);
    //     productDetailArr.splice(obj,1);
    //     gArray.splice(obj,1);
    //     grandTotalCal(productDetailArr);
    // }
    function removeProduct(iconElement,product_id) {

        let obj = productDetailArr.findIndex(o => o.product_id === product_id);
        productDetailArr.splice(obj,1);
        gArray.splice(obj,1);
        grandTotalCal(productDetailArr);
        const tr = iconElement.closest('tr');
        if (tr) {
            tr.remove();
        } else {
            console.error("Unable to find the table row.");
        }
    }
    function grandTotalCal(productAr){
        let grossPrice = 0;
        let tax_order = 0;

        for(let x=0;x<productAr.length;x++){

            // let subTot =  productAr[x].price * productAr[x].qty;
            let subTot;
            let subtotal_values;
            console.log("qty"+ productAr[x].unit);
            if (productAr[x].unit === "MT") {
                subTot = productAr[x].price * (productAr[x].qty * 1000);
                console.log('test');
                if (productAr[x].disType  == 1) {
                    subtotal_values = (productAr[x].price - ((productAr[x].dis / 100)) * productAr[x].price) * (productAr[x].qty * 1000);

                } else if (productAr[x].disType  == 2) {
                    subtotal_values = (productAr[x].price - productAr[x].dis) * (productAr[x].qty * 1000);

                }
                // subtotal_final = subtotal_values * (productAr[x].qty * 1000);
                // disval_final =  productAr[x].price - subtotal_values;
                //changes
                // productAr[x].tax = ((tax_type/100) * Number(productAr[x].price)) * (1000*productAr[x].qty);

            }
                // if (productAr[x].unit === "MT") {
                //     subTot = productAr[x].price * (productAr[x].qty * 1000);
                //
                //
                //
            // }
            else if (productAr[x].unit === "bgs") {
                subTot = productAr[x].price * (productAr[x].qty * 25);
                if (productAr[x].disType  == 1) {
                    subtotal_values = (productAr[x].price - ((productAr[x].dis / 100)) * productAr[x].price) *  (productAr[x].qty * 25);

                } else if (productAr[x].disType  == 2) {
                    subtotal_values = (productAr[x].price - productAr[x].dis) *  (productAr[x].qty * 25);

                }

            }
            else if (productAr[x].unit === "mm") {
                subTot = productAr[x].price * (productAr[x].qty * 12);
                if (productAr[x].disType  == 1) {
                    subtotal_values = (productAr[x].price - ((productAr[x].dis / 100)) * productAr[x].price) *  (productAr[x].qty * 12);

                } else if (productAr[x].disType  == 2) {
                    subtotal_values = (productAr[x].price - productAr[x].dis) *  (productAr[x].qty * 12);

                }
            }
            else {
                subTot = productAr[x].price * productAr[x].qty;

                if (productAr[x].disType  == 1) {
                    subtotal_values = (productAr[x].price - ((productAr[x].dis / 100)) * productAr[x].price) *  (productAr[x].qty);

                } else if (productAr[x].disType  == 2) {
                    subtotal_values = (productAr[x].price - productAr[x].dis) *  (productAr[x].qty);

                }
                console.log("else"+ productAr[x].qty);
            }
            // tax_order+= productAr[x].qty * productAr[x].tax;
            //change
            tax_order+=  productAr[x].tax;
            // var discountAmount;
            // var discountAmounts;
            // if(productAr[x].disType == 1){
            //     discountAmount = subTot - ((productAr[x].dis/100) * subTot);
            //     console.log("discount");
            //     //discountAmounts = subTot - discountAmount;
            //     // discountAmount = (subTot * productAr[x].dis) / 100;
            // }else if(productAr[x].disType == 2){
            //     discountAmount = subTot - productAr[x].dis;
            //     console.log("Fixed");
            //     //  discountAmount = discountAmounts;
            // }

            // grossPrice += Math.round(subTot);
            grossPrice += Math.round(subtotal_values);


        }
        console.log(grossPrice);
        grand_total.value = grossPrice + Math.round(tax_order);
        document.getElementById("tax").value = Math.round(tax_order);

        return grossPrice + Math.round(tax_order);
        // grand_total.value = grossPrice + (order_tax.value == ''?0:parseFloat(order_tax.value)) +  (shipping.value == ''?0:parseFloat(shipping.value));
    }

    function fnc(value, min, max)
    {
        if(parseInt(value) < 0 || isNaN(value))
            return 0;
        else if(parseInt(value) > 100)
            return "Number is greater than 100";
        else return value;
    }

    function x() {

    }

    function customerfun(a){
        let supplyArray = a.split("_");
        console.log(supplyArray[1]);
        if(gArray.length > 0){
            for(let i =0; i<gArray.length; i++){
                let obj = productDetailArr.find(o => o.product_id === gArray[i]);
                let tx = obj.taxes/2;
                // if(supplyArray[2]=='India'){
                if(supplyArray[1] == 'Tamil Nadu') {
                    // document.getElementById(gArray[i]+"_tax").innerHTML= `CGST -` +tx +`%` <br> `SGST - ` + tx `%`;
                    document.getElementById(gArray[i] + "_tax").innerHTML = `CGST - ${tx}% <br> SGST - ${tx}%`;

                }else{
                    document.getElementById(gArray[i]+"_tax").innerHTML= `IGST-`+ obj.taxes +`%`;
                }
                // }
                // else{
                //     let other = 0;
                //     document.getElementById(gArray[i]+"_tax").innerHTML= `IGST-`+ other +`%`;
                //     obj.taxes = 0;
                // }

            }
        }
    }




    // Approval ajax
    function approve() {

        Swal.fire({
            title: "Approve",
            text: "Are you sure want to Approve the record",
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
                    var sale_id = document.getElementById("so_id").value;
                    // var doner_id = document.getElementById("doner_id").value;
                    $.ajax({

                        type: "POST",
                        url: "approve_api.php",
                        data: 'so_id='+sale_id,
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
                                        // window.window.location.reload();
                                        window.location.href = "<?php echo $website; ?>/so/all_so.php";

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
                                        window.window.location.reload();
                                    });

                            }
                        },
                        error: function(){
                            swal("Check your network connection");

                        }

                    });
                }
            });

    }
    //select search
    var $disabledResults = $(".js-example-disabled-results");
    $disabledResults.select2();
</script>

</body>
</html>

