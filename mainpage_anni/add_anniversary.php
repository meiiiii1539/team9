<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SpecialDay</title>
    <!-- ------------- -->
    <link rel="stylesheet" type="text/css" href="../login_register/login.css">
    <link rel="stylesheet" type="text/css" href="../footer.css">
    <link href="../navbar.css" rel="Stylesheet" type="text/css" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.12.9/dist/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
</head>
<body>
    <?php
        $username = "GROUP9";
        $password = "RbUXuxiJUS";
        $oracle_db = "
        (DESCRIPTION =
            (ADDRESS_LIST = 
                (ADDRESS =
                    (PROTOCOL = TCP)
                    (HOST = 140.117.69.60)
                    (PORT = 1521)
                )
            )
            (CONNECT_DATA = 
                (SERVICE_NAME = orclpdb1)
            )
        )";
        $encode = "AL32UTF8";
        $conn = oci_connect($username, $password, $oracle_db, $encode);

       //SESSION
        session_start();
        $userId = $_SESSION['userId'];
        $name = $_SESSION['name'];
        $roomnum = $_SESSION['roomnum'];
        $_SESSION['userId'] = $userId;
        $_SESSION['name'] = $name;
        $_SESSION['roomnum'] = $roomnum;
    ?>

    <nav class="upper">
        <div>創造專屬彼此的UTOPIA吧！</div>
    </nav>        


    <!-- nav -->
    <nav class="navbar navbar-expand-lg navbar-light fixed-top" id="bg_color">
        <a class="navbar-brand" href="./mainpage.php?roomnum=<?php echo $_SESSION['roomnum']; ?>&userId=<?php echo $_SESSION['userId']; ?>&name=<?php echo $_SESSION['name']; ?>">名稱</a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNavDropdown" aria-controls="navbarNavDropdown" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNavDropdown">
            <ul class="navbar-nav">
                <li class="nav-item">
                    <a class="nav-link" href="../chatroom/php/index.php?roomnum=<?php echo $_SESSION['roomnum']; ?>&userId=<?php echo $_SESSION['userId']; ?>&name=<?php echo $_SESSION['name']; ?>">聊天室</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="../diary/index.php">日記本</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="../photo_room/photo_book.php">相簿</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="./mainpage.php?roomnum=<?php echo $_SESSION['roomnum']; ?>&userId=<?php echo $_SESSION['userId']; ?>&name=<?php echo $_SESSION['name']; ?>">紀念日</a>
                </li>
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" id="navbarDropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        其他
                    </a>
                    <div class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">
                        <a class="dropdown-item" href="../update/php/personal.php">個人資料設定</a>
                        <a class="dropdown-item" href="../login_register/login.php">登出</a>
                    </div>
                </li>
            </ul>
        </div>
    </nav>

    <div class="login_container">
        <div class="login_word">新增紀念日</div>
        <form style="height: 85%;" action="" method="POST">
            <div class="account_container">
                <div class="account" style="height: 100%;">
                    <input type="text" placeholder="  紀念日名稱" class="account_input" name="specialday_name">
                </div>
                <div style="height: 100%;">
                    <input type="date" class="account_input" id="password_input" name="special_date">
                </div>
            </div>
            <button type="submit" id="register_button">確定新增</button>
        </form>
    </div>
    
    <?php
        if($_SERVER["REQUEST_METHOD"] == "POST"){
            // Retrieve the input data from the registration form
            $specialday_name = $_POST['specialday_name'];
            $special_date = $_POST['special_date'];
            $special_date = strtotime($special_date);
            $special_date = date("d-M-Y H:i:s", $special_date);
            $roomnum = $_SESSION['roomnum'];

            //add roomnum and data
            $sql = "INSERT INTO SPECIALDAY (ROOMID, DATES, NAME) VALUES (:ROOMID, TO_TIMESTAMP('$special_date', 'DD-MON-YYYY HH24:MI:SS'), :NAME)";
            $stmt = oci_parse($conn, $sql);
            oci_bind_by_name($stmt, ':ROOMID', $roomnum);
            oci_bind_by_name($stmt, ':NAME', $specialday_name);

            if (oci_execute($stmt)) {
                echo "<script>alert('成功新增紀念日');</script>";
            } else {
                echo "<script>alert('新增失敗，請再試一次');</script>";
            }

            // Close the statement and connection resources
            oci_free_statement($stmt);
            oci_close($conn);
        }
    ?>

    <footer>
        <div class="upper_footer">
            <div class="footer_left">名字</div>
            <div class="footer_right">
                <div class="footer_table">Table of Contents</div>
                <div class="footer_lists">
                    <ul>
                        <li><a href="../chatroom/php/index.php?roomnum=<?php echo $_SESSION['roomnum']; ?>&userId=<?php echo $_SESSION['userId']; ?>&name=<?php echo $_SESSION['name']; ?>">聊天室</a></li>
                        <li><a href="./mainpage.php?roomnum=<?php echo $_SESSION['roomnum']; ?>&userId=<?php echo $_SESSION['userId']; ?>&name=<?php echo $_SESSION['name']; ?>">紀念日</a></li>
                        <li><a href="../diary/index.php">日記本</a></li>
                        <li><a href="../photo_room/photo_book.php">相簿</a></li>
                    </ul>
                </div>
            </div>
        </div>
        <div class="latter_footer">
            © B094020013 B094020024 B094020042 in 2023
        </div>
    </footer>
    <section style="height: 10%;"></section>
    
    <script type="text/javascript">  
        $(function(){  
        var nav=$(".navbar"); //導航對象,註意與您的保持一緻。  
        var win=$(window); //窗口對象  
        var sc=$(document);//document文檔對象。  
        win.scroll(function(){  
          if(sc.scrollTop()>=20){  // 滾動高度視情況而定。 
           nav.addClass("fixed-top");   
          }else{  
           nav.removeClass("fixed-top");  
          }  
        })    
       })  
     </script> 
</body>
</html>