
<?php Include("../includes/connection.php");
date_default_timezone_set("Asia/kolkata");

error_reporting(0);

$so_id= $_GET['so_id'];

$sale_id= $_GET['sale_id'];
$sqlsale = "SELECT * FROM sale WHERE sale_id ='$sale_id'";
$ressale = mysqli_query($conn, $sqlsale);
$rowsale = mysqli_fetch_assoc($ressale);
$sale_date =  $rowsale['sale_date'];
$due_date =  $rowsale['due_date'];
$customer =  $rowsale['customer'];
$currency_id =  $rowsale['currency_id'];
$payment_terms =  $rowsale['payment_terms'];
$discountss =  $rowsale['discount'];
$discounts=  str_replace("%","",$discountss);
$payment_status =  $rowsale['status'];
$status =  $rowsale['payment_status'];
$grand_total =  $rowsale['grand_total'];
$material =  $rowsale['material'];
$transport =  $rowsale['transport'];
$notes=$rowsale['notes'];
$total_tax=$rowsale['total_tax'];

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width,initial-scale=1">
    <title> sale profile</title>

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

    $header_name ="sale";
    Include ('../includes/header.php')

    ?>

    <div class="content-body">
        <div class="page-titles" style="margin-left: 21px;">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="javascript:void(0)">Table</a></li>
                <li class="breadcrumb-item active"><a href="javascript:void(0)">sale</a></li>
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
                                    <label> sale Date *</label>
                                    <input type="date" class="form-control" id="sale_date" name="sale_date" style="border-color: #181f5a;color: black;text-transform: uppercase">
                                    <input type="hidden" class="form-control"  id="api" name="api">
                                    <input type="hidden" class="form-control"  id="old_pa_id" name="old_pa_id">
                                    <input type="hidden" class="form-control"  id="sale_id" name="sale_id" >
                                    <input type="hidden" class="form-control"  id="so_id" name="so_id" value="<?php echo $so_id?>">
                                </div>
                                <div class="form-group col-md-4">
                                    <label for="customer">customer *</label>
                                    <select data-search="true" class="form-control tail-select w-full" id="customer" name="customer" style="border-color: #181f5a; color: black" onclick="customerfun(this.value)">
                                        <option value="">Select customer</option>
                                        <?php
                                        $sqlcustomer = "SELECT * FROM `customer`";
                                        $resultcustomer = mysqli_query($conn, $sqlcustomer);

                                        if (mysqli_num_rows($resultcustomer) > 0) {
                                            while ($rowcustomer = mysqli_fetch_array($resultcustomer)) {

                                                ?>
                                                <option value='<?php echo $rowcustomer['customer_id'].'_'.$rowcustomer['supply_place']; ?>'>
                                                    <?php echo strtoupper($rowcustomer['customer_name']); ?>
                                                </option>
                                                <?php
                                            }
                                        }
                                        ?>
                                    </select>
                                </div>
                                <div class="form-group col-md-4">
                                    <label for="currency">Currency</label>
                                    <select data-search="true" class="form-control tail-select w-full" id="currency" name="currency" style="border-color: #181f5a; color: black">
                                        <?php
                                        $sqlCurrency = "SELECT * FROM `currency`";
                                        $resultCurrency = mysqli_query($conn, $sqlCurrency);
                                        if (mysqli_num_rows($resultCurrency) > 0) {
                                            while ($rowCurrency = mysqli_fetch_array($resultCurrency)) {
                                                ?>
                                                <option value='<?php echo $rowCurrency['currency_id']; ?>'>
                                                    <?php echo strtoupper($rowCurrency['currency_name']); ?>
                                                </option>
                                                <?php
                                            }
                                        }
                                        ?>
                                    </select>
                                </div>


                                <div class="form-group col-md-4">
                                    <label> Search Product *</label>
                                    <input type="text" class="form-control"  id="productName" name="productName" placeholder="Search Product" style="border-color: #181f5a;color: black;text-transform: uppercase">
                                    <ul class="productListUl" id="productListUl" style="display: none">
                                    </ul>
                                </div>
                                <div class="form-group col-md-4">
                                    <label>Payment terms *</label>
                                    <select data-search="true" class="form-control tail-select w-full" id="payment_terms" name="payment_terms"  style="border-color: #181f5a;color: black">
                                        <option value=''>Select Status</option>
                                        <option value='0' >Immidiate</option>
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
                                <div class="form-group col-md-4">
                                    <label>Due Date *</label>
                                    <input type="date" class="form-control" id="d_date" name="d_date" style="border-color: #181f5a;color: black;text-transform: uppercase">
                                </div>

                                <div class="form-group col-md-12" style="font-size: 15px">
                                    <h5>Order items *</h5>
                                    <div class="table-responsive">
                                        <table class="table table-hover">
                                            <thead class="bg-gray-300">
                                            <tr><th scope="col">#</th>
                                                <th scope="col">Product Id</th>
                                                <th scope="col">Product</th>
                                                <th scope="col">Product Cost</th>
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
                                            if($so_id != ''){

                                            $sql = "SELECT * FROM so_details WHERE so_id ='$so_id'";
                                            $result = mysqli_query($conn, $sql);
                                            $product_ids = "";
                                            $product_obj = "";

                                            if (mysqli_num_rows($result)>0) {
                                                $sNo = 0;
                                                while($row = mysqli_fetch_assoc($result)) {

                                                    $sNo++;
                                                    $so_id=$row['so_id'];
                                                    $product_id=$row['product_id'];
                                                    $product_name=$row['product_name'];

                                                    $sqlProduct = "SELECT * FROM product WHERE product_id ='$product_id'";
                                                    $resProduct = mysqli_query($conn, $sqlProduct);
                                                    $rowProduct = mysqli_fetch_assoc($resProduct);
                                                    $stock_qty =  $rowProduct['stock_qty'];
                                                    $unit_cost =  $rowProduct['product_cost'];
                                                    $product_unit =  $rowProduct['product_unit'];

                                                    $stock=$row['Stock_count'];
                                                    $qty=$row['qty'];
                                                    $unit =  $row['base_unit'];
//                                                    $unit_cost =  $row['unit_cost'];
                                                    $discount1 =  0;
                                                    $dis_symbl =  '%';
//                                                    $discount_s=  str_replace("%","",$discount1);
                                                    $discount_value =  0;
                                                    $discount_Type =  1;
                                                    $tax =  'CGST-9% SGST-9%';
                                                    $tax_value =  $row['tax_value'];
                                                    $sub_total =  $qty * $unit_cost;

                                                    $product_ids .= $row['product_id'].",";
                                                    $taxValues = (18/100) * intval($unit_cost);

                                                    $product_objs .= "$product_id,$unit_cost,$qty,$discount1,$discount_Type,$taxValues,$unit"."#";

                                                    ?>
                                                    <tr>
                                                        <td><?php echo $sNo;?></td>
                                                        <td><?php echo $product_id?></td>
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
                                                        <td id="<?php echo $product_id.'_tax' ?>"><?php echo $tax?></td>
                                                        <td id="<?php echo $product_id.'_descrip'?>"  style="display: none"></td>
                                                        <td><span id="<?php echo $product_id.'_taxValue' ?>"><?php echo round($tax_value)?></span></td>
                                                        <td id="<?php echo $product_id.'_totAmout' ?>"><?php echo round($sub_total)?></td>
                                                        <!--                                                        <td style="display: none" id="--><?php //echo $product_id.'_descrip'?><!--"></td>-->
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
                                            }
                                            ?>
                                            </tbody>

                                        </table>
                                    </div>
                                </div>

                                <div class="form-group col-md-4">
                                    <label>Discount </label>
                                    <input type="number" class="form-control" placeholder="Discount" id="discount" name="discount" value="<?php echo $discountss?>" onkeyup="totalDiscount(this.value)" style="border-color: #181f5a;color: black">
                                    <!--                                    onkeyup="this.value = fnc(this.value, 0, 100)"-->
                                </div>
                                <div class="form-group col-md-4">
                                    <label>Total Tax </label>
                                    <input type="number" class="form-control" placeholder="Tax" id="tax" name="tax" readonly style="border-color: #181f5a;color: black">
                                </div>
                                <div class="form-group col-md-4">
                                    <label>Grand Total </label>
                                    <input type="number" class="form-control" placeholder="Grand Total" id="grand_total" name="grand_total" readonly style="border-color: #181f5a;color: black">
                                </div>
                                <div class="form-group col-md-4">
                                    <label> Status *</label>
                                    <select data-search="true" class="form-control tail-select w-full" id="payment_status" name="payment_status" style="border-color: #181f5a;color: black">
                                        <option value='4' <?php echo ($status == '4') ? 'selected' : ''; ?>>Odered</option>
                                        <option value='1' <?php echo ($status == '1') ? 'selected' : ''; ?>>Received</option>
                                        <option value='2' <?php echo ($status == '2') ? 'selected' : ''; ?>>Partially Pending</option>
                                        <option value='3' <?php echo ($status == '3') ? 'selected' : ''; ?>>Pending</option>


                                    </select>
                                </div>
                                <div class="form-group col-md-4">
                                    <label for="status">Payment Status *</label>
                                    <select data-search="true" class="form-control tail-select w-full" id="status" name="status" style="border-color: #181f5a; color: black">
                                        <option value='3' <?php echo ($payment_status == '3') ? 'selected' : ''; ?>>Unpaid</option>
                                        <option value='1' <?php echo ($payment_status == '1') ? 'selected' : ''; ?>>Paid</option>
                                        <option value='2' <?php echo ($payment_status == '2') ? 'selected' : ''; ?>>Partially Paid</option>

                                    </select>
                                </div>
                                <div class="form-group col-md-4">
                                    <label>Material Received Date </label>
                                    <input type="date" class="form-control"  id="material_date" name="material_date" style="border-color: #181f5a;color: black">
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
                            <form id="sale_form" autocomplete="off">
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
                                        <input type="number" class="form-control" id="qtys" name="qtys" style="border-color: #181f5a;color: black;text-transform: uppercase">
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
                                        <input type="number" class="form-control" placeholder="Discount" id="dis" name="dis" style="border-color: #181f5a;color: black">
                                    </div>
                                    <div class="form-group col-md-12">
                                        <label>Description </label>
                                        <input type="text" class="form-control" placeholder="Description" id="desc" name="desc" style="border-color: #181f5a;color: black">
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
        window.location.href = "https://erp.aecindia.net/sale/";
    }
    //due date
    $(document).ready(function() {
        $("#payment_terms").change(function() {
            const inputDateValue = document.getElementById("sale_date").value;
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
            unit: Number(pro_objes[6])
        };

        productDetailArr.push(product_obje);
    }

    console.log(productDetailArr);
    grandTotalCal(productDetailArr);


    function totalDiscount(a){
        var totaldiscount = grandTotalCal(productDetailArr);
        grand_total.value = totaldiscount - ((a/100) * totaldiscount);
    }
    //Edit Product tax and discount
    function editTitle(data,quantity,discounts,units) {
        $('#sale_form')[0].reset();
        var edit_model_title = "sale - "+data;
        $('#titles').html(edit_model_title);
        $('#addbtn').html("Save");
        $('#p_id').val(data);
        $('#qtys').val(quantity);
        $('#dis').val(discounts);
        $('#unit').val(units);
        $('#sale_list').modal('show');

    }
    //to edit validate form
    $("#sale_form").validate(
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
        if ($("#sale_form").valid()) {
            const p_id = $('#p_id').val();
            const qtys = $('#qtys').val();
            const unit = $('#unit').val();
            const dis = Number($('#dis').val());
            const type = Number($('#type').val());

            $(`#${p_id}_descrip`).text(desc);
            $(`#${p_id}_quantity`).text(qtys);
            $(`#${p_id}_bunit`).text(unit);
            $('#sale_form')[0].reset();


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
            if (unit === "MT") {
                subTot = obj.price * (qtys * 1000);
            } else {
                subTot = obj.price * qtys;
            }

            var discountAmount;
            var discountAmounts;
            if (type == 1) {
                // discountAmount = (subTot * dis) / 100;
                discountAmount = subTot - ((dis / 100) * subTot);
                discountAmounts = subTot - discountAmount;
            } else if (type == 2) {
                discountAmount = subTot - dis;
                // discountAmounts = discountAmount;
                discountAmounts = dis;

            }

            subTotElement.innerHTML = Math.round(discountAmount);
            disPercentage.innerHTML = Math.round(discountAmounts);
            $(`#${p_id}_taxValue`).text(Math.round(qtys * obj.tax));
            console.log(Math.round(discountAmount));
            obj.dis = dis;
            obj.disType = type;
            obj.qty = qtys;
            obj.unit = unit;


            grandTotalCal(productDetailArr);
            $('#sale_list').modal('hide');
        }
    });

    //to validate form
    $("#staff_form").validate(
        {
            ignore: '.ignore',
            // Specify validation rules
            rules: {
                sale_date: {
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



            },
            // Specify validation error messages
            messages: {
                sale_date: "*This field is required",
                customer: "*This field is required",
                product_name: "*This field is required",
                payment_status: "*This field is required",
                status: "*This field is required",
                payment_terms: "*This field is required",
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
                // const tax = row.cells[9].querySelector('#' + productId + '_tax');
                // const productDesc = row.cells[9].querySelector('#' + productId + '_descrip');
                const discountSpan = row.cells[7].querySelector('#' + productId + '_dis');
                const persymblSpan = row.cells[7].querySelector('#' + productId + '_psym');
                const stockuSpan = row.cells[4].querySelector('#' + productId + '_stkidu');
                const stockvSpan = row.cells[4].querySelector('#' + productId + '_stkidv');
                const stockValue = stockvSpan ? stockvSpan.textContent : '';
                const rowData = {
                    sNo: row.cells[0].textContent,
                    // productId: row.cells[1].textContent,
                    productId: productId,
                    productName: row.cells[2].textContent,
                    netUnitCost: row.cells[3].textContent,
                    // stock: row.cells[4].textContent,
                    stockUnit: stockuSpan.textContent,
                    stockValue: stockValue.textContent,
                    unit: row.cells[5].textContent,
                    quantity: row.cells[6].textContent,
                    // discount: row.cells[7].textContent,
                    persymbl: persymblSpan.textContent,
                    discount: discountSpan.textContent,
                    discount_value: row.cells[8].textContent,
                    tax: row.cells[9].textContent,
                    productDesc: row.cells[10].textContent,
                    tax_value: row.cells[11].textContent,
                    subtotal: row.cells[12].textContent,
                    // productDesc: productDesc.textContent,
                    // Add other fields if needed
                };

                console.log(rowDataArray.push(rowData));
            }

            $.ajax({

                type: "POST",
                url: "https://erp.aecindia.net/sale/add_api.php",
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
                                window.location.href = "https://erp.aecindia.net/sale/all_sale.php";
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



    $(productSearch).keyup(function(){
        $('#productListUl').empty();

        productListUl.style.display = "none";
        let valueProduct = this.value;

        if(valueProduct.length >= 1){
            $.ajax({
                type: "POST",
                url: "product_api.php",
                data: 'product_id=' + valueProduct,
                dataType: "json",
                success: function (res) {
                    if (res.status == 'success') {
                        var product_id = res.product_id;
                        var product_name = res.product_name;
                        var product_price = res.product_price;
                        var product_stock = res.product_stock;
                        var product_tax = res.product_tax;
                        var product_unit = res.product_unit;

                        for(let i=0;i<product_id.length;i++){
                            const listUL = document.createElement("li");
                            listUL.innerHTML = product_name[i];

                            listUL.setAttribute("onclick",`tableBuild("${product_id[i]}","${product_price[i]}","${product_name[i]}","${product_stock[i]}","${product_tax[i]}","${product_unit[i]}")`);
                            listUL.style.cursor = "pointer";
                            productListUl.append(listUL);
                        }

                        productListUl.style.display = "block";

                        $('#product_name').val('');


                    } else if (res.status == 'failure') {

                        Swal.fire(
                            {
                                title: "Failure",
                                text: "No Products",
                                icon: "warning",
                                button: "OK",
                                allowOutsideClick: false,
                                allowEscapeKey: false,
                                closeOnClickOutside: false,
                            }
                        )
                            .then((value) => {

                            });

                    }
                },
                error: function () {
                    Swal.fire("Check your network connection");
                    // window.window.location.reload();
                }
            });

            // console.log(valueProduct);
        }

    });

    var pro  = '<?php echo $product_idss?>';
    var pro_id =  pro .split(",");

    var gArray = [...pro_id];
    // gArray.push(pro_id);
    console.log(gArray);
    console.log(pro_id);
    var rowCounter = <?php echo $sNo?>;


    function tableBuild(product_id,product_price,product_name,product_stock,product_tax,product_unit) {
        var supply  = document.getElementById('customer').value;

        const myArray = supply.split("_");
        console.log(myArray);
        if(!gArray.includes(product_id)) {

            const tb = document.getElementById("tb");
            const tr = document.createElement("tr");
            rowCounter++;
            let productDetails = [];
            productDetails.push(product_id);
            productDetails.push(product_name);
            productDetails.push(product_price);
            productDetails.push(product_stock);
            productDetails.push(product_unit);



            const sNo = document.createElement("td");
            sNo.innerHTML = rowCounter;
            tr.append(sNo);
            tb.append(tr);

            for (let i = 0; i < 5; i++) {
                const td = document.createElement("td");
                if (i === 3) {
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
                if (i === 2) {
                    td.setAttribute("id", `${product_id}_price`);
                }
                if (i === 4) {
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

            if(myArray[1] == "Tamil Nadu"){
                inputtax.innerHTML = `CGST-9%<br>SGST-9%`;
            }else{
                inputtax.innerHTML = `IGST-18%`;
            }
            inputtax.setAttribute('id', `${product_id}_tax`);
            tax.appendChild(inputtax);

            tr.append(tax);
            tb.append(tr);

            const description = document.createElement("td");
            description.setAttribute("id", `${product_id}_descrip`);
            description.innerHTML = '';
            description.setAttribute('style', `display:none`);
            tr.appendChild(description);
            tb.append(tr);

            let taxValues = (18/100) * Number(product_price);

            const taxvalue = document.createElement("td");
            const inputtaxval = document.createElement('span');
            inputtaxval.innerHTML = Math.round(taxValues);
            inputtaxval.setAttribute('id', `${product_id}_taxValue`);
            taxvalue.appendChild(inputtaxval);
            tr.append(taxvalue);
            tb.append(tr);

            const total = document.createElement("td");
            let quantitys = $('.quantity-input').val('');
            let sub_total = Number(product_price) * 1;
            total.setAttribute('id', `${product_id}_totAmout`);
            total.innerHTML = Math.round(sub_total);
            $('#grand_total').val(sub_total);
            tr.append(total);



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
                unit: product_unit
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
            if (productAr[x].unit === "MT") {
                subTot = productAr[x].price * (productAr[x].qty * 1000);
            } else {
                subTot = productAr[x].price * productAr[x].qty;
            }
            tax_order+= productAr[x].qty * productAr[x].tax;
            var discountAmount;
            var discountAmounts;
            if(productAr[x].disType == 1){
                discountAmount = subTot - ((productAr[x].dis/100) * subTot);
                discountAmounts = subTot - discountAmount;
                // discountAmount = (subTot * productAr[x].dis) / 100;
            }else if(productAr[x].disType == 2){
                discountAmount = subTot - productAr[x].dis;
                discountAmounts = discountAmount;
            }
            console.log(discountAmount);
            // grossPrice += Math.round(subTot);
            grossPrice += Math.round(discountAmount);

        }
        console.log(grossPrice);
        console.log(tax_order);
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
        if(gArray.length > 0){
            for(let i =0; i<gArray.length; i++){
                if(supplyArray[1] == 'Tamil Nadu') {
                    document.getElementById(gArray[i]+"_tax").innerHTML= `CGST - 9% <br> SGST - 9%`;
                }else{
                    document.getElementById(gArray[i]+"_tax").innerHTML= `IGST - 18%`;
                }
            }
        }
    }

</script>

</body>
</html>

