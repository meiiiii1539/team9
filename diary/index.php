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
    if(!isset($_SESSION['userId'])) {
        exit;
    }
    $encode = "AL32UTF8";
    $conn = oci_connect($db_user, $passwords, $oracal_db, $encode);
    if (!$conn) {
        $e = oci_error();
        trigger_error(htmlentities($e, ENT_QUOTES), E_USER_ERROR);
    }
    $sql_string = "SELECT * FROM (SELECT * FROM diary NATURAL JOIN users where roomid = ".$_SESSION['roomnum'].") ud LEFT OUTER JOIN diaryphoto p ON ud.time = p.time and ud.roomid = p.roomid order by p.time DESC";
    $query = oci_parse($conn, $sql_string);
    oci_execute($query);
    $sql_get_self = "select photo from users where uids = ".$_SESSION['userId'];
    $sql = oci_parse($conn, $sql_get_self);
    oci_execute($sql);
?>
<!DOCTYPE html>
<html>
    <head>
        <title>Project</title>
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-F3w7mX95PdgyTmZZMECAngseQB83DfGTowi0iMjiWaeVhAn4FJkqJByhZMI3AhiU" crossorigin="anonymous">

        <link rel="stylesheet" href="css/index.css" type="text/css"/>
        <link href="../../navbar.css" rel="stylesheet">
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>

        <script src="js/autosize-master/dist/autosize.min.js"></script>
        <script src="js/index.js"></script>
        
        
    </head> 
    <body>
        <main>
            <!-- nav -->
            <nav class="navbar navbar-expand-lg navbar-light fixed-top" id="bg_color">
                <a class="navbar-brand" href="../../mainpage_anni/mainpage.php">BE WITH U ʕ•̫͡•ʔ❤ʕ•̫͡•ʔ</a>
                <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNavDropdown" aria-controls="navbarNavDropdown" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarNavDropdown">
                    <ul class="navbar-nav">
                        <li class="nav-item">
                            <a class="nav-link" href="../chatroom/php/index.php">聊天室</a>
                        </li>
                        <!-- <li class="nav-item">
                            <a class="nav-link" href="../diary/index.php">日記本</a>
                        </li> -->
                        <li class="nav-item">
                            <a class="nav-link" href="../photo_room/photo_book.php">相簿</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="../mainpage_anni/mainpage.php#sec2">紀念日</a>
                        </li>
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" href="#" id="navbarDropdownMenuLink" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                其他
                            </a>
                            <div class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">
                                <a class="dropdown-item" href="../update/personal.php">個人資料設定</a>
                                <a class="dropdown-item" href="../../login_register/login.php">登出</a>
                            </div>
                        </li>
                    </ul>
                </div>
            </nav>
            <div class="postBox">
                <textarea placeholder="在想些什麼？" class="postArea"></textarea> <br>
                <div class="controlPanel">
                    <label for="file-input">
                        <div width="24px" height="24px" class="add_img_button"></div>
                    </label>
                    <input id="file-input" type="file" accept="image/*"  style="display:none;"/>
                    <div class="sendbutton">發布</div>
                </div>
                <p id="photo_path" class="none_display"></p>
            </div>
            <?php
                while(($row = oci_fetch_array($query, OCI_BOTH)) != false) {
                    $user_name = $row['NAME'];
                    $content = $row['CONTENT'];
                    $selfie = $row['PHOTO'];
                    $display_content = str_replace("\n", "<br>", $content);
                    if(isset($row['DIARYPHOTO'])) {
                        $photo_path = $row['DIARYPHOTO']; 
                    }
                    else {
                        $photo_path = null;
                    }
                    $post_time = $row['TIME'];
                    $user_self = $row['PHOTO'];
            ?>
                <div class="postBox">
                    <div class="postPanel">
                        <img src=<?= $user_self?> width="45px" height="45px" class="self">
                        <div class="postContent">
                            <h3><?= $user_name?></h3>
                            <p class="timestamp"><?= $post_time?></p>
                            <p class="post_content"><?= $display_content?><br></p>
                            <textarea class="edit_area"><?= $content?></textarea><br>
                            <?php
                                if($photo_path != null) {
                            ?>
                                    <img class="post_pic" src= <?= $photo_path?> >
                            <?php
                                }
                            ?>
                            
                        </div>
                    </div>
                    <div class="editbutton editmode">編輯</div>
                </div>
            <?php
                }
            ?>
        </main>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-/bQdsTh/da6pkI1MST/rWKFNjaCP5gBSY4sEBT38Q/9RBh9AH40zEOg7Hlq2THRZ" crossorigin="anonymous"></script>
    </body>
</html>
<?php
    
    oci_close($conn);
?>