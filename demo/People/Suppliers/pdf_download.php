<?php Include("../../includes/connection.php");

error_reporting(0);
$page= $_GET['page_no'];
if($page=='') {
    $page=1;
}
$pageSql= $page-1;
$start=$pageSql*10;
$end = $start;
if($pageSql == 0) {
    $end = 10;
}
$s_name= $_GET['s_name'];
$s_code= $_GET['s_code'];
$mobile= $_GET['mobile'];
$email= $_GET['email'];

if($s_name != ""){
//    $sNameSql= " AND supplier_name = '".$s_name."'";
    $sNameSql = " AND supplier_name LIKE '%" . $s_name . "%'";

}
else{
    $sNameSql ="";
}

if($s_code != ""){
//    $sCodeSql= " AND supplier_code = '".$s_code."'";
    $sCodeSql = " AND supplier_code LIKE '%" . $s_code . "%'";

}
else{
    $sCodeSql ="";
}

if($mobile != ""){
//    $mobileSql= " AND supplier_phone = '".$mobile."'";
    $mobileSql = " AND supplier_phone LIKE '%" . $mobile . "%'";

}
else{
    $mobileSql ="";
}

if($email != ""){
//    $emailSql= "AND supplier_email = '".$email."'";
    $emailSql = " AND supplier_email LIKE '%" . $email . "%'";

}
else {
    $emailSql = "";
}

//$sqldonerRecent = "SELECT * FROM doner_profile ORDER BY id DESC LIMIT 1";
//$resultdonerRecent = mysqli_query($conn, $sqldonerRecent);
//$rowdonerRecent = mysqli_fetch_assoc($resultdonerRecent);
//$lastTransAmount = $rowdonerRecent['doner_id'];

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
    <h2 style="text-align: center">Supplier List</h2>

    <table id="example">
        <thead>
        <tr id="header">
<!--            <th>Supplier Id</th>-->
            <th>Supplier Name</th>
            <th>Mobile</th>
            <th>Email</th>
            <th>Address</th>
        </tr>
        </thead>
        <?php
        if($email == "" && $mobile== "" && $s_name == "") {
            $sql = "SELECT * FROM supplier";
        }
        else {
            $sql = "SELECT * FROM supplier WHERE id > 0 $emailSql$mobileSql$sNameSql";
        }
        $result = mysqli_query($conn, $sql);
        if (mysqli_num_rows($result)>0) {
//            $sNo = $start;
            $sNo = 1;
            while($row = mysqli_fetch_assoc($result)) {

                $sNo++;
                ?>

        <tr>
<!--            <td><strong>--><?php //echo $sNo;?><!--</strong></td>-->
<!--            <td>--><?php //echo $row['supplier_id']?><!--</td>-->
            <td><?php echo $row['supplier_name']?></td>
            <td> <?php echo $row['supplier_phone']?> </td>
            <td> <?php echo $row['supplier_email']?> </td>
            <td> <?php echo $row['address1']?> </td>
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
            filename:     'Supplier.pdf',
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
        window.location.href = "<?php echo $website; ?>/People/Suppliers/";
    }, 800);


</script>

</body>
</html>