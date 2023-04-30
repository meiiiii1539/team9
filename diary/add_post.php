<?php
    date_default_timezone_set('Asia/Taipei');
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
        $current = time();
        $datetime = date('Y-m-d H:i:s', $current);
        $query_string = sprintf("INSERT INTO DIARY (roomid, uids, time, content) VALUES (%d, %d, TO_TIMESTAMP('%s', 'YYYY-MM-DD HH24:MI:SS'), '%s')", $_SESSION['roomnum'], $_SESSION['userId'], $datetime, $_POST['content']);
        $query = oci_parse($conn, $query_string);
        if(oci_execute($query)) {
            echo "成功新增文章\n";
        }
        else {
            echo $query_string;
        }
        if(isset($_FILES['img'])) {
            if(!file_exists($_FILES['img']['tmp_name'])) {
                echo $_FILES['img']['error'];
                exit;
            }
            $destination_path = "/var/www/html/static/upload_img/";
            $web_path = "../static/upload_img/". basename( $_FILES["img"]["name"]);
            $target_path = $destination_path . basename($_FILES["img"]["name"]);  
            $target_path = str_replace(" ", "", $target_path);
            $web_path = str_replace(" ", "", $web_path);
            $query_string2 = sprintf("INSERT INTO diaryphoto (roomid, time, diaryphoto) VALUES (%d, TO_TIMESTAMP('%s', 'YYYY-MM-DD HH24:MI:SS'), '%s')", $_SESSION['roomnum'], $datetime, $web_path);
            $query = oci_parse($conn, $query_string2);
            
            if(move_uploaded_file($_FILES['img']['tmp_name'], $target_path) && oci_execute($query)) {
                echo "新增檔案成功";
            }
            else {
                echo "檔案上傳失敗";
            }
        }
    }
    else {
        echo "無內容";
    }
    
    
?>

<?php
    oci_close($conn);
    
?>