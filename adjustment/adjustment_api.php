<?php
Include("../includes/connection.php");

date_default_timezone_set("Asia/Kolkata");

// if(isset($_POST['supplier'])&&isset($_POST['purchase_date'])) {

//    $added_by = $_COOKIE['user_id'];

$api_key = $_COOKIE['panel_api_key'];

$sqlValidateCookie = "SELECT * FROM `user_details` WHERE panel_api_key='$api_key'";
$resValidateCookie = mysqli_query($conn, $sqlValidateCookie);
if (mysqli_num_rows($resValidateCookie) > 0) {

    $adjustmentId = "SELECT adjustment_id FROM adjustment ORDER BY id DESC LIMIT 1";
    $resAdjustmentId = mysqli_query($conn, $adjustmentId);
    $rowAdjustmentId = mysqli_fetch_assoc($resAdjustmentId);
    $adjustment_id =  $rowAdjustmentId['adjustment_id'];

    $tableData = json_decode($_POST['tableData'], true);

    // Loop through the data and insert into the database
    foreach ($tableData as $rowData) {
        $productName = $conn->real_escape_string($rowData['productName']);
        $netUnitCost = $conn->real_escape_string($rowData['netUnitCost']);
        $stock = $conn->real_escape_string($rowData['stock']);
        $quantity = $conn->real_escape_string($rowData['quantity']);
        $type = $conn->real_escape_string($rowData['type']);
//        $tax = $conn->real_escape_string($rowData['tax']);
//        $subtotal = $conn->real_escape_string($rowData['subtotal']);

        // Assuming you have a table named 'products'
        $sqlInsert = "INSERT INTO adjustment_details (adjustment_details_id,product_id,unit_cost, stock, types, qty) 
                    VALUES ('','$productName', '$netUnitCost', '$stock', '$type', '$quantity')";


        mysqli_query($conn, $sqlInsert);

        $ID=mysqli_insert_id($conn);

        if(strlen($ID)==1)
        {
            $ID='00'.$ID;

        }elseif(strlen($ID)==2)
        {
            $ID='0'.$ID;
        }

        $adjustment_details_id="AD".($ID);
        $sqlUpdate = "UPDATE adjustment_details SET adjustment_details_id = '$adjustment_details_id',adjustment_id='$adjustment_id' WHERE id ='$ID'";
        mysqli_query($conn, $sqlUpdate);
    }
    $json_array['status'] = "success";
    $json_array['msg'] = "Added success";
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
// }
// else
// {
//     //Parameters missing

//     $json_array['status'] = "failure";
//     $json_array['msg'] = "Please try after sometime !!!";
//     $json_response = json_encode($json_array);
//     echo $json_response;
// }



function clean($data) {
    return filter_var($data, FILTER_SANITIZE_STRING, FILTER_FLAG_STRIP_HIGH);
}



?>
