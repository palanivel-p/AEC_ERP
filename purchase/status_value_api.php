<?php
include("../includes/connection.php");

if (isset($_POST['status_id'])) {
    $status_id = $_POST['status_id'];
    $api_key = $_COOKIE['panel_api_key'];
    $added_by = $_COOKIE['user_id'];

    // Validate user based on role
    if ($_COOKIE['role'] == 'Super Admin') {
        $sqlValidateCookie = "SELECT * FROM `user_details` WHERE panel_api_key='$api_key'";
    } else {
        $sqlValidateCookie = "SELECT * FROM `user` WHERE user_id='$added_by'";
    }

    $resValidateCookie = mysqli_query($conn, $sqlValidateCookie);
    if (mysqli_num_rows($resValidateCookie) > 0) {
        // Validate if the status exists for the given purchase_id
        $sqlValidateStatus = "SELECT * FROM `status` WHERE purchase_id='$status_id'";
        $resValidateStatus = mysqli_query($conn, $sqlValidateStatus);

        if (mysqli_num_rows($resValidateStatus) > 0) {
            // Query when status exists
            $sqlData = "SELECT pd.product_id, pd.qty, p.product_name, s.material 
                        FROM `purchase_details` pd 
                        JOIN `product` p ON pd.product_id = p.product_id 
                        JOIN `status` s ON pd.purchase_id = s.purchase_id 
                        WHERE pd.purchase_id='$status_id'";
            $resData = mysqli_query($conn, $sqlData);

            if (mysqli_num_rows($resData) > 0) {
                $data = [];
                while ($row = mysqli_fetch_assoc($resData)) {
                    // Update material value
                    $material = $row['material'] + $row['material'];
                    // Calculate status qty
                    $status_qty = $row['qty'] - $material;

                    $data[] = [
                        'product_id' => $row['product_id'],
                        'product_name' => $row['product_name'],
                        'status_qty' => $status_qty,
                        'material' => $material
                    ];
                }

                $json_array['status'] = 'success';
                $json_array['data'] = $data;
            } else {
                $json_array['status'] = 'failure';
                $json_array['msg'] = 'No data found';
            }
        } else {
            // Query when status does not exist
            $sqlData = "SELECT pd.product_id, pd.qty, p.product_name 
                        FROM `purchase_details` pd 
                        JOIN `product` p ON pd.product_id = p.product_id 
                        WHERE pd.purchase_id='$status_id'";
            $resData = mysqli_query($conn, $sqlData);

            if (mysqli_num_rows($resData) > 0) {
                $data = [];
                while ($row = mysqli_fetch_assoc($resData)) {
                    $data[] = $row;
                }

                $json_array['status'] = 'wrong';
                $json_array['data'] = $data;
            } else {
                $json_array['status'] = 'failure';
                $json_array['msg'] = 'No data found';
            }
        }
    } else {
        $json_array['status'] = "wrong";
        $json_array['msg'] = "Login Invalid";
    }
} else {
    $json_array['status'] = "failure";
    $json_array['msg'] = "Please try after sometime !!!";
}

echo json_encode($json_array);
?>
