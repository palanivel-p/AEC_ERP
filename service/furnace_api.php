<?php


date_default_timezone_set("Asia/Kolkata");

if(isset($_POST['service_type'])&& isset($_POST['service_id'])) {
    Include("../includes/connection.php");
    //furnace&laddle
    $service_type = clean($_POST['service_type']);
    $service_id = clean($_POST['service_id']);
    $furnace_id = clean($_POST['furnace_id']);
    $service_add = clean($_POST['service_add']);
    $capacity = clean($_POST['capacity']);
    $furnace_no = clean($_POST['furnace_no']);
    $furnace_top = clean($_POST['furnace_top']);
    $furnace_bottom = clean($_POST['furnace_bottom']);
    $furnace_height = clean($_POST['furnace_height']);
    $visit_date = clean($_POST['visit_date']);
    $material_type = clean($_POST['material_type']);

    $gld = clean($_POST['gld']);
    $fork_height = clean($_POST['fork_height']);
    $sharpness = clean($_POST['sharpness']);
    $tapping_temperature = clean($_POST['tapping_temperature']);
    $power = clean($_POST['power']);

    $panel_capacity = clean($_POST['panel_capacity']);
    $product_name = clean($_POST['product_name']);
    $grey = clean($_POST['grey']);
    $batch_no = clean($_POST['batch_no']);
    $former_top = clean($_POST['former_top']);
    $former_bottom = clean($_POST['former_bottom']);
    $former_height = clean($_POST['former_height']);
    $former_tapper = clean($_POST['former_tapper']);

    $gld_dimension = clean($_POST['gld_dimension']);
    $remark = clean($_POST['remark']);
    $thickness_bottom = clean($_POST['thickness_bottom']);
    $thickness_side = clean($_POST['thickness_side']);
    $total_weight = clean($_POST['total_weight']);
    $company_name = clean($_POST['customer_name']);

    $personalLoan = $_POST['personalLoan'];
    $personalLoanAr = explode(",",$personalLoan);
    $countPersonalLoans = count($personalLoanAr);

    $homeLoan = $_POST['homeLoan'];
    $homeLoanAr = explode(",",$homeLoan);
    $countHomeLoans = count($homeLoanAr);

    //wet lining
    $wet_lining_id = clean($_POST['furnace_idwet']);
    $customer_wet = clean($_POST['customer_wet']);
    $visit_datewet = clean($_POST['visit_datewet']);
    $venuewet = clean($_POST['venuewet']);
    $laddle_nowet = clean($_POST['laddle_nowet']);
    $capacitywet = clean($_POST['capacitywet']);
    $laddle_diawet = clean($_POST['laddle_diawet']);
    $laddle_heightwet = clean($_POST['laddle_heightwet']);
    $former_diawet = clean($_POST['former_diawet']);
    $former_heightwet = clean($_POST['former_heightwet']);
    $product_usedwet = clean($_POST['product_usedwet']);
    $batch_nowet = clean($_POST['batch_nowet']);
    $liquidwet = clean($_POST['liquidwet']);
    $waterwet = clean($_POST['waterwet']);
    $material_typewet = clean($_POST['material_typewet']);
    $pendingwet = clean($_POST['pendingwet']);
    $wastagewet = clean($_POST['wastagewet']);
    $lining_end_timewet = clean($_POST['lining_end_timewet']);
    $remarkwet = clean($_POST['remarkwet']);
    $thickness_bottomwet = clean($_POST['thickness_bottomwet']);
    $thickness_sidewet = clean($_POST['thickness_sidewet']);
    $total_weightwet = clean($_POST['total_weightwet']);

    $wetB = $_POST['wetB'];
    $wetBAr = explode(",",$wetB);
    $countwetBs = count($wetBAr);

    $wetS = $_POST['wetS'];
    $wetSAr = explode(",",$wetS);
    $countwetSs = count($wetSAr);


    //Dry lining
    $dry_lining_id = clean($_POST['furnace_iddry']);
    $customer_dry = clean($_POST['customer_dry']);
    $visit_datedry = clean($_POST['visit_datedry']);
    $Venuedry = clean($_POST['Venuedry']);
    $laddle_nodry = clean($_POST['laddle_nodry']);
    $capacitydry = clean($_POST['capacitydry']);
    $laddle_diadry = clean($_POST['laddle_diadry']);
    $laddle_heightdry = clean($_POST['laddle_heightdry']);
    $former_diadry = clean($_POST['former_diadry']);
    $former_heightdry = clean($_POST['former_heightdry']);
    $product_useddry = clean($_POST['product_useddry']);
    $batch_nodry = clean($_POST['batch_nodry']);
    $material_typedry = clean($_POST['material_typedry']);
    $lining_start_timedry = clean($_POST['lining_start_timedry']);
    $former_remove_timedry = clean($_POST['former_remove_timedry']);
    $firing_timedry = clean($_POST['firing_timedry']);
    $lining_end_timedry = clean($_POST['lining_end_timedry']);
    $wastagedry = clean($_POST['wastagedry']);
    $typedry = clean($_POST['typedry']);
    $remarkdry = clean($_POST['remarkdry']);
    $thickness_bottomdry = clean($_POST['thickness_bottomdry']);
    $thickness_sidedry = clean($_POST['thickness_sidedry']);
    $total_weightdry = clean($_POST['total_weightdry']);

    $dryB = $_POST['dryB'];
    $dryBAr = explode(",",$dryB);
    $countdryBs = count($dryBAr);

    $dryS = $_POST['dryS'];
    $drySAr = explode(",",$dryS);
    $countdrySs = count($drySAr);

    //Erosion
    $erosion_id = clean($_POST['furnace_ider']);
    $customer_er = clean($_POST['customer_er']);
    $dateer = clean($_POST['dateer']);
    $material_typeer = clean($_POST['material_typeer']);
    $locationer = clean($_POST['locationer']);
    $ms_nameer = clean($_POST['ms_nameer']);
    $ms_mobileer = clean($_POST['ms_mobileer']);
    $mm_nameer = clean($_POST['mm_nameer']);
    $mm_mobileer = clean($_POST['mm_mobileer']);
    $monthly_productioner = clean($_POST['monthly_productioner']);
    $temper = clean($_POST['temper']);
    $powerer = clean($_POST['powerer']);
    $capacityer = clean($_POST['capacityer']);
    $sger = clean($_POST['sger']);
    $greyer = clean($_POST['greyer']);
    $batch_noer = clean($_POST['batch_noer']);
    $typeer = clean($_POST['typeer']);
    $materialer = clean($_POST['materialer']);
    $brickser = clean($_POST['brickser']);
    $competiterer = clean($_POST['competiterer']);
    $d1_c1 = clean($_POST['d1_c1']);
    $d2_c2 = clean($_POST['d2_c2']);
    $d3_c3 = clean($_POST['d3_c3']);
    $h1_h2 = clean($_POST['h1_h2']);
    $heat_gone = clean($_POST['heat_gone']);
    $Ad1_Ac1 = clean($_POST['Ad1_Ac1']);
    $Ad2_Ac2 = clean($_POST['Ad2_Ac2']);
    $Ad3_Ac3 = clean($_POST['Ad3_Ac3']);
    $Ah1_h2 = clean($_POST['Ah1_h2']);

    $erL = $_POST['erL'];
    $erLAr = explode(",",$erL);
    $counterLs = count($erLAr);

    $erF = $_POST['erF'];
    $erFAr = explode(",",$erF);
    $counterFs = count($erFAr);

    $date = date('Y-m-d');
//    $added_by = $_COOKIE['user_id'];
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

        //Furnace lining
        if($service_type == 'Furnace Lining') {
            if($service_add ==1){

                $sqlUpdate_furnace = "UPDATE furnace SET service_type = '$service_type',service_id = '$service_id',visit_date = '$visit_date',capacity = '$capacity',company_name = '$company_name',furnace_top = '$furnace_top',furnace_bottom = '$furnace_bottom',furnace_height = '$furnace_height',material_type = '$material_type',gld = '$gld',fork_height = '$fork_height',sharpness = '$sharpness',tapping_temperature = '$tapping_temperature',power = '$power',panel_capacity = '$panel_capacity',product_name = '$product_name',grey = '$grey',batch_no='$batch_no',former_top='$former_top',former_bottom='$former_bottom',former_height='$former_height',former_tapper='$former_tapper',gld_dimension = '$gld_dimension',remark = '$remark',thickness_bottom='$thickness_bottom',thickness_side='$thickness_side',total_weight='$total_weight' WHERE furnace_id ='$furnace_id'";
                mysqli_query($conn, $sqlUpdate_furnace);


            }
            //edit or insert condition
            else{
            $sqlInsert = "INSERT INTO `furnace`(`furnace_id`, `service_type`,`service_id`,`visit_date`,`capacity`,`company_name`,`furnace_no`,`furnace_top`,`furnace_bottom`,`furnace_height`,`material_type`,`gld`,`fork_height`,`sharpness`,`tapping_temperature`,`power`,`panel_capacity`,`product_name`,`grey`,`batch_no`,`former_top`,`former_bottom`,`former_height`,`former_tapper`,`gld_dimension`,`remark`,`thickness_bottom`,`thickness_side`,`total_weight`)
                                           VALUES ('','$service_type','$service_id','$visit_date','$capacity','$company_name','$furnace_no','$furnace_top','$furnace_bottom','$furnace_height','$material_type','$gld','$fork_height','$sharpness','$tapping_temperature','$power','$panel_capacity','$product_name','$grey','$batch_no','$former_top','$former_bottom','$former_height','$former_tapper','$gld_dimension','$remark','$thickness_bottom','$thickness_side','$total_weight')";
            mysqli_query($conn, $sqlInsert);
            $ID=mysqli_insert_id($conn);
            if(strlen($ID)==1)
            {
                $ID='00'.$ID;

            }elseif(strlen($ID)==2)
            {
                $ID='0'.$ID;
            }
            $furnace_id="F".($ID);
            $sqlUpdate = "UPDATE furnace SET furnace_id = '$furnace_id' WHERE id ='$ID'";
            mysqli_query($conn, $sqlUpdate);

            }

            $totalSeconds = 0;
            $totalSecondsss=0;
            $totalQtyB = 0;
            //delete before insert
            $sqlDelete = "DELETE FROM `furnace_details` WHERE furnace_id='$furnace_id'";
            mysqli_query($conn, $sqlDelete);

            $totalForkSeconds = 0;
            $totalVibSeconds = 0;
            for ($pl = 0; $pl < $countPersonalLoans; $pl++) {
                $plValues = $personalLoanAr[$pl];
                $plValues = substr($plValues, 0, -1);
                $plValuesAr = explode("%", $plValues);
             //    print_r($plValuesAr);
                 $plValuesAr[2];
                 $plValuesAr[3];
                $totalQtyB += intval($plValuesAr[1]);

                $startTime_fork = $plValuesAr[2];
                $endTime_fork = $plValuesAr[3];


                $loginTime_fork = strtotime($endTime_fork);
                $checkTime_fork =  strtotime($startTime_fork);
                $diff_fork = $checkTime_fork - $loginTime_fork;
                $fork_diff =  gmdate("H:i", abs($diff_fork));

                $totalForkSeconds+=$diff_fork;

                $startTime_vibe = $plValuesAr[4];
                $endTime_vibe = $plValuesAr[5];


                $loginTime_vibe = strtotime($endTime_vibe);
                $checkTime_vibe =  strtotime($startTime_vibe);
                $diff_vibe = $checkTime_vibe - $loginTime_vibe;
                $vibe_diff =  gmdate("H:i", abs($diff_vibe));
                $totalVibSeconds+=$diff_vibe;

                $sqlInsertPLoan = "INSERT INTO `furnace_details`(`furnace_id`,`vibrator`, `pressure`, `qty`,`fork_start_time`,`fork_close_time`,`fork_total_time`,`vibrator_start_time`,`vibrator_close_time`,`vibrator_total_time`) 
                                           VALUES ('$furnace_id','bottom','$plValuesAr[0]','$plValuesAr[1]','$plValuesAr[2]','$plValuesAr[3]','$fork_diff','$plValuesAr[4]','$plValuesAr[5]','$vibe_diff')";
                mysqli_query($conn, $sqlInsertPLoan);
            }

            $totalHours = floor($totalForkSeconds / 3600);
            $totalMinutes = floor(($totalForkSeconds % 3600) / 60);
            // Format the total time
            $totalTime = sprintf('%02d:%02d', abs($totalHours), abs($totalMinutes));
            $totalHoursb = floor($totalVibSeconds / 3600);
            $totalMinutesb = floor(($totalVibSeconds % 3600) / 60);
            // Format the total time
            $totalTimess = sprintf('%02d:%02d', $totalHoursb, $totalMinutesb);
            $sqlUpdates1  = "INSERT INTO `furnace_time`( `furnace_id`, `vibrator`, `allfork_total_time`, `allvibrator_total_time`,`totalQty`)
                                VALUES ('$furnace_id','bottom','$totalTime','$totalTimess','$totalQtyB')";
            mysqli_query($conn, $sqlUpdates1);



            $totalSecondsfs = 0;
            $totalSecondsvs = 0;
            $totalQtyS = 0;
            $totalForkSecondsSide = 0;
            $totalVibSecondsSide = 0;
            for ($hl = 0; $hl < $countHomeLoans; $hl++) {
                $hlValues = $homeLoanAr[$hl];
                $hlValues = substr($hlValues, 0, -1);
                $hlValuesAr = explode("%", $hlValues);
                $totalQtyS += intval($hlValuesAr[1]);
                // Convert string to DateTime objects FURNACE
                $startTime_forkS = $hlValuesAr[2];
                $endTime_forkS = $hlValuesAr[3];


                $loginTime_forkS = strtotime($endTime_forkS);
                $checkTime_forkS =  strtotime($startTime_forkS);
                $diff_forkS= $checkTime_forkS - $loginTime_forkS;
                $fork_diffS =  gmdate("H:i", abs($diff_forkS));

                $totalForkSecondsSide+=$diff_forkS;

                $startTime_vibeS = $hlValuesAr[4];
                $endTime_vibeS = $hlValuesAr[5];


                $loginTime_vibeS = strtotime($endTime_vibeS);
                $checkTime_vibeS =  strtotime($startTime_vibeS);
                $diff_vibeS = $checkTime_vibeS - $loginTime_vibeS;
                $vibe_diffS =  gmdate("H:i", abs($diff_vibeS));
                $totalVibSecondsSide+=$diff_vibeS;

                $sqlInsertHLoan = "INSERT INTO `furnace_details`(`furnace_id`,`vibrator`, `pressure`, `qty`,`fork_start_time`,`fork_close_time`,`fork_total_time`,`vibrator_start_time`,`vibrator_close_time`,`vibrator_total_time`)
                                           VALUES ('$furnace_id','side','$hlValuesAr[0]','$hlValuesAr[1]','$hlValuesAr[2]','$hlValuesAr[3]','$fork_diffS','$hlValuesAr[4]','$hlValuesAr[5]','$vibe_diffS')";
                mysqli_query($conn, $sqlInsertHLoan);
            }
            $totalHoursfs = floor($totalForkSecondsSide / 3600);
            $totalMinutesfs = floor(($totalForkSecondsSide % 3600) / 60);
            // Format the total time
            $totalTimefs = sprintf('%02d:%02d', $totalHoursfs, $totalMinutesfs);

            $totalHoursvs = floor($totalVibSecondsSide / 3600);
            $totalMinutesvs = floor(($totalVibSecondsSide % 3600) / 60);
            // Format the total time
            $totalTimevs = sprintf('%02d:%02d', $totalHoursvs, $totalMinutesvs);


            $sqlUpdates2 = "INSERT INTO `furnace_time`( `furnace_id`, `vibrator`, `allfork_total_time`, `allvibrator_total_time`,`totalQty`)
                                VALUES ('$furnace_id','side','$totalTimefs','$totalTimevs','$totalQtyS')";
            mysqli_query($conn, $sqlUpdates2);

            $bsTotalqty = $totalQtyB + $totalQtyS ;
            $sqlUpdateZ = "UPDATE furnace SET total_weight = '$bsTotalqty' WHERE furnace_id ='$furnace_id'";
            mysqli_query($conn, $sqlUpdateZ);

        }

        //wet lining
        if($service_type == 'Laddle Wet Lining') {
            if($service_add ==1){
                $sqlUpdate_wet = "UPDATE wet_lining SET service_type = '$service_type',service_id = '$service_id',visit_datewet = '$visit_datewet',venuewet = '$venuewet',customer_wet = '$customer_wet',laddle_nowet = '$laddle_nowet',capacitywet = '$capacitywet',laddle_diawet = '$laddle_diawet',laddle_heightwet = '$laddle_heightwet',former_diawet = '$former_diawet',former_heightwet = '$former_heightwet',product_usedwet = '$product_usedwet',batch_nowet = '$batch_nowet',liquidwet = '$liquidwet',waterwet = '$waterwet',material_typewet='$material_typewet',pendingwet='$pendingwet',wastagewet='$wastagewet',lining_end_timewet='$lining_end_timewet',remarkwet='$remarkwet',thickness_bottomwet='$thickness_bottomwet',thickness_sidewet='$thickness_sidewet',total_weightwet='$total_weightwet' WHERE wet_lining_id ='$wet_lining_id'";
                mysqli_query($conn, $sqlUpdate_wet);
            }
            else{

                $sqlInsert = "INSERT INTO `wet_lining`(`wet_lining_id`, `service_type`,`service_id`,`visit_datewet`,`venuewet`,`customer_wet`,`laddle_nowet`,`capacitywet`,`laddle_diawet`,`laddle_heightwet`,`former_diawet`,`former_heightwet`,`product_usedwet`,`batch_nowet`,`liquidwet`,`waterwet`,`material_typewet`,`pendingwet`,`wastagewet`,`lining_end_timewet`,`remarkwet`,`thickness_bottomwet`,`thickness_sidewet`,`total_weightwet`)
                                           VALUES ('','$service_type','$service_id','$visit_datewet','$venuewet','$customer_wet','$laddle_nowet','$capacitywet','$laddle_diawet','$laddle_heightwet','$former_diawet','$former_heightwet','$product_usedwet','$batch_nowet','$liquidwet','$waterwet','$material_typewet','$pendingwet','$wastagewet','$lining_end_timewet','$remarkwet','$thickness_bottomwet','$thickness_sidewet','$total_weightwet')";
                mysqli_query($conn, $sqlInsert);
                $ID=mysqli_insert_id($conn);
                if(strlen($ID)==1)
                {
                    $ID='00'.$ID;

                }elseif(strlen($ID)==2)
                {
                    $ID='0'.$ID;
                }
                $wet_lining_id="W".($ID);
                $sqlUpdate = "UPDATE wet_lining SET wet_lining_id = '$wet_lining_id' WHERE id ='$ID'";
                mysqli_query($conn, $sqlUpdate);

            }
            //delete before insert
            $sqlDeleteWet = "DELETE FROM `wet_lining_details` WHERE wet_lining_id='$wet_lining_id'";
            mysqli_query($conn, $sqlDeleteWet);
            $totalSeconds = 0;
            $totalSecondsss=0;
            $totalQtyB = 0;
            $totalForkSeconds = 0;
            $totalVibSeconds = 0;
            $t1=0;
            for ($wb = 0; $wb < $countwetBs; $wb++) {
                $wbValues = $wetBAr[$wb];
                $wbValues = substr($wbValues, 0, -1);
                $wbValuesAr = explode("%", $wbValues);

                $totalQtyB += intval($wbValuesAr[0]);
                // Convert string to DateTime objects DRY

                $startTime_fork = $wbValuesAr[1];
                $endTime_fork = $wbValuesAr[2];


                $loginTime_fork = strtotime($endTime_fork);
                $checkTime_fork =  strtotime($startTime_fork);
                $diff_fork = $checkTime_fork - $loginTime_fork;
                $fork_diff =  gmdate("H:i", abs($diff_fork));

                $totalForkSeconds+=$diff_fork;

                $startTime_vibe = $plValuesAr[3];
                $endTime_vibe = $plValuesAr[4];


                $loginTime_vibe = strtotime($endTime_vibe);
                $checkTime_vibe =  strtotime($startTime_vibe);
                $diff_vibe = $checkTime_vibe - $loginTime_vibe;
                $vibe_diff =  gmdate("H:i", abs($diff_vibe));
                $totalVibSeconds+=$diff_vibe;

                //t1 + t2
                $t1+=$diff_fork;
                $t1+=$diff_vibe;
                $t1t2S = floor($t1 / 3600);
                $t1t2M = floor(($t1 % 3600) / 60);
                // Format the total time
                $totalT1T2 = sprintf('%02d:%02d', $t1t2S, $t1t2M);

                $sqlInsertwb = "INSERT INTO `wet_lining_details`(`wet_lining_id`,`layer`, `qty`,`dry_start_time`,`dry_close_time`,`dry_total_time`,`liquid_start_time`,`liquid_close_time`,`liquid_total_time`,`total_weight`,`dry&liquid_total_time`,`water_usage`) 
                                           VALUES ('$wet_lining_id','bottom','$wbValuesAr[0]','$wbValuesAr[1]','$wbValuesAr[2]','$fork_diff','$wbValuesAr[3]','$wbValuesAr[4]','$vibe_diff','','$totalT1T2','$wbValuesAr[5]')";
                mysqli_query($conn, $sqlInsertwb);
            }
            $totalHours = floor($totalForkSeconds / 3600);
            $totalMinutes = floor(($totalForkSeconds % 3600) / 60);
            // Format the total time
            $totalTime = sprintf('%02d:%02d', $totalHours, $totalMinutes);

            $totalHoursb = floor($totalVibSeconds / 3600);
            $totalMinutesb = floor(($totalVibSeconds % 3600) / 60);
            // Format the total time
            $totalTimess = sprintf('%02d:%02d', $totalHoursb, $totalMinutesb);
            $sqlUpdates1  = "INSERT INTO `wet_time`( `wet_lining_id`, `vibrator`, `allfork_total_time`, `allvibrator_total_time`,`totalQty`)
                                VALUES ('$wet_lining_id','bottom','$totalTime','$totalTimess','$totalQtyB')";
            mysqli_query($conn, $sqlUpdates1);

            $totalSecondsfs = 0;
            $totalSecondsvs = 0;
            $totalQtyS = 0;
            $totalForkSecondsSide = 0;
            $totalVibSecondsSide = 0;
            $t2=0;
            for ($ws = 0; $ws < $countwetSs; $ws++) {
                $wsValues = $wetSAr[$ws];
                $wsValues = substr($wsValues, 0, -1);
                $wsValuesAr = explode("%", $wsValues);

                $totalQtyS += intval($wsValuesAr[0]);

                // Convert string to DateTime objects DRY
                $startTime_forkS = $wsValuesAr[1];
                $endTime_forkS = $wsValuesAr[2];


                $loginTime_forkS = strtotime($endTime_forkS);
                $checkTime_forkS =  strtotime($startTime_forkS);
                $diff_forkS= $checkTime_forkS - $loginTime_forkS;
                $fork_diffS =  gmdate("H:i", abs($diff_forkS));

                $totalForkSecondsSide+=$diff_forkS;

                $startTime_vibeS = $hlValuesAr[3];
                $endTime_vibeS = $hlValuesAr[4];


                $loginTime_vibeS = strtotime($endTime_vibeS);
                $checkTime_vibeS =  strtotime($startTime_vibeS);
                $diff_vibeS = $checkTime_vibeS - $loginTime_vibeS;
                $vibe_diffS =  gmdate("H:i", abs($diff_vibeS));
                $totalVibSecondsSide+=$diff_vibeS;

                //t1 + t2
                $t2+=$diff_forkS;
                $t2+=$diff_vibeS;
                $t1t2h = floor($t2 / 3600);
                $t1t2m = floor(($t2 % 3600) / 60);
                // Format the total time
                $totalT1T2S = sprintf('%02d:%02d', $t1t2h, $t1t2m);
                // SQL Injection Prevention
//                $wet_lining_id = mysqli_real_escape_string($conn, $wet_lining_id);
                $sqlInsertws = "INSERT INTO `wet_lining_details`(`wet_lining_id`,`layer`, `qty`,`dry_start_time`,`dry_close_time`,`dry_total_time`,`liquid_start_time`,`liquid_close_time`,`liquid_total_time`,`total_weight`,`dry&liquid_total_time`,`water_usage`) 
                    VALUES ('$wet_lining_id','side','$wsValuesAr[0]','$wsValuesAr[1]','$wsValuesAr[2]','$fork_diffS','$wsValuesAr[3]','$wsValuesAr[4]','$vibe_diffS','','$totalT1T2S','$wsValuesAr[5]')";

                mysqli_query($conn, $sqlInsertws);
            }

            $totalHoursfs = floor($totalForkSecondsSide / 3600);
            $totalMinutesfs = floor(($totalForkSecondsSide % 3600) / 60);
            // Format the total time
            $totalTimefs = sprintf('%02d:%02d', $totalHoursfs, $totalMinutesfs);

            $totalHoursvs = floor($totalVibSecondsSide / 3600);
            $totalMinutesvs = floor(($totalVibSecondsSide % 3600) / 60);
            // Format the total time
            $totalTimevs = sprintf('%02d:%02d', $totalHoursvs, $totalMinutesvs);
            $sqlUpdates2 = "INSERT INTO `wet_time`( `wet_lining_id`, `vibrator`, `allfork_total_time`, `allvibrator_total_time`,`totalQty`)
                                VALUES ('$wet_lining_id','side','$totalTimefs','$totalTimevs','$totalQtyS')";
            mysqli_query($conn, $sqlUpdates2);

            $bsTotalqty = $totalQtyB + $totalQtyS ;
            $sqlUpdateZ = "UPDATE wet_lining SET total_weightwet = '$bsTotalqty' WHERE wet_lining_id ='$wet_lining_id'";
            mysqli_query($conn, $sqlUpdateZ);
        }

        //dry lining
        if($service_type == 'Laddle Dry Lining') {
            if($service_add ==1){
                $sqlUpdate_dry = "UPDATE dry_lining SET service_type = '$service_type',service_id = '$service_id',customer_dry = '$customer_dry',visit_datedry = '$visit_datedry',Venuedry = '$Venuedry',laddle_nodry = '$laddle_nodry',capacitydry = '$capacitydry',laddle_diadry = '$laddle_diadry',laddle_heightdry = '$laddle_heightdry',former_diadry = '$former_diadry',former_heightdry = '$former_heightdry',product_useddry = '$product_useddry',batch_nodry = '$batch_nodry',material_typedry = '$material_typedry',lining_start_timedry = '$lining_start_timedry',former_remove_timedry='$former_remove_timedry',firing_timedry='$firing_timedry',lining_end_timedry='$lining_end_timedry',wastagedry='$wastagedry',typedry='$typedry',remarkdry='$remarkdry',thickness_bottomdry='$thickness_bottomdry',thickness_sidedry='$thickness_sidedry',total_weightdry='$total_weightdry' WHERE dry_lining_id ='$dry_lining_id'";
                mysqli_query($conn, $sqlUpdate_dry);
            }
            else {
                $sqlInsert = "INSERT INTO `dry_lining`(`dry_lining_id`, `service_type`,`service_id`,`customer_dry`,`visit_datedry`,`Venuedry`,`laddle_nodry`,`capacitydry`,`laddle_diadry`,`laddle_heightdry`,`former_diadry`,`former_heightdry`,`product_useddry`,`batch_nodry`,`material_typedry`,`lining_start_timedry`,`former_remove_timedry`,`firing_timedry`,`lining_end_timedry`,`wastagedry`,`typedry`,`remarkdry`,`thickness_bottomdry`,`thickness_sidedry`,`total_weightdry`)
                                           VALUES ('','$service_type','$service_id','$customer_dry','$visit_datedry','$Venuedry','$laddle_nodry','$capacitydry','$laddle_diadry','$laddle_heightdry','$former_diadry','$former_heightdry','$product_useddry','$batch_nodry','$material_typedry','$lining_start_timedry','$former_remove_timedry','$firing_timedry','$lining_end_timedry','$wastagedry','$typedry','$remarkdry','$thickness_bottomdry','$thickness_sidedry','$total_weightdry')";
                mysqli_query($conn, $sqlInsert);
                $ID = mysqli_insert_id($conn);
                if (strlen($ID) == 1) {
                    $ID = '00' . $ID;
                } elseif (strlen($ID) == 2) {
                    $ID = '0' . $ID;
                }
                $dry_lining_id = "D" . ($ID);
                $sqlUpdate = "UPDATE dry_lining SET dry_lining_id = '$dry_lining_id' WHERE id ='$ID'";
                mysqli_query($conn, $sqlUpdate);
            }
            //delete before insert
            $sqlDeleteDry = "DELETE FROM `dry_lining_details` WHERE dry_lining_id='$dry_lining_id'";
            mysqli_query($conn, $sqlDeleteDry);
            $totalSeconds = 0;
            $totalSecondsss=0;
            $totalQtyB = 0;
            $totalForkSeconds = 0;
            for ($db = 0; $db < $countdryBs; $db++) {
                $dbValues = $dryBAr[$db];
                $dbValues = substr($dbValues, 0, -1);
                $dbValuesAr = explode("%", $dbValues);

                $totalQtyB += intval($dbValuesAr[0]);
                // Convert string to DateTime objects DRY
                $startTime_fork = $dbValuesAr[1];
                $endTime_fork = $dbValuesAr[2];


                $loginTime_fork = strtotime($endTime_fork);
                $checkTime_fork =  strtotime($startTime_fork);
                $diff_fork= $checkTime_fork - $loginTime_fork;
                $fork_diff =  gmdate("H:i", abs($diff_fork));

                $totalForkSeconds+=$diff_fork;

                $sqlInsertdb = "INSERT INTO `dry_lining_details`(`dry_lining_id`,`layer`, `qty`,`fork_start_time`,`fork_close_time`,`fork_total_time`,`total_weight`,`overall_total_time`,`overall_total_weight`) 
                                           VALUES ('$dry_lining_id','bottom','$dbValuesAr[0]','$dbValuesAr[1]','$dbValuesAr[2]','$fork_diff','','','')";
                mysqli_query($conn, $sqlInsertdb);
            }
            $totalHours = floor($totalForkSeconds / 3600);
            $totalMinutes = floor(($totalForkSeconds % 3600) / 60);
            // Format the total time
            $totalTime = sprintf('%02d:%02d', $totalHours, $totalMinutes);
            $sqlUpdates1  = "INSERT INTO `dry_time`( `dry_lining_id`, `vibrator`, `allfork_total_time`,`totalQty`)
                                VALUES ('$dry_lining_id','bottom','$totalTime','$totalQtyB')";
            mysqli_query($conn, $sqlUpdates1);

            $totalSecondsfs = 0;
            $totalSecondsvs = 0;
            $totalQtyS = 0;
            $totalForkSecondsSide = 0;
            for ($ds = 0; $ds < $countdrySs; $ds++) {
                $dsValues = $drySAr[$ds];
                $dsValues = substr($dsValues, 0, -1);
                $dsValuesAr = explode("%", $dsValues);
                $totalQtyS += intval($dsValuesAr[0]);
                // Convert string to DateTime objects DRY
                $startTime_forkS = $dsValuesAr[1];
                $endTime_forkS = $dsValuesAr[2];


                $loginTime_forkS = strtotime($endTime_forkS);
                $checkTime_forkS =  strtotime($startTime_forkS);
                $diff_forkS= $checkTime_forkS - $loginTime_forkS;
                $fork_diffS =  gmdate("H:i", abs($diff_forkS));

                $totalForkSecondsSide+=$diff_forkS;


                $sqlInsertds = "INSERT INTO `dry_lining_details`(`dry_lining_id`,`layer`, `qty`,`fork_start_time`,`fork_close_time`,`fork_total_time`,`total_weight`,`overall_total_time`,`overall_total_weight`) 
                                           VALUES ('$dry_lining_id','side','$dsValuesAr[0]','$dsValuesAr[1]','$dsValuesAr[2]','$fork_diffS','','','')";
                mysqli_query($conn, $sqlInsertds);
            }
            $totalHoursfs = floor($totalForkSecondsSide / 3600);
            $totalMinutesfs = floor(($totalForkSecondsSide % 3600) / 60);
            // Format the total time
            $totalTimefs = sprintf('%02d:%02d', $totalHoursfs, $totalMinutesfs);

            $sqlUpdates2 = "INSERT INTO `dry_time`( `dry_lining_id`, `vibrator`, `allfork_total_time`,`totalQty`)
                                VALUES ('$dry_lining_id','side','$totalTimefs','$totalQtyS')";
            mysqli_query($conn, $sqlUpdates2);

            $bsTotalqty = $totalQtyB + $totalQtyS ;
            $sqlUpdateZ = "UPDATE dry_lining SET total_weightdry = '$bsTotalqty' WHERE dry_lining_id ='$dry_lining_id'";
            mysqli_query($conn, $sqlUpdateZ);
        }

        //Erosion
        if($service_type == 'Erosion Analysis') {
            if($service_add ==1){
                $sqlUpdate_Er = "UPDATE erosion SET service_type = '$service_type',service_id = '$service_id',customer_er = '$customer_er',dateer = '$dateer',material_typeer = '$material_typeer',locationer = '$locationer',ms_nameer = '$ms_nameer',ms_mobileer = '$ms_mobileer',mm_nameer = '$mm_nameer',monthly_productioner = '$monthly_productioner',temper = '$temper',powerer = '$powerer',capacityer = '$capacityer',sger = '$sger',greyer = '$greyer',batch_noer='$batch_noer',typeer='$typeer',
                                    materialer='$materialer',brickser='$brickser',competiterer='$competiterer',d1_c1='$d1_c1',d2_c2='$d2_c2',d3_c3='$d3_c3',h1_h2='$h1_h2',heat_gone='$heat_gone',Ad1_Ac1='$Ad1_Ac1',Ad2_Ac2='$Ad2_Ac2',Ad3_Ac3='$Ad3_Ac3',Ah1_h2='$Ah1_h2' WHERE erosion_id ='$erosion_id'";
                mysqli_query($conn, $sqlUpdate_Er);
            }
            else {
                $sqlInsert = "INSERT INTO `erosion`(`erosion_id`, `service_type`,`service_id`,`customer_er`,`dateer`,`material_typeer`,`locationer`,`ms_nameer`,`ms_mobileer`,`mm_nameer`,`mm_mobileer`,`monthly_productioner`,`temper`,`powerer`,`capacityer`,`sger`,`greyer`,`batch_noer`,`typeer`,`materialer`,`brickser`,`competiterer`,`d1_c1`,`d2_c2`,`d3_c3`,`h1_h2`,`heat_gone`,`Ad1_Ac1`,`Ad2_Ac2`,`Ad3_Ac3`,`Ah1_h2`)
                                           VALUES ('','$service_type','$service_id','$customer_er','$dateer','$material_typeer','$locationer','$ms_nameer','$ms_mobileer','$mm_nameer','$mm_mobileer','$monthly_productioner','$temper','$powerer','$capacityer','$sger','$greyer','$batch_noer','$typeer','$materialer','$brickser','$competiterer','$d1_c1','$d2_c2','$d3_c3','$h1_h2','$heat_gone','$Ad1_Ac1','$Ad2_Ac2','$Ad3_Ac3','$Ah1_h2')";
                mysqli_query($conn, $sqlInsert);
                $ID = mysqli_insert_id($conn);
                if (strlen($ID) == 1) {
                    $ID = '00' . $ID;

                } elseif (strlen($ID) == 2) {
                    $ID = '0' . $ID;
                }
                $erosion_id = "E" . ($ID);
                $sqlUpdate = "UPDATE erosion SET erosion_id = '$erosion_id' WHERE id ='$ID'";
                mysqli_query($conn, $sqlUpdate);
            }
            //delete before insert
            $sqlDeleteEr = "DELETE FROM `erosion_details` WHERE erosion_id='$erosion_id'";
            mysqli_query($conn, $sqlDeleteEr);
            for ($el = 0; $el < $counterLs; $el++) {
                $elValues = $erLAr[$el];
                $elValues = substr($elValues, 0, -1);
                $elValuesAr = explode("%", $elValues);
                $sqlInsertel = "INSERT INTO `erosion_details`(`erosion_id`,`erosion_type`, `lcapacity`,`heat_undergone`,`no_of_patching`,`erosion_factor`,`material_consumption`,`dimension_after_patching`) 
                                           VALUES ('$erosion_id','Laddle','$elValuesAr[0]','$elValuesAr[1]','$elValuesAr[2]','$elValuesAr[3]','$elValuesAr[4]','$elValuesAr[5]')";
                mysqli_query($conn, $sqlInsertel);
            }

            for ($ef = 0; $ef < $counterFs; $ef++) {
                $efValues = $erFAr[$ef];
                $efValues = substr($efValues, 0, -1);
                $efValuesAr = explode("%", $efValues);
                $sqlInsertef = "INSERT INTO `erosion_details`(`erosion_id`,`erosion_type`, `lcapacity`,`heat_undergone`,`no_of_patching`,`erosion_factor`,`material_consumption`,`dimension_after_patching`) 
                                           VALUES ('$erosion_id','Furnace','$efValuesAr[0]','$efValuesAr[1]','$efValuesAr[2]','$efValuesAr[3]','$efValuesAr[4]','$efValuesAr[5]')";
                mysqli_query($conn, $sqlInsertef);
            }
        }

        $role=$_COOKIE['role'];
        $staff_id=$_COOKIE['user_id'];
        $staff_name=$_COOKIE['user_name'];
        $info = urlencode("Service Details Added");
        $role = urlencode($role); // Assuming $id is a variable with the emp_id value
        $staff_id = urlencode($staff_id); // Assuming $id is a variable with the emp_id value
        $staff_name = urlencode($staff_name); // Assuming $id is a variable with the emp_id value
        $url = "https://erp.aecindia.net/includes/log_api.php?message=$info&role=$role&staff_id=$staff_id&staff_name=$staff_name";
        file_get_contents($url);


        //inserted successfully
        $json_array['status'] = "success";
        $json_array['msg'] = "Added successfully !!!";
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
