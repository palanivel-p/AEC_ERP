<?php
Include("../includes/connection.php");

date_default_timezone_set("Asia/Kolkata");
$currentDate = date('Y-m-d');
if(isset($_POST['customer'])&&isset($_POST['so_date'])) {


    $product_name = clean($_POST['product_name']);
    $so_id = clean($_POST['so_id']);
    $customer = clean($_POST['customer']);
    $parts = explode('_', $customer);
    $customer_id = $parts[0];
    $supply_place = $parts[1];

    $so_date = clean($_POST['so_date']);
//    $currency = clean($_POST['currency']);
    $payment_terms = clean($_POST['payment_terms']);
    $discount = $_POST['discount'];
    $tds = $_POST['tds'];
    $totaltax = $_POST['tax'];
    $grand_total = $_POST['grand_total'];
    $payment_status = $_POST['payment_status'];
    $status = $_POST['status'];
    $notes = $_POST['notes'];
    $d_date = $_POST['d_date'];
    $e_way = $_POST['e_way'];
    $po_no = clean($_POST['po_no']);
    $po_date = clean($_POST['po_date']);
//    $so_id = $_POST['so_id'];

    $add_id = $_POST['add_id'];

    $api_key = $_COOKIE['panel_api_key'];
    $added_by = $_COOKIE['user_id'];

    $added_by = $_COOKIE['user_id'];
//    $sqlValidateCookie="SELECT * FROM `user_details` WHERE panel_api_key='$api_key'";
    if ($_COOKIE['role'] == 'Super Admin'){
        $sqlValidateCookie = "SELECT * FROM `user_details` WHERE panel_api_key='$api_key'";
    }
    else {
        $sqlValidateCookie = "SELECT * FROM `user` WHERE user_id='$added_by'";
    }
    $resValidateCookie = mysqli_query($conn, $sqlValidateCookie);
    if (mysqli_num_rows($resValidateCookie) > 0) {


        $sqlInsert = "INSERT INTO `so`(`so_id`,`customer`,`so_date`,`discount`,`tds`,`grand_total`,`payment_status`,`notes`,`status`,`e_way`,`po_date`,`po_no`,`payment_terms`,`due_date`,`total_tax`,`added_by`) 
                                            VALUES ('','$customer_id','$so_date','$discount','$tds','$grand_total','$payment_status','$notes','$status','$e_way','$po_date','$po_no','$payment_terms','$d_date','$totaltax','$added_by')";

        mysqli_query($conn, $sqlInsert);

        $ID=mysqli_insert_id($conn);

        if(strlen($ID)==1)
        {
            $ID='00'.$ID;

        }elseif(strlen($ID)==2)
        {
            $ID='0'.$ID;
        }

        $so_id="SA".($ID);
        $invoice_no = "AEC/invoice/" . $currentDate . "/" . $ID;

        $sqlUpdate = "UPDATE so SET so_id = '$so_id',invoice_no='$invoice_no' WHERE id ='$ID'";
        mysqli_query($conn, $sqlUpdate);



        $tableData = json_decode($_POST['tableData'], true);

        // Loop through the data and insert into the database
        foreach ($tableData as $rowData) {
            $productId = $conn->real_escape_string($rowData['productId']);
            $productCode = $conn->real_escape_string($rowData['productCode']);
            $productName = $conn->real_escape_string($rowData['productName']);
            $productDesc = $conn->real_escape_string($rowData['productDesc']);
            $netUnitCost = $conn->real_escape_string($rowData['netUnitCost']);
            $unit = $conn->real_escape_string($rowData['unit']);
            $stockUnit = $conn->real_escape_string($rowData['stockUnit']);
            $stockValue = $conn->real_escape_string($rowData['stockValue']);
            $persymbl = $conn->real_escape_string($rowData['persymbl']);
            $discount = $conn->real_escape_string($rowData['discount']);

//            $stock = $conn->real_escape_string($rowData['stock']);
//            $stk = explode('-', $stock);
//            $stock_value = $stk[0];
//            $stock_unit = $stk[1];

//            $unit_symbol = explode('>', $stock_unit);
//            $unit_sym = $unit_symbol[0];
//            $unit_bol = $unit_symbol[1];

            $quantity = $conn->real_escape_string($rowData['quantity']);
//            $quantity_r=  str_replace("+","",$quantity);
//            $quantity_r=  str_replace("-","",$quantity_r);

//            if($unit_bol === 'MT'){
//                $total_stock = (int)$quantity_r * 1000;
//                $stock_add = $stock_value + $total_stock;
//            }
//            else{
//                $total_stock = $stock_value;
//                $stock_add = (int)$quantity_r + $total_stock;
//            }
            $sqlProduct = "SELECT * FROM `product` WHERE `product_id`='$productId'";
            $resProduct = mysqli_query($conn, $sqlProduct);
            $rowProduct = mysqli_fetch_assoc($resProduct);
            $stock_qty =  $rowProduct['stock_qty'];

            if($unit === 'MT'){
                $total_stock = (int)$quantity * 1000;
                $stock_add = $stock_qty - (int)$total_stock;
//                $stock_add = $stock_value + $total_stock;
            }
            elseif ($unit === 'mm'){
                $total_stock = (int)$quantity * 12;
                $stock_add = $stock_qty - (int)$total_stock;
            }
            elseif ($unit === 'bgs'){
                $total_stock = (int)$quantity * 25;
                $stock_add = $stock_qty - (int)$total_stock;
            }
            else{
                $total_stock = (int)$quantity * 1;
                $stock_add = $stock_qty - (int)$total_stock;
//                $stock_add = (int)$quantity_r + $total_stock;
            }
//            $discount = $conn->real_escape_string($rowData['discount']);
//            $discount_type = (strpos($discount, '%') !== false) ? 1 : 2;
//            $discount = str_replace('%', '', $discount);

            if($persymbl == '%'){
                $symbl = 1;
            }
            else if($persymbl == '₹'){
                $symbl = 2;
            }

            $discount_value = $conn->real_escape_string($rowData['discount_value']);
            $tax = $conn->real_escape_string($rowData['tax']);
            $tax_value = $conn->real_escape_string($rowData['tax_value']);
            $subtotal = $conn->real_escape_string($rowData['subtotal']);

            // Assuming you have a table named 'products'
            $sqlInsersts = "INSERT INTO so_details (so_details_id,product_id,product_code,product_name,unit,unit_cost, stock,Stock_count ,discount,dis_symbl, tax, sub_total,qty,tax_value,discount_value,discount_type,productDesc) 
                    VALUES ('','$productId','$productCode','$productName','$unit', '$netUnitCost', '$stockValue','$stock_add', '$discount','$persymbl', '$tax', '$subtotal','$quantity','$tax_value','$discount_value','$symbl','$productDesc')";

            mysqli_query($conn, $sqlInsersts);

            $ID = mysqli_insert_id($conn);

            if (strlen($ID) == 1) {
                $ID = '00' . $ID;

            } elseif (strlen($ID) == 2) {
                $ID = '0' . $ID;
            }

            $so_details_id = "SD" . ($ID);
            $sqlUpdate = "UPDATE so_details SET so_details_id = '$so_details_id',so_id='$so_id',customer='$customer_id',so_date='$so_date',so_id='$so_id' WHERE id ='$ID'";
            mysqli_query($conn, $sqlUpdate);

            $sqlStock = "SELECT * FROM `product` WHERE `product_id`='$productId'";
            $resStock = mysqli_query($conn, $sqlStock);
            $rowStock = mysqli_fetch_assoc($resStock);
            $total_stock =  $rowStock['stock_qty'];

//            $sqlStockUpdate = "UPDATE product SET stock_qty = '$stock_add' WHERE product_id ='$productId'";
//            mysqli_query($conn, $sqlStockUpdate);
        }

        $role=$_COOKIE['role'];
        $staff_id=$_COOKIE['user_id'];
        $staff_name=$_COOKIE['user_name'];
        $info = urlencode("Sales Order Added");
        $role = urlencode($role); // Assuming $id is a variable with the emp_id value
        $staff_id = urlencode($staff_id); // Assuming $id is a variable with the emp_id value
        $staff_name = urlencode($staff_name); // Assuming $id is a variable with the emp_id value
        $url = "https://erp.aecindia.net/includes/log_api.php?message=$info&role=$role&staff_id=$staff_id&staff_name=$staff_name";
        file_get_contents($url);

        $json_array['status'] = "success";
        $json_array['msg'] = " So Added successfully !!!";
        $json_response = json_encode($json_array);
        echo $json_response;
    }


    else {
        //Parameters missing

        $json_array['status'] = "failure";
        $json_array['msg'] = "Invalid Login !!!";
        $json_response = json_encode($json_array);
        echo $json_response;
    }
}
else
{
    //Parameters missing

    $json_array['status'] = "failure";
    $json_array['msg'] = "Please try after sometime !!!";
    $json_response = json_encode($json_array);
    echo $json_response;
}



function clean($data) {
    return filter_var($data, FILTER_SANITIZE_STRING, FILTER_FLAG_STRIP_HIGH);
}



?>
