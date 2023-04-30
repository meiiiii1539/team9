<?php
    error_reporting(E_ALL);
    ini_set('display_errors', 1);
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
    $album_name = $_GET['album'];
    $sql_string = "SELECT albumphoto FROM albumphoto WHERE roomid = ".$_SESSION['roomnum']." AND name = '".$album_name."'";
    $sql = oci_parse($conn, $sql_string);
    oci_execute($sql);
?>
<!DOCTYPE html>
<html>
    <head>
        <title><?=$_GET['album']?></title>
        <link rel="stylesheet" href="css/photo_book.css" type="text/css"/>
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
        <script src="js/inside_album.js"></script>
    </head>
    <body>
        <main class="demo_block">
            <div class="top_panel">
                <h2><?=$_GET['album']?></h2>
                <div class="modbutton butt">編輯</div>
            </div>
            <div class="flex_box">
                <div class="photo_describe_container">
                    <div class="photo_block ">
                        <label for="auto_add_pic">
                            <div class="add_photo">+</div>
                        </label>
                        <input id="auto_add_pic" type="file" accept="image/*"  style="display:none;"/>
                    </div>
                    <div class="describe">
                        <p>新增照片</p>
                    </div>
                </div>

                <?php
                    while(($row = oci_fetch_array($sql, OCI_BOTH)) != false) {
                        $album_photo = "../".$row['ALBUMPHOTO'];
                ?>
                        <div class="photo_describe_container">
                            <div class="photo_block ">
                                <p class="photo_path" style="display:none;"><?=$row['ALBUMPHOTO']?></p>
                                <div class="Photo" style="background-image: url(<?=$album_photo?>)"></div>
                            </div>
                        </div>
                <?php
                    }
                ?>
            </div>
        </main>
    </body>
</html>

<?php
    
    oci_close($conn);
?>