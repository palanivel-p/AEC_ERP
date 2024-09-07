
<?php Include("../includes/connection.php");
date_default_timezone_set("Asia/kolkata");

error_reporting(0);
$page= $_GET['page_no'];
$search= $_GET['search'];
$branch_nameS= $_GET['branch_nameS']== ''?"all":$_GET['branch_nameS'];

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


?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width,initial-scale=1">
    <title>Adjustment profile</title>

    <link rel="icon" type="image/png" sizes="16x16" href="../images/favicon_New.png">
    <link href="../vendor/jqvmap/css/jqvmap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="../vendor/chartist/css/chartist.min.css">

    <link href="../vendor/jqvmap/css/jqvmap.min.css" rel="stylesheet">
    <link href="../vendor/bootstrap-select/dist/css/bootstrap-select.min.css" rel="stylesheet">
    <link href="../css/style.css" rel="stylesheet">
    <link href="../vendor/owl-carousel/owl.carousel.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" integrity="sha512-9usAa10IRO0HhonpyAIVpjrylPvoDwiPUiKdWk5t3PyolY1cOd4DSE0Ga+ri4AuTroPR5aQvXU9xC6qOPnzFeg==" crossorigin="anonymous" referrerpolicy="no-referrer" />

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

    $header_name ="Create Adjustment";
    Include ('../includes/header.php')


    ?>



    <div class="content-body">
        <div class="page-titles" style="margin-left: 21px;">
            <ol class="breadcrumb">
