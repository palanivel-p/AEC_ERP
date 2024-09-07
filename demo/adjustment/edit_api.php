<?php
Include("../includes/connection.php");

date_default_timezone_set("Asia/Kolkata");


if(isset($_POST['adjustment_id'])) {

    $adjustment_id = $_POST['adjustment_id'];
    $adjustment_date = $_POST['adjustment_date'];
    $notes = $_POST['notes'];
    $res = $_POST['res'];
    $other_ress = $_POST['other_ress'];
    $api_key = $_COOKIE['panel_api_key'];

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


        $sqlUpdate = "UPDATE `adjustment` SET `adjustment_id`='$adjustment_id',`adjustment_date`='$adjustment_date',`notes`='$notes',`reason`='$res',`other_reason`='$other_ress' WHERE `adjustment_id`='$adjustment_id'";
        mysqli_query($conn, $sqlUpdate);

        $sqlDelete = "DELETE FROM adjustment_details WHERE adjustment_id = '$adjustment_id'";
        mysqli_query($conn, $sqlDelete);

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

            if($unit === 'MT'){
                $total_stock = (int)$quantity * 1000;
                if ($adjustmentType === 'addition') {
                    $stock_add = $stock_value + (int)$total_stock;
                } elseif ($adjustmentType === 'subtraction') {
                    $stock_add = $stock_value - (int)$total_stock;
                }
//                $stock_add = $stock_value + $total_stock;
            }
            else{
                $total_stock = (int)$quantity * 1;
                if ($adjustmentType === 'addition') {
                    $stock_add = $stock_value + (int)$total_stock;
                } elseif ($adjustmentType === 'subtraction') {
                    $stock_add = $stock_value - (int)$total_stock;
                }
//                $stock_add = (int)$quantity_r + $total_stock;
            }

            // Assuming you have a table named 'products'
            $sqlInsersts = "INSERT INTO adjustment_details (adjustment_details_id,adjustment_id,product_name,product_id,product_code, stock,Stock_count ,qty,adjustment_type,base_unit,reason) 
                    VALUES ('','$adjustment_id','$productName', '$productCode','$productId', '$stock','$stock_add','$quantity_r','$adjustmentType','$unit','$reason')";


            mysqli_query($conn, $sqlInsersts);
            $ID = mysqli_insert_id($conn);

            if (strlen($ID) == 1) {
                $ID = '00' . $ID;

            } elseif (strlen($ID) == 2) {
                $ID = '0' . $ID;
            }

            $adjustment_details_id = "AD" . ($ID);
            $sqlUpdate = "UPDATE adjustment_details SET adjustment_details_id = '$adjustment_details_id' WHERE id ='$ID'";
            mysqli_query($conn, $sqlUpdate);


            $sqlStockUpdate = "UPDATE product SET stock_qty = '$stock_add' WHERE product_id ='$productCode'";
            mysqli_query($conn, $sqlStockUpdate);
        }

        $json_array['status'] = "success";
        $json_array['msg'] = "Updated successfully !!!";
        $json_response = json_encode($json_array);
        echo $json_response;

//        } else {
//
//            $json_array['status'] = "failure";
//            $json_array['msg'] = "Adjustment ID Is Not Valid";
//            $json_response = json_encode($json_array);
//            echo $json_response;
//        }

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
