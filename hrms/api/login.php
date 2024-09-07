<?php
Include("../../includes/connection.php");

if(isset($_GET['email']) && isset($_GET['password'])&& isset($_GET['din'])) {

    $email = clean($_GET['email']);

    $password = clean($_GET['password']);

    $din = clean($_GET['din']);

    $salt= 'NbTMUcflGKePnFi';
    $password_salt = sha1($salt.$password);


    $sqlquery = "select * from devices where din='$din'";
    $result = mysqli_query($conn, $sqlquery);

    if (mysqli_num_rows($result) > 0) {




        $api_output = null;

        for ($loop = 0; $loop <= 14; $loop++) {
            for ($isRandomInRange = 0; $isRandomInRange === 0;) {
                $isRandomInRange = isRandomInRange(findRandom());
            }

            $api_output .= html_entity_decode('&#' . $isRandomInRange . ';');
        }


        // echo $output ."<br>"; // API key

        $sqlUpdates = "UPDATE devices SET api_key ='$api_output' WHERE din='$din'";
        mysqli_query($conn, $sqlUpdates);
//        $rows = mysqli_fetch_array($result);

        $sqlValidate = "SELECT * FROM `staff` WHERE staff_email='$email' AND password='$password_salt' AND status=1 AND office_time_access='super_admin'";
        $resValidate = mysqli_query($conn, $sqlValidate);



        if (mysqli_num_rows($resValidate) > 0) {
            $row = mysqli_fetch_array($resValidate);


            $sqlquery = "SELECT * FROM `face_license` ORDER BY `id` ASC LIMIT 1;";
            $result = mysqli_query($conn, $sqlquery);
            $rows = mysqli_fetch_array($result);
//            $api_key = $rows['api_key'];

            $package_name = $rows['package_name'];
            $license_key = $rows['license_key'];
            $logo = "https://gbtc.officetime.in/image/GBTC.png";
            $admin_id = $row['staff_id'];
            $admin_name = $row['staff_name'];
            $admin_img = "https://gbtc.officetime.in/employee_img/" . $row['staff_id'] . ".jpg";
//            $admin_img = "https://gbtc.officetime.in/employee_img/GBT013.jpg";


            $json_array['status'] = "success";
            $json_array['msg'] = "success";
            $json_array['package_name'] = $package_name;
            $json_array['license_key'] = $license_key;
            $json_array['logo'] = $logo;
            $json_array['api_key'] = $api_output;
            $json_array['image'] = $admin_img;
            $json_array['admin_id'] = $admin_id;
            $json_array['admin_name'] = $admin_name;
            $json_response = json_encode($json_array);
            echo $json_response;

        } else {


            $json_array['status'] = "failure";
            $json_array['msg'] = "Invalid Admin details!!!";
            $json_array['package_name'] = '';
            $json_array['license_key'] = '';
            $json_array['logo'] = "";
            $json_array['api_key'] = "";
            $json_array['image'] = "";
            $json_array['admin_id'] = "";
            $json_array['admin_name'] = "";
            $json_response = json_encode($json_array);
            echo $json_response;
        }


    }
    else {


        $json_array['status'] = "failure";
        $json_array['msg'] = "Invalid device!!!";
        $json_array['package_name'] = '';
        $json_array['license_key'] = '';
        $json_array['logo'] = "";
        $json_array['api_key'] = "";
        $json_array['image'] = "";
        $json_array['admin_id'] = "";
        $json_array['admin_name'] = "";
        $json_response = json_encode($json_array);
        echo $json_response;
    }

}
else
{
    //Parameters missing

    $json_array['status'] = "failure";
    $json_array['msg'] = "Parameters missing!!!";
    $json_array['package_name'] = '';
    $json_array['license_key'] = '';
    $json_array['logo'] ="" ;
    $json_array['api_key'] = "";
    $json_array['image'] ="" ;
    $json_array['admin_id'] = "";
    $json_array['admin_name'] ="" ;
    $json_response = json_encode($json_array);
    echo $json_response;
}





function clean($data) {
    $data= str_replace("'","",$data);
    $data= str_replace('"',"",$data);
    return filter_var($data, FILTER_SANITIZE_STRING, FILTER_FLAG_STRIP_HIGH);
}

function isRandomInRange($mRandom) {
    if(($mRandom >=58 && $mRandom <= 64) ||
        (($mRandom >=91 && $mRandom <= 96))) {
        return 0;
    } else {
        return $mRandom;
    }
}

function findRandom() {
    $mRandom = rand(48, 122);
    return $mRandom;
}
?>