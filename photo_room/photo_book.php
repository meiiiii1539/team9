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
    $sql_string = "SELECT a.name, MIN(p.albumphoto) cover FROM album a left outer join albumphoto p ON a.roomid = p.roomid AND a.name = p.name where a.roomid = ".$_SESSION['roomnum']." GROUP BY(a.name)";
    $sql_string2 = "SELECT a.name, COUNT(p.albumphoto) num FROM album a left outer join albumphoto p ON a.roomid = p.roomid AND a.name = p.name where a.roomid = ".$_SESSION['roomnum']." GROUP BY(a.name)";
    $string = "SELECT * FROM(".$sql_string.") r1 NATURAL JOIN (".$sql_string2.") r2";
    $query = oci_parse($conn, $string);
    oci_execute($query);
?>
<!DOCTYPE html>
<html>
    <head>
        <title>相簿</title>
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-F3w7mX95PdgyTmZZMECAngseQB83DfGTowi0iMjiWaeVhAn4FJkqJByhZMI3AhiU" crossorigin="anonymous">
        <link rel="stylesheet" href="css/photo_book.css" type="text/css"/>
        <link href="../../navbar.css" rel="stylesheet">
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
        <script src="js/photo_book.js"></script>

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
                    <a class="nav-link" href="../../chatroom/php/index.php">聊天室</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="../../diary/index.php">日記本</a>
                </li>
                <!-- <li class="nav-item">
                    <a class="nav-link" href="../../photo_room/photo_book.php">相簿</a>
                </li> -->
                <li class="nav-item">
                    <a class="nav-link" href="../../mainpage_anni/mainpage.php#sec2">紀念日</a>
                </li>
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" id="navbarDropdownMenuLink" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        其他
                    </a>
                    <div class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">
                        <a class="dropdown-item" href="../../update/personal.php">個人資料設定</a>
                        <a class="dropdown-item" href="../../login_register/login.php">登出</a>
                    </div>
                </li>
            </ul>
        </div>
    </nav>
            <div class="top_panel">
                <h2>相簿</h2>
                <div class="modbutton butt">編輯</div>
            </div>
            <div class="flex_box">
                <div class="photo_describe_container">
                    <div class="photo_block ">
                        <div class="add_photo">+</div>
                    </div>
                    <div class="describe">
                        <p>新增相簿</p>
                    </div>
                </div>
                <?php 
                    while(($row = oci_fetch_array($query, OCI_BOTH)) != false) {
                        $album_name = $row['NAME'];
                        if(isset($row['COVER'])) {
                            $album_cover = $row['COVER'];
                        }
                        else {
                            $album_cover = null;
                        }
                        
                        $albun_pic_num = $row['NUM'];
                ?>
                <div class="photo_describe_container">
                    <div class="photo_block ">
                        <div class="Photo" style="background-image: url(../<?= $album_cover?>)"></div>
                    </div>
                    <div class="describe">
                        <p class="album_name"><?= $album_name?></p>
                        <p class="img_num"><?= $albun_pic_num?>張照片</p>
                    </div>
                </div>
                <?php
                    }
                ?>
            </div>
        </main>
        <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.10.1/dist/umd/popper.min.js" integrity="sha384-W8fXfP3gkOKtndU4JGtKDvXbO53Wy8SZCQHczT5FMiiqmQfUpWbYdTil/SxwZgAN" crossorigin="anonymous"></script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.1/dist/js/bootstrap.min.js" integrity="sha384-skAcpIdS7UcVUC05LJ9Dxay8AXcDYfBJqt1CJ85S/CFujBsIzCIv+l9liuYLaMQ/" crossorigin="anonymous"></script></body>

    </body>
</html>

<?php
    
    oci_close($conn);
?>