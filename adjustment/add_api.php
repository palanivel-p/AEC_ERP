<?php
Include("../includes/connection.php");

date_default_timezone_set("Asia/Kolkata");

if(isset($_POST['adjustment_date'])) {

    $adjustment_date = clean($_POST['adjustment_date']);
    $notes = $_POST['notes'];
    $res = $_POST['res'];
    $other_ress = $_POST['other_ress'];
//    if($res == 'Others'){
//        $reason =$other_ress;
//    }
//    else{
//        $reason = $res;
//    }
    $added_by = $_COOKIE['user_id'];
    $api_key = $_COOKIE['panel_api_key'];
    
    if ($_COOKIE['role'] == 'Super Admin'){
        $sqlValidateCookie = "SELECT * FROM `user_details` WHERE panel_api_key='$api_key'";
    }
    else {
        $sqlValidateCookie = "SELECT * FROM `user` WHERE user_id='$added_by'";
    }
    $resValidateCookie = mysqli_query($conn, $sqlValidateCookie);
    if (mysqli_num_rows($resValidateCookie) > 0) {


        $sqlInsert = "INSERT INTO `adjustment`(`adjustment_id`,`adjustment_date`,`notes`,`reason`,`other_reason`,`added_by`) 
                                            VALUES ('','$adjustment_date','$notes','$res','$other_ress','$added_by')";

        mysqli_query($conn, $sqlInsert);

        $ID=mysqli_insert_id($conn);

        if(strlen($ID)==1)
        {
            $ID='00'.$ID;

        }elseif(strlen($ID)==2)
        {
            $ID='0'.$ID;
        }

        $adjustment_id="A".($ID);

        $sqlUpdate = "UPDATE adjustment SET adjustment_id = '$adjustment_id' WHERE id ='$ID'";
        mysqli_query($conn, $sqlUpdate);



        $tableData = json_decode($_POST['tableData'], true);

        // Loop through the data and insert into the database
        foreach ($tableData as $rowData) {
            $productName = $conn->real_escape_string($rowData['productName']);
            $productCode = $conn->real_escape_string($rowData['productCode']);
            $productId = $conn->real_escape_string($rowData['productId']);
            $reason = $conn->real_escape_string($rowData['adjustmentType']);
            $stock = $conn->real_escape_string($rowData['stock']);
            $unit = $conn->real_escape_string($rowData['unit']);
            $adjustmentType = $conn->real_escape_string($rowData['addsubType']);

            $stk = explode('-', $stock);
            $stock_value = $stk[0];
            $stock_unit = $stk[1];

//            $unit_symbol = explode('>', $stock_unit);
//            $unit_sym = $unit_symbol[0];
//            $unit_bol = $unit_symbol[1];

            $quantity = $conn->real_escape_string($rowData['quantity']);
            $quantity_r=  str_replace("+","",$quantity);
            $quantity_r=  str_replace("-","",$quantity_r);

//            if($unit === 'MT'){
//                $total_stock = (int)$quantity * 1000;
//                if ($adjustmentType === 'addition') {
//                    $stock_add = $stock_value + (int)$total_stock;
//                } elseif ($adjustmentType === 'subtraction') {
//                    $stock_add = $stock_value - (int)$total_stock;
//                }
////                $stock_add = $stock_value + $total_stock;
//            }
//            else{
//                $total_stock = (int)$quantity * 1;
//                if ($adjustmentType === 'addition') {
//                    $stock_add = $stock_value + (int)$total_stock;
//                } elseif ($adjustmentType === 'subtraction') {
//                    $stock_add = $stock_value - (int)$total_stock;
//                }
////                $stock_add = (int)$quantity_r + $total_stock;
//            }
            if($unit === 'MT'){
                $total_stock = (int)$quantity * 1000;
                if ($adjustmentType === 'addition') {
                    $stock_add = $stock_value + (int)$total_stock;
                } elseif ($adjustmentType === 'subtraction') {
                    $stock_add = $stock_value - (int)$total_stock;
                }
            }
            elseif ($unit === 'mm'){
                $total_stock = (int)$quantity * 12;
                if ($adjustmentType === 'addition') {
                    $stock_add = $stock_value + (int)$total_stock;
                } elseif ($adjustmentType === 'subtraction') {
                    $stock_add = $stock_value - (int)$total_stock;
                }
            }
            elseif ($unit === 'bgs'){
                $total_stock = (int)$quantity * 25;
                if ($adjustmentType === 'addition') {
                    $stock_add = $stock_value + (int)$total_stock;
                } elseif ($adjustmentType === 'subtraction') {
                    $stock_add = $stock_value - (int)$total_stock;
                }
            }
            else{
                $total_stock = (int)$quantity * 1;
                if ($adjustmentType === 'addition') {
                    $stock_add = $stock_value + (int)$total_stock;
                } elseif ($adjustmentType === 'subtraction') {
                    $stock_add = $stock_value - (int)$total_stock;
                }
            }
            // Assuming you have a table named 'products'
            $sqlInsersts = "INSERT INTO adjustment_details (adjustment_details_id,product_name,product_id,product_code, stock,Stock_count ,qty,adjustment_type,base_unit,reason) 
                    VALUES ('','$productName','$productCode', '$productId', '$stock','$stock_add','$quantity_r','$adjustmentType','$unit','$reason')";


            mysqli_query($conn, $sqlInsersts);
            $ID = mysqli_insert_id($conn);

            if (strlen($ID) == 1) {
                $ID = '00' . $ID;

            } elseif (strlen($ID) == 2) {
                $ID = '0' . $ID;
            }

            $adjustment_details_id = "AD" . ($ID);
            $sqlUpdate = "UPDATE adjustment_details SET adjustment_details_id = '$adjustment_details_id',adjustment_id='$adjustment_id' WHERE id ='$ID'";
            mysqli_query($conn, $sqlUpdate);


              $sqlStockUpdate = "UPDATE product SET stock_qty = '$stock_add' WHERE product_id ='$productCode'";
            mysqli_query($conn, $sqlStockUpdate);
        }

        $role=$_COOKIE['role'];
        $staff_id=$_COOKIE['user_id'];
        $staff_name=$_COOKIE['user_name'];
        $info = urlencode("Adjustment Added");
        $role = urlencode($role); // Assuming $id is a variable with the emp_id value
        $staff_id = urlencode($staff_id); // Assuming $id is a variable with the emp_id value
        $staff_name = urlencode($staff_name); // Assuming $id is a variable with the emp_id value
        $url = "https://erp.aecindia.net/includes/log_api.php?message=$info&role=$role&staff_id=$staff_id&staff_name=$staff_name";
        file_get_contents($url);

        $json_array['status'] = "success";
        $json_array['msg'] = " Adjustment successfully !!!";
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
