<?php
Include("../includes/connection.php");

date_default_timezone_set("Asia/Kolkata");

if(isset($_POST['intend_date'])) {

    $intend_date = clean($_POST['intend_date']);

    $notes = $_POST['notes'];

//    $date = date('Y-m-d');
//    $added_by = $_COOKIE['user_id'];
    $added_by = 'test';

    $api_key = $_COOKIE['panel_api_key'];

    $sqlValidateCookie = "SELECT * FROM `user_details` WHERE panel_api_key='$api_key'";
    $resValidateCookie = mysqli_query($conn, $sqlValidateCookie);
    if (mysqli_num_rows($resValidateCookie) > 0) {


        $sqlInsert = "INSERT INTO `intend`(`intend_id`,`intend_date`,`notes`,`added_by`) 
                                            VALUES ('','$intend_date','$notes','$added_by')";

        mysqli_query($conn, $sqlInsert);

        $ID=mysqli_insert_id($conn);

        if(strlen($ID)==1)
        {
            $ID='00'.$ID;

        }elseif(strlen($ID)==2)
        {
            $ID='0'.$ID;
        }

        $intend_id="I".($ID);

        $sqlUpdate = "UPDATE intend SET intend_id = '$intend_id' WHERE id ='$ID'";
        mysqli_query($conn, $sqlUpdate);



        $tableData = json_decode($_POST['tableData'], true);

        // Loop through the data and insert into the database
        foreach ($tableData as $rowData) {
            $productName = $conn->real_escape_string($rowData['productName']);
            $productId = $conn->real_escape_string($rowData['productId']);
            $reasonType = $conn->real_escape_string($rowData['reasonType']);
            $stock = $conn->real_escape_string($rowData['stock']);
            $unit = $conn->real_escape_string($rowData['unit']);

            $stk = explode('-', $stock);
            $stock_value = $stk[0];
            $stock_unit = $stk[1];

//            $unit_symbol = explode('>', $stock_unit);
//            $unit_sym = $unit_symbol[0];
//            $unit_bol = $unit_symbol[1];

            $quantity = $conn->real_escape_string($rowData['quantity']);
//            $quantity_r=  str_replace("+","",$quantity);
//            $quantity_r=  str_replace("-","",$quantity_r);

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

            // Assuming you have a table named 'products'
            $sqlInsersts = "INSERT INTO intend_details (intend_details_id,intend_date,product_name,product_id, stock ,qty,reasonType,base_unit) 
                    VALUES ('','$intend_date','$productName', '$productId', '$stock','$quantity','$reasonType','$unit')";


            mysqli_query($conn, $sqlInsersts);
            $ID = mysqli_insert_id($conn);

            if (strlen($ID) == 1) {
                $ID = '00' . $ID;

            } elseif (strlen($ID) == 2) {
                $ID = '0' . $ID;
            }

            $intend_details_id = "ID" . ($ID);
            $sqlUpdate = "UPDATE intend_details SET intend_details_id = '$intend_details_id',intend_id='$intend_id' WHERE id ='$ID'";
            mysqli_query($conn, $sqlUpdate);

//
//              $sqlStockUpdate = "UPDATE product SET stock_qty = '$stock_add' WHERE product_id ='$productId'";
//            mysqli_query($conn, $sqlStockUpdate);
        }



        $json_array['status'] = "success";
        $json_array['msg'] = " Intend Raised successfully !!!";
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
