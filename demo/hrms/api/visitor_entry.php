
<?php
header('Access-Control-Allow-Origin: *');
date_default_timezone_set("Asia/Kolkata");
require '../phpqrcode-master/qrlib.php';

if(isset($_POST['name']) && isset($_POST['mobile'])&& isset($_POST['company'])&&($_POST['purpose']) && isset($_POST['to_person'])&& isset($_POST['api_key'])&& isset($_POST['count'])) {
    $name = clean($_POST['name']);
    $mobile = clean($_POST['mobile']);
    $company = clean($_POST['company']);
    $api_key = $_POST['api_key'];
    $count = $_POST['count'];
    $purpose = clean($_POST['purpose']);
    $to_person_id = clean($_POST['to_person']);
    $date = date("Y-m-d H:i:s");

    Include("../../includes/connection.php");

    $sqlquery = "select * from devices where api_key='$api_key'";
    $result = mysqli_query($conn, $sqlquery);

    if (mysqli_num_rows($result) > 0) {


        $sqlInsert = "insert into `visitor_details`(`name`,`mobile`,`company`,`purpose`,`to_emp_id`,`visit_dt`,`count`) values ('$name','$mobile','$company','$purpose','$to_person_id','$date','$count')";
        mysqli_query($conn, $sqlInsert);


        $ID = mysqli_insert_id($conn);
        //$ID = 1;

        if (strlen($ID) == 1) {
            $ID = '00' . $ID;

        } elseif (strlen($ID) == 2) {
            $ID = '0' . $ID;
        }

        $v_id = "V" . ($ID);

        $sqlUpdate = "UPDATE `visitor_details` SET visitor_id ='$v_id' WHERE id ='$ID'";
        mysqli_query($conn, $sqlUpdate);


        $output = null;

        for ($loop = 0; $loop < 7; $loop++) {
            for ($isRandomInRange = 0; $isRandomInRange === 0;) {
                $isRandomInRange = isRandomInRange(findRandom());
            }

            $output .= $isRandomInRange;
        }

        $qr_code = $output . $v_id;

        $sqlUpdates = "UPDATE `visitor_details` SET qr_code ='$qr_code' WHERE id ='$ID'";
        mysqli_query($conn, $sqlUpdates);

        $sqlUpdatess = "UPDATE `devices` SET `door_status` ='1' WHERE api_key='$api_key'";
        mysqli_query($conn, $sqlUpdatess);

        $sqlqueryss = "select * from staff where staff_id='$to_person_id'";
        $resultss = mysqli_query($conn, $sqlqueryss);

        $rows = mysqli_fetch_array($resultss);

        $meet_person = $rows['staff_name'];


//        $qr_code_url = "https://chart.googleapis.com/chart?chs=300x300&cht=qr&chl=" . urlencode($qr_code) . "&choe=UTF-8";
//        $qr_code_url = "https://api.qrserver.com/v1/create-qr-code/?size=300x300&data=" . urlencode($qr_code);

        // Fetch the image data from the URL
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
        QRcode::png($qr_code, $output_file, $eccLevel, $pixelSize, $frameSize, false, $white, $black);


        $qr_code_url = 'https://gbtc.officetime.in/qr_code/' . $v_id . '.png';
        $filename = $folderPath . $v_id . '.png';

        $filenames = 'https://gbtc.officetime.in/qr_code/' . $v_id . '.png';

        $msg = "*Welcome to GB Tech Corp* !!! %0A *Name*: " . $name . " %0A *Company*: " . $company . " %0A *To Meet*: " . $meet_person . " %0A *Purpose*: " . $purpose . "%0A *Scan Below Image to Exit* ";


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
//        $whatsapp = "http://103.174.102.65/api/wapi?apikey=dc68bed2a269e64b1151fc5166db94cf&mobile=" . $mobile . "&msg=" . $msg . "&img1=" . $filenames;


        // Use file_get_contents to send the WhatsApp message

            $whatsapp = str_replace(" ", "%20", $whatsapp);
            $result = file_get_contents($whatsapp);


            $gallery_id = $v_id;

            $uploadDir = '../visitors/';
            $new_image_name = $gallery_id . '.jpg';


            $uploadedFile = '';
            if (!empty($_FILES["upload_image"]["name"])) {


//                if (($_FILES['upload_image']['size']) <= $maxSize) {

                $targetFilePath = $uploadDir . $new_image_name;
                $fileType = pathinfo($targetFilePath, PATHINFO_EXTENSION);

                $allowTypes = array('jpg', 'jpeg');
                if (in_array($fileType, $allowTypes)) {

                    if (!move_uploaded_file($_FILES["upload_image"]["tmp_name"], $targetFilePath)) {

//not uploaded
                        $json_array['status'] = "failure";
                        $json_array['msg'] = "Image not uploadedddd!!!";
                        $json_response = json_encode($json_array);
                        echo $json_response;
                    } else {
                        $sqlUpdates = "UPDATE visitor_details SET img =1 WHERE visitor_id ='$gallery_id'";
                        mysqli_query($conn, $sqlUpdates);


//                        $info = urlencode("Added Gallery" );
//                        file_get_contents($website . "portal/includes/log.php?emp_id=$emp_role&info=$info");


                        $json_array['status'] = "success";
                        $json_array['msg'] = "Added Successfully !!!";
                        $json_response = json_encode($json_array);
                        echo $json_response;





                        sleep(1);
                        unlink($folderPath . $v_id . '.png');

                    }
                } else {
                    //allow type
                    $json_array['status'] = "failure";
                    $json_array['msg'] = "change Image type not uploaded!!!";
                    $json_response = json_encode($json_array);
                    echo $json_response;
                }


//                }
//                else {
//                    // max size
//                    $json_array['status'] = "failure";
//                    $json_array['msg'] = "change Image size not uploaded!!!";
//                    $json_response = json_encode($json_array);
//                    echo $json_response;
//                }


            } else {
                //not upload
                $json_array['status'] = "failure";
                $json_array['msg'] = "Image not uploaded!!!";
                $json_response = json_encode($json_array);
                echo $json_response;
            }

        } else {
            $json_array['status'] = "failure";
            $json_array['msg'] = "invalid device";
            $json_response = json_encode($json_array);
            echo $json_response;
        }
        sleep(1);
        unlink($folderPath . $v_id . '.png');

}else {
        $json_array['status'] = "failure";
        $json_array['msg'] = "Parameters Missing";
        $json_response = json_encode($json_array);
        echo $json_response;
    }


    function isRandomInRange($mRandom)
    {
        if (($mRandom >= 58 && $mRandom <= 64) ||
            (($mRandom >= 91 && $mRandom <= 96))) {
            return 0;
        } else {
            return $mRandom;
        }
    }

    function findRandom()
    {
        $mRandom = rand(48, 122);
        return $mRandom;
    }


    function clean($data)
    {
        $data = str_replace("'", "", $data);
        $data = str_replace('"', "", $data);
        return filter_var($data, FILTER_SANITIZE_STRING, FILTER_FLAG_STRIP_HIGH);
    }


?>