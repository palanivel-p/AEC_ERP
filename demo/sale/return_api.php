<?php
Include("../includes/connection.php");

date_default_timezone_set("Asia/Kolkata");

if(isset($_POST['customer'])&&isset($_POST['sale_date'])) {


    $sale_id = $_POST['sale_id'];
    $product_name = clean($_POST['product_name']);
    $customer = clean($_POST['customer']);
    $parts = explode('_', $customer);
    $customer_id = $parts[0];
    $supply_place = $parts[1];
    $sale_date = clean($_POST['sale_date']);
//    $currency = clean($_POST['currency']);
    $unit_cost = clean($_POST['unit_cost']);
    $payment_terms = clean($_POST['payment_terms']);
    $discount = $_POST['discount'];
    $grand_total = $_POST['grand_total'];
    $payment_status = $_POST['payment_status'];
    $status = $_POST['status'];
    $notes = $_POST['notes'];
    $d_date = $_POST['d_date'];
    $e_way = $_POST['e_way'];
    $po_no = clean($_POST['po_no']);
    $po_date = clean($_POST['po_date']);
    $totaltax = $_POST['tax'];

    $add_id = $_POST['add_id'];
    $date = date('Y-m-d');
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

        $sqlPurchase = "SELECT * FROM `sale` WHERE `sale_id`='$sale_id'";
        $resPurchase = mysqli_query($conn, $sqlPurchase);
        $rowPurchase = mysqli_fetch_assoc($resPurchase);
        $Purchase_total_tax =  $rowPurchase['total_tax'];
        $Purchase_grand_total =  $rowPurchase['grand_total'];

        //purchase return update
        $purchaseU_tt = $Purchase_total_tax - $totaltax;
        $purchaseU_gt = $Purchase_grand_total - $grand_total;

        $sqlUpdateP = "UPDATE sale SET total_tax = '$purchaseU_tt',grand_total='$purchaseU_gt' WHERE sale_id ='$sale_id'";
        mysqli_query($conn, $sqlUpdateP);

        //return insert
//        $sqlInsert = "INSERT INTO `sale_return`(`return_id`,`sale_id`,`customer`,`sale_date`,`return_date`,`po_no`,`po_date`,`discount`,`grand_total`,`payment_status`,`notes`,`status`,`payment_terms`,`e_way`,`due_date`,`total_tax`)
//                                            VALUES ('','$sale_id','$supplier_id','$sale_date','$date','$po_no','$po_date','$discount','$grand_total','$payment_status','$notes','$status','$payment_terms','$e_way','$d_date','$totaltax')";
        $sqlInsert = "INSERT INTO `sale_return`(`return_id`,`sale_id`,`customer`,`sale_date`,`return_date`,`discount`,`grand_total`,`payment_status`,`notes`,`status`,`po_no`,`po_date`,`payment_terms`,`e_way`,`due_date`,`total_tax`,`added_by`) 
                                            VALUES ('','$sale_id','$customer_id','$sale_date','$date','$discount','$grand_total','$payment_status','$notes','$status','$po_no','$po_date','$payment_terms','$e_way','$d_date','$totaltax','$added_by')";

        mysqli_query($conn, $sqlInsert);

        $ID=mysqli_insert_id($conn);

        if(strlen($ID)==1)
        {
            $ID='00'.$ID;

        }elseif(strlen($ID)==2)
        {
            $ID='0'.$ID;
        }

        $return_id="SR".($ID);
        $invoice_no="AECSR".($ID);

        $sqlUpdate = "UPDATE sale_return SET return_id = '$return_id',invoice_no='$invoice_no' WHERE id ='$ID'";
        mysqli_query($conn, $sqlUpdate);



        $tableData = json_decode($_POST['tableData'], true);

        // Loop through the data and insert into the database
        foreach ($tableData as $rowData) {
            $productId = $conn->real_escape_string($rowData['productId']);
            $productName = $conn->real_escape_string($rowData['productName']);
            $netUnitCost = $conn->real_escape_string($rowData['netUnitCost']);
            $unit = $conn->real_escape_string($rowData['unit']);
            $stockUnit = $conn->real_escape_string($rowData['stockUnit']);
            $stockValue = $conn->real_escape_string($rowData['stockValue']);
            $persymbl = $conn->real_escape_string($rowData['persymbl']);
            $discount = $conn->real_escape_string($rowData['discount']);

//            $stock = $conn->real_escape_string($rowData['stock']);
//            $stk = explode('-', $stock);
//            $stock_value = $stk[0];
//            $stock_unit = $stk[1];

//            $unit_symbol = explode('>', $stock_unit);
//            $unit_sym = $unit_symbol[0];
//            $unit_bol = $unit_symbol[1];

            $quantity = $conn->real_escape_string($rowData['quantity']);
//            $quantity_r=  str_replace("+","",$quantity);
//            $quantity_r=  str_replace("-","",$quantity_r);

//            if($unit_bol === 'MT'){
//                $total_stock = (int)$quantity_r * 1000;
//                $stock_add = $stock_value + $total_stock;
//            }
//            else{
//                $total_stock = $stock_value;
//                $stock_add = (int)$quantity_r + $total_stock;
//            }
            $sqlProduct = "SELECT * FROM `product` WHERE `product_id`='$productId'";
            $resProduct = mysqli_query($conn, $sqlProduct);
            $rowProduct = mysqli_fetch_assoc($resProduct);
            $stock_qty =  $rowProduct['stock_qty'];


            if($unit === 'MT'){
                $total_stock = (int)$quantity * 1000;
                $stock_add = $stock_qty + (int)$total_stock;
//                $stock_add = $stock_value + $total_stock;
            }
            else{
                $total_stock = (int)$quantity * 1;
                $stock_add = $stock_qty + (int)$total_stock;
//                $stock_add = (int)$quantity_r + $total_stock;
            }

//            $discount = $conn->real_escape_string($rowData['discount']);
//            $discount_type = (strpos($discount, '%') !== false) ? 1 : 2;
//            $discount = str_replace('%', '', $discount);

            if($persymbl == '%'){
                $symbl = 1;
            }
            else if($persymbl == '₹'){
                $symbl = 2;
            }
            $discount_value = $conn->real_escape_string($rowData['discount_value']);
            $tax = $conn->real_escape_string($rowData['tax']);
            $tax_value = $conn->real_escape_string($rowData['tax_value']);
            $subtotal = $conn->real_escape_string($rowData['subtotal']);

            // Assuming you have a table named 'products'
                 $sqlInsersts = "INSERT INTO sale_return_details (sale_return_details_id,product_id,product_name,unit,unit_cost, stock,Stock_count ,discount,dis_symbl, tax, sub_total,qty,tax_value,discount_value,discount_type,return_date) 
                    VALUES ('','$productId','$productName','$unit', '$netUnitCost', '$stockValue','$stock_add', '$discount','$persymbl', '$tax', '$subtotal','$quantity','$tax_value','$discount_value','$symbl','$date')";

            mysqli_query($conn, $sqlInsersts);

            $ID = mysqli_insert_id($conn);

            if (strlen($ID) == 1) {
                $ID = '00' . $ID;

            } elseif (strlen($ID) == 2) {
                $ID = '0' . $ID;
            }

            $sale_return_details_id = "SRD" . ($ID);
            $sqlUpdates = "UPDATE sale_return_details SET sale_return_details_id = '$sale_return_details_id',sale_id='$sale_id',return_id= '$return_id' WHERE id ='$ID'";
            mysqli_query($conn, $sqlUpdates);

            $sqlStock = "SELECT * FROM `product` WHERE `product_id`='$productId'";
            $resStock = mysqli_query($conn, $sqlStock);
            $rowStock = mysqli_fetch_assoc($resStock);
            $total_stock =  $rowStock['stock_qty'];

            $sqlStockUpdate = "UPDATE product SET stock_qty = '$stock_add' WHERE product_id ='$productId'";
            mysqli_query($conn, $sqlStockUpdate);

            //update purchase details
            $sqlPurchaseD = "SELECT * FROM `sale_details` WHERE `sale_id`='$sale_id' AND `product_id`= '$productId'";
            $resPurchaseD = mysqli_query($conn, $sqlPurchaseD);
            $rowPurchaseD = mysqli_fetch_assoc($resPurchaseD);
            $PurchaseD_qty =  $rowPurchaseD['qty'];
            $PurchaseD_discount_value =  $rowPurchaseD['discount_value'];
            $PurchaseD_tax_value =  $rowPurchaseD['tax_value'];
            $PurchaseD_sub_total =  $rowPurchaseD['sub_total'];
            $purchaseD_product_id =  $rowPurchaseD['product_id'];

            //Sub purchase to return
            $return_qty = $PurchaseD_qty - $quantity;
            $return_discount_value = $PurchaseD_discount_value - $discount_value;
            $return_tax_value = $PurchaseD_tax_value - $tax_value;
            $return_sub_total = $PurchaseD_sub_total - $subtotal;

            $sqlUpdateReturnD = "UPDATE sale_details SET sub_total = '$return_sub_total',tax_value = '$return_tax_value',discount_value='$return_discount_value',qty='$return_qty' WHERE `sale_id`='$sale_id' AND `product_id`= '$productId'";
            mysqli_query($conn, $sqlUpdateReturnD);
        }



        $json_array['status'] = "success";
        $json_array['msg'] = " Returns Added successfully !!!";
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
