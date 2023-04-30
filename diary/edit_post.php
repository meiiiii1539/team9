<?php
    session_start();
    $db_user = "GROUP9";
    $passwords = "RbUXuxiJUS";
    $oracal_db = "
    (DESCRIPTION=
        (ADDRESS_LIST = 
            (ADDRESS = 
                (PROTOCOL = TCP)
                (HOST = 140.117.69.60)
                (PORT = 1521)
            )
        )
        (CONNECT_DATA=
            (SERVICE_NAME = orclpdb1)
        )
    )";
    $encode = "AL32UTF8";
    $conn = oci_connect($db_user, $passwords, $oracal_db, $encode);
    if (!$conn) {
        $e = oci_error();
        trigger_error(htmlentities($e, ENT_QUOTES), E_USER_ERROR);
    }
    
    if(isset($_POST['content'])) {
        $query_string = "";
        if($_POST['content'] == "") {
            $query_string = "DELETE FROM diary WHERE roomid = ".$_SESSION['roomnum']." AND time = '".$_POST['time']."'";
            if($_POST['pic'] != 'none') {
                if(file_exists($_POST['pic'])) {
                    unlink($_POST['pic']);
                }
            }
        }
        else {
            $query_string = "UPDATE diary SET content = '".$_POST['content']."' WHERE roomid = ".$_SESSION['roomnum']." AND time = '".$_POST['time']."'";
        }
        
        $query = oci_parse($conn, $query_string);
        if(!oci_execute($query)) {
            echo $query_string;
        }
        else {
            echo "修改成功";
        }
    }
    
?>

<?php
    oci_close($conn);
    
?>