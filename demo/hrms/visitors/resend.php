<?php
header('Access-Control-Allow-Origin: *');


if (isset($_POST['id'])) {
    $v_id = $_POST['id'];

    Include("../../includes/connection.php");

    // Use prepared statement to prevent SQL injection
    $sqlquery = "SELECT * FROM `visitor_details` WHERE visitor_id='$v_id'";

    // Prepare the statement
    $result = mysqli_query($conn,$sqlquery);



    // Check if there are rows
    if (mysqli_num_rows($result) > 0) {
        $row = mysqli_fetch_array($result);

        $name=$row['name'];
        $mobile= $row['mobile'];
        $qr= $row['qr_code'];
        $company = $row['company'];
        $purpose = $row['purpose'];
        $to_person_id = $row['to_emp_id'];

        $sqlqueryss = "select * from staff where staff_id='$to_person_id'";
        $resultss = mysqli_query($conn, $sqlqueryss);

        $rows = mysqli_fetch_array($resultss);

        $meet_person= $rows['staff_name'];



//        $qr_code_url = "https://chart.googleapis.com/chart?chs=300x300&cht=qr&chl=" . urlencode($qr) . "&choe=UTF-8";
//        $qr_code_url = "https://api.qrserver.com/v1/create-qr-code/?size=300x300&data=" . urlencode($qr);
        $folderPath = '../qr_code/';

        if (!is_dir($folderPath)) {
            mkdir($folderPath, 0755, true);
        }
        $output_file = $folderPath . $v_id . '.png';


        $black = 'FFFFFF'; // Black color for the QR Code
        $white = '000000'; // White color for the background

        // Convert Hexadecimal to RGB, then combine into an integer
        $black = intval(hexdec($black));
        $white = intval(hexdec($white));

        $pixelSize = 10;
        $frameSize = 1; // Frame size
        $eccLevel = QR_ECLEVEL_L; // Error Correction Level
        QRcode::png($qr, $output_file, $eccLevel, $pixelSize, $frameSize, false, $white, $black);



        $qr_code_url = 'https://jbcargo.in/hrms/visitors/qr_code/' . $v_id . '.png';
        $filename = $folderPath . $v_id . '.png';





        $filenames = 'https://jbcargo.in/hrms/visitors/qr_code/' . $v_id . '.png';


        $msg = "*Welcome to Cargo* !!! %0A *Name*: " . $name . " %0A *Company*: " . $company . " %0A *To Meet*: " . $meet_person . " %0A *Purpose*: " . $purpose . "%0A *Scan Below Image to Exit* ";


        $sqlquerys = "select * from `whatsapp`";
        $results = mysqli_query($conn, $sqlquerys);

        if (mysqli_num_rows($results) > 0) {
            $rows = mysqli_fetch_array($results);

            $whatsapp= $rows['url'];
            $whatsapp = str_replace('off_msg', $msg, $whatsapp);
            $whatsapp = str_replace('off_mobile', $mobile, $whatsapp);
            $whatsapp = str_replace('off_img', $filenames, $whatsapp);

//            $whatsapp = "http://103.174.102.65/api/wapi?apikey=dc68bed2a269e64b1151fc5166db94cf&mobile=" . $mobile . "&msg=" . $msg . "&img1=" . $filenames;
//            $whatsapp = "http://103.174.102.65/api/wapi?apikey=dc68bed2a269e64b1151fc5166db94cf&mobile=off_mobile&msg=off_msg&img1=off_img";
        }

//        $file_name='QR code';
//
//
//        $whatsapp = "https://chatway.in/api/send-file?username=" . urlencode($username) .
//            "&number=" . urlencode($mobile) .
//            "&message=" . urlencode($msg) .
////            "&token=" . urlencode($token) .
//            "&file_url=" . urlencode($filenames) .
//            "&file_name=" . urlencode($file_name);

//            $whatsapp = "https://chatway.in/api/send-file?username=OVZvMGJjR2w0cXdvMmluREpBTmRsQT09&number=" . $mobile . "&message=" . $msg . "&file_url=. $filenames";


        // Use file_get_contents to send the WhatsApp message

        $whatsapp = str_replace(" ", "%20", $whatsapp);
        $result = file_get_contents($whatsapp);

        if ($result !== false) {
            // unlink($folderPath . $v_id . '.png');
        }




        $json_array['status'] = 'success';

        $json_response = json_encode($json_array);
        echo $json_response;

        sleep(3);
        unlink( $folderPath . $v_id . '.png');

    }
    else {
        // Visitor ID not found
        $json_array['status'] = "failure";
        $json_array['msg'] = "Invalid visitor ID !!!";
        $json_response = json_encode($json_array);
        echo $json_response;
    }
} else {
    // No ID provided
    $json_array['status'] = "failure";
    $json_array['msg'] = "Please try after sometime !!!";
    $json_response = json_encode($json_array);
    echo $json_response;
}
?>