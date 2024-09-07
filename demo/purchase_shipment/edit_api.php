<?php

date_default_timezone_set("Asia/Kolkata");


if(isset($_POST['shipping_id']))
{
    Include("../includes/connection.php");

    $shipping_id = clean($_POST['shipping_id']);
    $date = clean($_POST['date']);
    $payment_terms = clean($_POST['payment_terms']);
    $d_date = clean($_POST['d_date']);
    $d_through = clean($_POST['d_through']);
    $destination = clean($_POST['destination']);
    $other_charges = clean($_POST['other_charges']);
    $vehicle_no = clean($_POST['vehicle_no']);
    $shipping_amount = clean($_POST['shipping_amount']);
    $other_charges = clean($_POST['other_charges']);

//    $date = date('Y-m-d');

    $api_key = $_COOKIE['panel_api_key'];
    $added_by = $_COOKIE['user_id'];
    if ($_COOKIE['role'] == 'Super Admin'){
        $sqlValidateCookie = "SELECT * FROM `user_details` WHERE panel_api_key='$api_key'";
    }
    else {
        $sqlValidateCookie = "SELECT * FROM `user` WHERE user_id='$added_by'";
    }
    $resValidateCookie=mysqli_query($conn,$sqlValidateCookie);
    if(mysqli_num_rows($resValidateCookie) > 0) {

        $sqlValidate = "SELECT * FROM `purchase_shipment` WHERE shipping_id='$shipping_id'";
        $resValidate = mysqli_query($conn, $sqlValidate);
        if (mysqli_num_rows($resValidate) > 0 || ($shipping_id==$shipping_id)) {

                        $sqlUpdate = "UPDATE `purchase_shipment` SET `shipping_id`='$shipping_id',`destination`='$destination',`dispatched_through`='$d_through',`delivery_date`='$d_date',`shipping_amount`='$shipping_amount',`terms_delivery`='$payment_terms',`vehicle_no`='$vehicle_no',`other_charges`='$other_charges',`ps_date`='$date' WHERE `shipping_id`='$shipping_id';";
                        mysqli_query($conn, $sqlUpdate);



                    //inserted successfully
                    $json_array['status'] = "success";
                    $json_array['msg'] = "Updated successfully !!!";
                    $json_response = json_encode($json_array);
                    echo $json_response;

                }
//
// else {
//
//
//                    $json_array['status'] = "failure";
//                    $json_array['msg'] = "Cheque To Number Already Exist!!!";
//                    $json_response = json_encode($json_array);
//                    echo $json_response;
//                }
//            } else {
//
//
//                $json_array['status'] = "failure";
//                $json_array['msg'] = "Cheque From Number Already Exist!!!";
//                $json_response = json_encode($json_array);
//                echo $json_response;
//            }

        else {
            //Parameters missing

            $json_array['status'] = "failure";
            $json_array['msg'] = "Shipment ID Is Not Valid";
            $json_response = json_encode($json_array);
            echo $json_response;
        }

              }  else {


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
