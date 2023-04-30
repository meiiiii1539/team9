<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <!-- ------------- -->
    <link rel="stylesheet" type="text/css" href="login.css">
    <link rel="stylesheet" type="text/css" href="../footer.css">
    <link href="../navbar.css" rel="stylesheet" type="text/css" />
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
    ?>
    <nav class="upper">
        <div>創造專屬彼此的UTOPIA吧！</div>
    </nav>
    
    <!-- nav -->
    <nav class="navbar navbar-expand-lg navbar-light fixed-top" id="bg_color">
        <a class="navbar-brand" href="#">BE WITH U ʕ•̫͡•ʔ❤ʕ•̫͡•ʔ</a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNavDropdown" aria-controls="navbarNavDropdown" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNavDropdown">
            <ul class="navbar-nav">
                <li class="nav-item">
                    <a class="nav-link" href="#" onclick="<?php echo isset($_SESSION['userId']) ? '': 'alert(\'尚未登入\')'; ?>">聊天室</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#" onclick="<?php echo isset($_SESSION['userId']) ? '': 'alert(\'尚未登入\')'; ?>">日記本</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#" onclick="<?php echo isset($_SESSION['userId']) ? '': 'alert(\'尚未登入\')'; ?>">相簿</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#" onclick="<?php echo isset($_SESSION['userId']) ? '': 'alert(\'尚未登入\')'; ?>">紀念日</a>
                </li>
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" id="navbarDropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        其他
                    </a>
                    <div class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">
                        <a class="dropdown-item" href="#" onclick="<?php echo isset($_SESSION['userId']) ? '': 'alert(\'尚未登入\')'; ?>">個人資料設定</a>
                    </div>
                </li>
            </ul>
        </div>
    </nav>

    <div class="login_container">
        <div class="login_word">L O G I N</div>
        <form style="height: 85%;" action="" method="POST">
            <div class="account_container">
                <div class="account" style="height: 100%;">
                    <input type="text" placeholder="  e-mail" class="account_input" name="account">
                </div>
                <div style="height: 100%;">
                    <input type="password" placeholder="  password" class="account_input" id="password_input" name="password">
                </div>
            </div>
            <button type="submit" id="login_button">L O G I N</button>
            <div class="register"><a href="./register.php" class="registera">Register</a></div>
        </form>
    </div>
    
    <?php
        if($_SERVER["REQUEST_METHOD"] == "POST"){
            // 取得使用者輸入的帳號和密碼
            $account = $_POST['account'];
            $password = $_POST['password'];

            // 查詢資料庫是否有符合的使用者
            $sql = "SELECT * FROM users WHERE account = :account AND password = :password";
            $stmt = oci_parse($conn, $sql);
            oci_bind_by_name($stmt, ":account", $account);
            oci_bind_by_name($stmt, ":password", $password);
            oci_execute($stmt);

            // 檢查是否有符合的使用者
            if ($row = oci_fetch_assoc($stmt)) {
                // 登入成功
                session_unset();
                session_start();
                $_SESSION['userId'] = $row['UIDS'];
                $_SESSION['name'] = $row['NAME'];
                $_SESSION['roomnum'] = $row['ROOMID'];
                // header("Location: ../mainpage_anni/mainpage.php?UIDS={$row['UIDS']}&name={$row['NAME']}&roomnum={$row['ROOMID']}");
                header("Location: ../mainpage_anni/mainpage.php");
            } else {
                // 登入失敗
                $error = "帳號或密碼錯誤";
                echo "<script>alert('帳號或密碼錯誤，請重新登入');</script>";
            }
        }
        
    ?>

    <footer>
        <div class="upper_footer">
            <div class="footer_left">名字</div>
            <div class="footer_right">
                <div class="footer_table">Table of Contents</div>
                <div class="footer_lists">
                    <ul>
                        <li><a href="#" onclick="<?php echo isset($_SESSION['userId']) ? '': 'alert(\'尚未登入\')'; ?>">聊天室</a></li>
                        <li><a href="#" onclick="<?php echo isset($_SESSION['userId']) ? '': 'alert(\'尚未登入\')'; ?>">紀念日</a></li>
                        <li><a href="#" onclick="<?php echo isset($_SESSION['userId']) ? '': 'alert(\'尚未登入\')'; ?>">日記本</a></li>
                        <li><a href="#" onclick="<?php echo isset($_SESSION['userId']) ? '': 'alert(\'尚未登入\')'; ?>">相簿</a></li>
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