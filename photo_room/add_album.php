<?php
    function rmdir_recursive($dir) {
        if (is_dir($dir)) {
            $files = scandir($dir);
            foreach ($files as $file) {
                if ($file != '.' && $file != '..') {
                    if (is_dir("$dir/$file")) {
                        rmdir_recursive("$dir/$file");
                    } else {
                        unlink("$dir/$file");
                    }
                }
            }
            rmdir($dir);
        }
    }

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
    
    if(isset($_POST['album']) && isset($_POST['mode'])) {
        if($_POST['mode'] == "add") {
            $query_string = "INSERT INTO ALBUM (roomid, name, starttime) values (".$_SESSION['roomnum'].", '".$_POST['album']."', SYSTIMESTAMP)";
            $query = oci_parse($conn, $query_string);
            if(oci_execute($query)) {
                echo $_POST['album']."相簿建立完成";
                mkdir("/var/www/html/static/albums/".$_POST['album']);
            }
            else {
                echo $query_string;
            }
        }
        else if($_POST['mode'] == "delete"){
            $query_string = "DELETE FROM album WHERE roomid = ".$_SESSION['roomnum']." AND name = '".$_POST['album']."'";
            $query = oci_parse($conn, $query_string);
            if(oci_execute($query)) {
                echo "相簿刪除成功";
                if(is_dir("/var/www/html/static/albums/".$_POST['album'])) {
                    rmdir_recursive("/var/www/html/static/albums/".$_POST['album']);
                }
            }
        }
        else if($_POST['mode'] == "insert") {
            $base_path = "/var/www/html/";
            $clear_data_name = str_replace(" ", "", basename( $_FILES["img"]["name"]));
            $web_path = "static/albums/".$_POST['album']."/".$clear_data_name;
            $target_path = $base_path.$web_path;
            $query_string = "INSERT INTO albumphoto (roomid, name, albumphoto) VALUES (".$_SESSION['roomnum'].", '".$_POST['album']."', '".$web_path."')";
            @move_uploaded_file($_FILES['img']['tmp_name'], $target_path);
            $query = oci_parse($conn, $query_string);
            if(oci_execute($query)) {
                echo "成功添加照片";
            }
            else {
                echo $query_string;
                unlink($target_path);
            }
        }
        else if($_POST['mode'] == "remove") {
            $query_string = "DELETE FROM albumphoto WHERE roomid = ".$_SESSION['roomnum']." AND name = '".$_POST['album']."' AND albumphoto = '".$_POST['photo']."'";
            $query = oci_parse($conn, $query_string);
            echo  $query_string;
            if(oci_execute($query) && unlink($_POST['photo'])) {
                echo "成功刪除照片";
            }
        }
    }
    else {
        echo "error";
    }
    
    
?>
`
<?php
    oci_close($conn);
    
?>