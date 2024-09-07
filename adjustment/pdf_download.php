<?php Include("../includes/connection.php");

error_reporting(0);
date_default_timezone_set("Asia/kolkata");
$a_id= $_GET['a_id'];
$f_date = $_GET['f_date'];
$t_date = $_GET['t_date'];
$f_reason = $_GET['reason'];

if($f_date == ''){
    $f_date = date('Y-m-01');
}
if($t_date == ''){
    $t_date = date('Y-m-d');
}
$from_date = date('Y-m-d 00:00:00',strtotime($f_date));
$to_date = date('Y-m-d 23:59:59',strtotime($t_date));

if($a_id != ""){
    $a_idSql = " AND adjustment_id LIKE '%" . $a_id . "%'";

}
else{
    $a_idSql ="";
}

if($s_id != ""){
    $s_idSql= " AND supplier = '".$s_id."'";

}
else{
    $s_idSql ="";
}

if ($f_reason == "Others"){
    $reasonSql= " AND reason = ''";
}
elseif($f_reason != ""){
    $reasonSql= " AND reason = '".$f_reason."'";
}
else{
    $reasonSql ="";
}
if($page=='') {
    $page=1;
}

$pageSql= $page-1;
$start=$pageSql*10;
$end = $start;

if($pageSql == 0) {
    $end = 10;
}
$added_by = $_COOKIE['user_id'];
if($_COOKIE['role'] == 'Super Admin'){
    $addedBy = "";
}
else{
    $addedBy = "AND added_by='$added_by'";
}

?>

<html>
<head>
    <title>PDF</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.1/css/bootstrap-grid.min.css"/>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Great+Vibes&display=swap" rel="stylesheet">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Kanit&family=Yellowtail&family=Yesteryear&display=swap" rel="stylesheet">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.1/js/bootstrap.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@24,400,0,0" />
    <style>
        table {
            font-family: arial, sans-serif;
            border-collapse: collapse;
            width: 100%;
        }

        td, th {
            border: 1px solid black;
            text-align: left;
            padding: 8px;
        }

        tr:nth-child(even) {
            background-color: #dddada;
        }
        #header{
            background-color: #1C6180;
            color: #fff;
        }
    </style>
</head>

<body id="example">
<!--<table id="example" class="table table-striped table-bordered" cellspacing="0" width="100%">-->
    <h2 style="text-align: center">Adjustment List</h2>

    <table id="example">
        <thead>
        <tr id="header">
            <th>Adjustment Id</th>
            <th>Adjustment Date</th>
            <th>Notes</th>
            <th>Reason</th>

        </tr>
        </thead>
        <?php
        if($a_id == "" && $f_reason == "") {
            $sql = "SELECT * FROM adjustment WHERE adjustment_date  BETWEEN '$from_date' AND '$to_date' ORDER BY id DESC LIMIT $start, 10";
        }
        else {
            $sql = "SELECT * FROM adjustment WHERE adjustment_date  BETWEEN '$from_date' AND '$to_date' $a_idSql$reasonSql ORDER BY id DESC LIMIT $start,10";
        }
        $result = mysqli_query($conn, $sql);
        if (mysqli_num_rows($result)>0) {
            $sNo = $start;
            while($row = mysqli_fetch_assoc($result)) {

                $sNo++;

                $adjustment_id =  $row['adjustment_id'];
                $reason =  $row['reason'];
                $other_reason =  $row['other_reason'];
                if($reason ==''){
                    $res=$other_reason;
                }
                else{
                    $res = $reason;
                }

                if($row['notes'] == ''){
                    $notes = 'NA';

                }
                else if($row['notes'] != ''){
                    $notes = $row['notes'];
                }
                if($res == ''){
                    $reasons = 'NA';

                }
                else if($res != ''){
                    $reasons = $res;
                }
                $date = $row['adjustment_date'];
                $adjusment_date = date('d-m-Y', strtotime($date));
                ?>

        <tr>
<!--            <td><strong>--><?php //echo $sNo;?><!--</strong></td>-->
            <td><?php echo $adjustment_id?></td>
            <td><?php echo $adjusment_date?></td>
            <td> <?php echo $notes?> </td>
            <td> <?php echo $reasons?> </td>

        </tr>
            <?php } }
        ?>

    </table>
<!--</table>-->


<script src="https://raw.githack.com/eKoopmans/html2pdf/master/dist/html2pdf.bundle.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.1/js/bootstrap.min.js"></script>
<script>
    //
    //     var element = document.getElementById('printPdf');
    //         html2pdf(element);

    let timesPdf = 0;
    if(timesPdf == 0){
        var element = document.getElementById('example');

        useCORS: true;
        var opt = {
            margin:       0.5,
            filename:     'Adjustment.pdf',
            image:        { type: 'jpeg', quality: 0.98 },
            html2canvas:  { scale: 2,useCORS: true },
            jsPDF:        { unit: 'in', format: 'a4', orientation: 'portrait' }
        };

        // New Promise-based usage:
        html2pdf().set(opt).from(element).save();
        //  Old monolithic-style usage:
        // html2pdf(element, opt);
        timesPdf+=1;
    }

    setTimeout(() => {
        window.location.href = "<?php echo $website; ?>/adjustment/all_adjustment.php";
    }, 800);


</script>

</body>
</html>