<!--                <li class="breadcrumb-item"><a href="javascript:void(0)">Table</a></li>-->
                <li class="breadcrumb-item active"><a href="javascript:void(0)"> Create Adjustment</a></li>


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

                                <div class="form-group col-md-4"  id="adj_date">
                                    <label> Adjustment Date *</label>
                                    <input type="date" class="form-control" id="adjustment_date" name="adjustment_date" style="border-color: #181f5a;color: black;text-transform: uppercase">
                                    <input type="hidden" class="form-control"  id="api" name="api">
                                    <input type="hidden" class="form-control"  id="old_pa_id" name="old_pa_id">
                                    <input type="hidden" class="form-control"  id="adjustment_id" name="adjustment_id">

                                </div>

                                <div class="form-group col-md-4"  id="searchproduct">
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
                                                <th scope="col">Product code</th>
                                                <th scope="col">Product Name</th>
                                                <th scope="col">Stock</th>
                                                <th scope="col">Base Unit</th>
                                                <th scope="col">Qty</th>
                                                <th scope="col">Type</th>
                                                <th scope="col">Reason</th>
                                                <th scope="col">Edit</th>
                                                <th scope="col">Delete</th>
                                            </tr>
                                            </thead>
                                            <tbody id="tb">

                                            </tbody>

                                        </table>
                                    </div>
                                </div>


                                <div class="form-group col-md-12" id="note">
                                    <label>Notes </label>
                                    <input type="text" class="form-control" placeholder="Notes" id="notes" name="notes" style="border-color: #181f5a;color: black">
                                    <!--   <textarea class="form-control" placeholder="Notes" id="notes" name="notes" rows="4" cols="50" style="border-color: #181f5a;color: black"></textarea>-->
                                </div>
                                <div class="form-group col-md-6" id="ress">
                                    <label>Reason </label>
                                    <select  class="form-control" id="res" name="res" style="border-color: #181f5a;color: black">

                                        <option value=''> Select Reason</option>
                                        <option value='Expired'> Expired</option>
                                        <option value='Damaged'> Damaged</option>
                                        <option value='Initial Stock'>Initial Stock</option>
                                        <option value='Sample Material'>Sample Material</option>
                                        <option value='Others'>Others</option>

                                    </select>
                                </div>
                                <div class="form-group col-md-6" id="other_ress" style="display: none">
                                    <label>Other Reason</label>
                                    <input type="text" class="form-control" id="other_res" name="other_res" style="border-color: #181f5a;color: black;text-transform: uppercase">
                                </div>
                            </div>
                        </form>
                    </div>

                    <div class="modal-footer">
                        <!--                        <button type="button" class="btn btn-danger light" data-dismiss="modal" style="background-color: red; color: white;text-transform: uppercase">Close</button>-->
                        <button type="button" class="btn btn-primary" id="add_btn">ADD</button>
                    </div>

                </div>
            </div>
        </div>

        <div class="modal fade" id="purchase_list"  data-keyboard="false" data-backdrop="static">
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
                                        <!-- <label>product Id </label>-->
                                        <input type="hidden" class="form-control" placeholder="Product Id" id="p_id" name="p_id" style="border-color: #181f5a;color: black;text-transform: uppercase">
                                        <input type="hidden" class="form-control"  id="api" name="api">
                                        <input type="hidden" class="form-control"  id="old_pa_id" name="old_pa_id">
                                        <input type="hidden" class="form-control"  id="edit_id" name="edit_id">
                                    </div>
                                    <div class="form-group col-md-12">
                                        <label> Quantity * </label>
                                        <input type="number" class="form-control" id="qtys" name="qtys" maxlength="10"  oninput="javascript: if (this.value.length > this.maxLength) this.value = this.value.slice(0, this.maxLength);"style="border-color: #181f5a;color: black;text-transform: uppercase">
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
                                    <div class="form-group col-md-12" id="reasons">
                                        <label>Reason </label>
                                        <select  class="form-control" id="reason" name="reason" style="border-color: #181f5a;color: black">
                                            <option value='NA'> Select Reason</option>
                                            <option value='Expired'> Expired</option>
                                            <option value='Damaged'> Damaged</option>
                                            <option value='Initial Stock'>Initial Stock</option>
                                            <option value='Sample Material'>Sample Material</option>
                                            <option value='Others'>Others</option>
                                        </select>
                                    </div>
                                    <div class="form-group col-md-12" id="other_reasons">
                                        <label>Other Reason</label>
                                        <input type="text" class="form-control" id="other_reason" name="other_reason" style="border-color: #181f5a;color: black;text-transform: uppercase">
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
    document.addEventListener("DOMContentLoaded", function() {
        var inputBox = document.getElementById("qtys");
        // var inputBox1 = document.getElementById("alter_nate_number");
        var invalidChars = [
            "-",
            "+",
            "e",
            ".",

        ];
        inputBox.addEventListener("keydown", function(e) {
            if (invalidChars.includes(e.key)) {
                e.preventDefault();
            }
        });
        inputBox1.addEventListener("keydown", function(e) {
            if (invalidChars.includes(e.key)) {
                e.preventDefault();
            }
        });
    });

    document.addEventListener('DOMContentLoaded', function () {
        const reason = document.getElementById('reason');
        const qtyss = document.getElementById('qtyss');
        const units = document.getElementById('units');
        const reasons = document.getElementById('reasons');
        const other_reasons = document.getElementById('other_reasons');

        // Add an event listener to the dropdown
        reason.addEventListener('change', function () {
            a(reason.value);
        });

        function a(values) {
            if (values === 'Others') {
                // Hide the input field when 'Hide Input Field' is selected
                // ref_nos.style.display = 'none';
                other_reasons.style.display = 'block';
                reasons.style.display = 'block';
                units.style.display = 'block';
                qtyss.style.display = 'block';
                reason.style.display = 'block';

            }
            else {
                // Show the input field for other selections
                other_reasons.style.display = 'none';
                reasons.style.display = 'block';
                units.style.display = 'block';
                qtyss.style.display = 'block';
                reason.style.display = 'block';
            }
        }
    });

    document.addEventListener('DOMContentLoaded', function () {
        const res = document.getElementById('res');
        const adj_date = document.getElementById('adj_date');
        const searchproduct = document.getElementById('searchproduct');
        const note = document.getElementById('note');
        const ress = document.getElementById('ress');
        const other_ress = document.getElementById('other_ress');

        // Add an event listener to the dropdown
        res.addEventListener('change', function () {
            a(res.value);
        });

        function a(values) {
            if (values === 'Others') {
                // Hide the input field when 'Hide Input Field' is selected
                res.style.display = 'block';
                adj_date.style.display = 'block';
                searchproduct.style.display = 'block';
                note.style.display = 'block';
                ress.style.display = 'block';
                other_ress.style.display = 'block';

            }
            else {
                // Show the input field for other selections
                other_ress.style.display = 'none';
                res.style.display = 'block';
                adj_date.style.display = 'block';
                searchproduct.style.display = 'block';
                note.style.display = 'block';
                ress.style.display = 'block';;
            }
        }
    });

    const productSearch = document.getElementById("productName");
    const productListUl =  document.getElementById("productListUl");
    const grand_total =  document.getElementById("grand_total");
    const discount =  document.getElementById("discount");
    const shipping =  document.getElementById("shipping");
    const order_tax =  document.getElementById("order_tax");
    const productDetailArr = [];

    //Edit Product tax and discount
    function editTitle(data) {
        // $("#titles").html("Edit Adjustment- "+data);
        $('#purchase_form')[0].reset();
        // // $('#api').val("edit_api.php");
        // $('#api').val("test.php");

        let QUANTITY = document.getElementById(`${data}_quantity`).innerHTML;
        document.getElementById('qtys').value = Number(QUANTITY);

        let UNITS = document.getElementById(`${data}_bunit`).innerHTML;
        document.getElementById('unit').value = UNITS;
        $('#unit').trigger("change");

        let Reason = document.getElementById(`${data}_dynamicDropdown`).innerHTML;
        document.getElementById('reason').value = Reason;
        $('#reason').trigger("change");

        let otherReason = document.getElementById(`${data}_dynamicDropdown`).innerHTML;
        if(otherReason == 'Expired' || otherReason == 'Damaged' || otherReason == 'Initial Stock' ||otherReason == 'Sample Material'){
            document.getElementById('other_reason').value = otherReason;
        }
        else{
            document.getElementById('other_reason').value = 'Others';
        }
        // document.getElementById('other_reason').value = otherReason;

        var edit_model_title = "Edit Adjustment - "+data;
        $('#titles').html(edit_model_title);
        $('#addbtn').html("Save");
        $('#p_id').val(data);
        $('#purchase_list').modal('show');

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
                reason:{
                    required:true
                },
            },
            messages: {
                qtys: "*This field is required",
                unit: "*This field is required",
                reason: "*This field is required",
            }
        });

    $('#addbtn').click(function () {
        if ($("#purchase_form").valid()) {
        const p_id = $('#p_id').val();
        const unit = $('#unit').val();
        const reason = $('#reason').val();
        const qtys = $('#qtys').val();
        const other_reason = $('#other_reason').val();

            let selectedReason = reason;
            // If the selected reason is "Others", use the other reason instead
            if (reason === 'Others' && other_reason.trim() !== '') {
                selectedReason = other_reason;
            }

            // Update the display with the selected or other reason
            $(`#${p_id}_dynamicDropdown`).text(selectedReason);
        $(`#${p_id}_quantity`).text(qtys);
        // $(`#${p_id}_dynamicDropdown`).text(reason);
        $(`#${p_id}_bunit`).text(unit);
        $('#purchase_form')[0].reset();
        // if (unit !== '') {
        //     // Check if the existing text content already contains "MT" before appending
        //     const existingText = $(`#${p_id}_stkid`).text();
        //     if (!existingText.includes("MT")) {
        //         $(`#${p_id}_stkid`).text(existingText + ">" + unit);
        //     }
        // }
        $('#purchase_list').modal('hide');
    }

    });

    //to validate form
    $("#staff_form").validate(
        {
            ignore: '.ignore',
            // Specify validation rules
            rules: {
                adjustment_date: {
                    required: true
                },
                // res:{
                //     required:true
                // },
            },
            // Specify validation error messages
            messages: {
                adjustment_date: "*This field is required",
                res: "*This field is required",
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
                const rowData = {
                    sNo: row.cells[0].textContent,
                    productCode: row.cells[1].textContent,
                    productId: row.cells[2].textContent,
                    productName: row.cells[3].textContent,
                    stock: row.cells[4].textContent,
                    unit: row.cells[5].textContent,
                    quantity: row.cells[6].textContent,
                    addsubType: row.cells[7].querySelector('select').value,
                    adjustmentType: row.cells[8].textContent,
                };

                console.log(rowDataArray.push(rowData));
            }

            $.ajax({

                type: "POST",
                url: "add_api.php",
                // data: $('#staff_form').serialize() + {
                //     tableData: JSON.stringify(rowDataArray),
                //     // Add other parameters if needed
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
                                window.location.href = "all_adjustment.php";
                                // window.window.location.reload();
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
                        $('#productListUl').empty();
                        var product_id = res.product_id;
                        var product_name = res.product_name;
                        var product_price = res.product_price;
                        var product_stock = res.product_stock;
                        var product_code = res.product_code;
                        var product_unit = res.product_unit;
                        var product_varient = res.product_varient;
                        // var product_code = res.product_code;
                        var product_brand = res.product_brand;

                        for(let i=0;i<product_id.length;i++){
                            const listUL = document.createElement("li");
                            // listUL.innerHTML = product_name[i];
                            listUL.innerHTML = `${product_name[i]} / ${product_code[i]} / ${product_brand[i]} / ${product_varient[i]}`; // Displaying variant names
                            listUL.setAttribute("onclick",`tableBuild("${product_id[i]}","${product_price[i]}","${product_name[i]}","${product_stock[i]}","${product_code[i]}","${product_unit[i]}")`);
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
                                $('#productListUl').empty();
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

    var gArray = [];
    var rowCounter = 0;


    function tableBuild(product_id,product_price,product_name,product_stock,product_code,product_unit) {

        if(!gArray.includes(product_id)) {

            const tb = document.getElementById("tb");
            const tr = document.createElement("tr");
            rowCounter++;
            let productDetails = [];
            productDetails.push(product_id);
            productDetails.push(product_code);
            productDetails.push(product_name);
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
                    stockSpan.innerHTML = productDetails[i];
                    td.append(stockSpan);

                    const idSpan = document.createElement("span");
                    idSpan.setAttribute("id", `${product_id}_stkid`);
                    idSpan.innerHTML = "-" + product_unit;
                    td.append(idSpan);
                }
                else {
                    td.innerHTML = productDetails[i];
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

            const addsub = document.createElement("td");
            const addsubSelect = document.createElement("select");
            // dropdownSelect.setAttribute('id', 'dynamicDropdown');
            addsubSelect.setAttribute('id', `${product_id}_addsub`);
            // Add options to the dropdown (you can modify this part based on your requirements)
            const option1 = document.createElement("option");
            option1.value = "addition";
            option1.text = "Addition";
            const option2 = document.createElement("option");
            option2.value = "subtraction";
            option2.text = "Subtraction";
            addsubSelect.appendChild(option1);
            addsubSelect.appendChild(option2);
            addsub.appendChild(addsubSelect);
            tr.appendChild(addsub);
            tb.append(tr);

            const dynamicDropdown = document.createElement("td");
            dynamicDropdown.setAttribute("id", `${product_id}_dynamicDropdown`);
            dynamicDropdown.innerHTML = 'NA';
            tr.appendChild(dynamicDropdown);
            tb.append(tr);


            const editCell = document.createElement("td");
            const editIcon = document.createElement("i");
            editIcon.setAttribute('data-toggle', `modal`);
            editIcon.setAttribute('data-target', `#purchase_list`);
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
    
    function removeProduct(product_id) {

        let obj = productDetailArr.findIndex(o => o.product_id === product_id);
        productDetailArr.splice(obj,1);
        gArray.splice(obj,1);
        grandTotalCal(productDetailArr);
    }

    function grandTotalCal(productAr){
        let grossPrice = 0;
        for(let x=0;x<productAr.length;x++){

            let subTot =  productAr[x].price * productAr[x].qty;

            var discountAmount;
            var discountAmounts;
            if(productAr[x].disType == 1){
                discountAmount = subTot - ((productAr[x].dis/100) * subTot);
                discountAmounts = subTot - discountAmount;
                // discountAmount = (subTot * productAr[x].dis) / 100;
            }else if(productAr[x].disType == 2){
                discountAmount = subTot - productAr[x].dis;
                discountAmount = discountAmounts;

            }

            grossPrice += Math.round(discountAmount + productAr[x].tax);
            // Update total amount with tax and calculate discount
            // subTot += productAr[x].tax;
            // const discountAmount = (subTot * productAr[x].dis) / 100;
            // grossPrice += Math.round(subTot - discountAmount);

            // grossPrice += productAr[x].price * productAr[x].qty;

        }

        // grand_total.value = grossPrice;

        // return grossPrice;
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


</script>

</body>
</html>

