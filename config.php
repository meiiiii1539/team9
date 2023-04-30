
<!-- // // Create connection to Oracle
// // $conn = oci_connect("GROUP9","rooRbUXuxiJUS","/140.117.69.70:1521/ORCLPDB1");

// $dsn = "Driver={Oracle ODBC Driver};Dbq=/140.117.69.70:1521/ORCLPDB1;Uid=GROUP9;Pwd=rooRbUXuxiJUS;";
// $conn = odbc_connect($dsn, "", "");

// if (!$conn) {
//    $m = odbc_error();
//    echo $m['message'], "\n";
//    exit;
// }
// else {
//    print "Connected to Oracle!";
// }
// // Close the Oracle connection
// odbc_close()($conn); -->

<?php

// 資料庫連接資訊
$db_user = "GROUP9";
$db_password = "RbUXuxiJUS";
$db_service = "ORCLPDB1";

// 連接 Oracle 資料庫
$link = oci_connect($db_user, $db_password, $db_service,'AL32UTF8');

if (!$link) {
    $e = oci_error();
    trigger_error(htmlentities($e['message'], ENT_QUOTES), E_USER_ERROR);
}
elseif($link){

}

// 關閉資料庫連接
// oci_close($link);

?>

