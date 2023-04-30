<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register</title>
    <!-- ------------- -->
    <link rel="stylesheet" type="text/css" href="./login.css">
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
        <?php ob_start(); ?>
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
                        <a class="dropdown-item" href="./login.php">登入</a>
                    </div>
                </li>
            </ul>
        </div>
    </nav>

    <div class="login_container">
        <div class="login_word">註冊帳號</div>
        <form style="height: 85%;" action="" method="POST" enctype="multipart/form-data">
            <div class="account_container">
                <div class="account" style="height: 100%;">
                    <input type="text" placeholder="  email(未來將成為帳號)" class="account_input" name="regis_acc">
                </div>
                <div style="height: 100%;">
                    <input type="password" placeholder="  密碼" class="account_input" id="password_input" name="regis_password">
                </div>
                <div style="height: 100%;">
                    <input type="text" placeholder="  暱稱" class="account_input" id="name_input" name="regis_name">
                </div>
                <div style="height: 100%;">
                    <input type="text" placeholder="  您和伴侶的房間號碼(若無則略過)" class="account_input" id="roomnum_input" name="roomnum">
                </div>
                <div style="height: 100%;">
                    <div id="select_photo">選擇照片</div>
                    <input type="file" accept="image/*" onChange="fileUpload" class="account_input" id="member_photo" name="regis_photo">
                </div>
            </div>
            <button type="submit" id="register_button" name="">創建帳號</button>
        </form>
    </div>

    <?php
        if($_SERVER["REQUEST_METHOD"] == "POST"){
            // Retrieve the input data from the registration form
            $regis_acc = $_POST['regis_acc'];
            $regis_password = $_POST['regis_password'];
            $regis_name = $_POST['regis_name'];
            if(isset($_POST['roomnum']) && !empty($_POST['roomnum'])){
                $roomnum = $_POST['roomnum'];
            } else{
                $roomnum = random_int(100, 999);
                $sql = "INSERT INTO PRIVATESPACE (ROOMID, STARTDATE) VALUES (:ROOMID,  CURRENT_TIMESTAMP)";
                $stmt = oci_parse($conn, $sql);
                oci_bind_by_name($stmt, ':ROOMID', $roomnum);
                oci_execute($stmt);
                // if (oci_execute($stmt)) {
                //     echo "RoomID Record inserted successfully.";
                // } else {
                //     echo "Error inserting record: ";
                // }
            }


            // Prepare the SQL statement to insert the data into the database        
            if ($_FILES['regis_photo']['error'] === UPLOAD_ERR_OK){
                $target_dir = "../static/destination/";
                $target_file = $target_dir . basename($_FILES["regis_photo"]["name"]);
                move_uploaded_file($_FILES["regis_photo"]["tmp_name"], $target_file);
                $sql = "INSERT INTO USERS (ACCOUNT, PASSWORD, NAME, ROOMID, PHOTO) VALUES (:ACCOUNT, :PASSWORD, :NAME, :ROOMID, :PHOTO)";
                $stmt = oci_parse($conn, $sql);
                oci_bind_by_name($stmt, ':ACCOUNT', $regis_acc);
                oci_bind_by_name($stmt, ':PASSWORD', $regis_password);
                oci_bind_by_name($stmt, ':NAME', $regis_name);
                oci_bind_by_name($stmt, ':ROOMID', $roomnum); 
                oci_bind_by_name($stmt, ":PHOTO", $target_file);
            }

            // Execute the SQL statement
            if (oci_execute($stmt)) {
                // 提交事務
                oci_commit($conn);
                session_unset();
                session_start();
                header("Location: ./login.php");
                echo "<script>alert('註冊成功，您的房間號碼是：$roomnum 請重新登入');</script>";
                ob_end_flush();
            } else {
                echo "<script>alert('註冊失敗，請重新註冊');</script>";
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