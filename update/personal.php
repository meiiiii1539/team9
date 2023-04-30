<?php
include("../config.php");
session_start();
$userId = $_SESSION['userId'];
$name = $_SESSION['name'];
$roomnum = $_SESSION['roomnum'];
$_SESSION['userId'] = $userId;
$_SESSION['name'] = $name;
$_SESSION['roomnum'] = $roomnum;

$sql = "SELECT * FROM USERS WHERE UIDS=".$_SESSION['userId']."";
$result=oci_parse($link,$sql);
oci_execute($result);
$currentuser = oci_fetch_array($result);

$sql2 = "SELECT * FROM USERS WHERE ROOMID =" . $currentuser['ROOMID'] . " AND UIDS != '" . $currentuser['UIDS'] . "'";
$stmt=oci_parse($link,$sql2); 
oci_execute($stmt); 
$partneruser = oci_fetch_array($stmt, OCI_ASSOC);


?>


<!DOCTYPE html>
<head>
    <meta charset="utf-8">    
    <link href="../navbar.css" rel="stylesheet">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-F3w7mX95PdgyTmZZMECAngseQB83DfGTowi0iMjiWaeVhAn4FJkqJByhZMI3AhiU" crossorigin="anonymous">
    <link href="css/personal.css" type="text/css" rel="stylesheet">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Noto+Serif+HK:wght@700&display=swap" rel="stylesheet">


    <!-- <link herf="./css/cart.css" type="text/css" rel="stylesheet"/> -->
<style>
   
   
</style>
</head>
<body>
     <!-- nav -->
     <nav class="navbar navbar-expand-lg navbar-light fixed-top" id="bg_color">
        <a class="navbar-brand" href="../mainpage_anni/mainpage.php">BE WITH U ʕ•̫͡•ʔ❤ʕ•̫͡•ʔ</a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNavDropdown" aria-controls="navbarNavDropdown" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNavDropdown">
            <ul class="navbar-nav">
                <li class="nav-item">
                    <a class="nav-link" href="../chatroom/php/index.php">聊天室</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="../diary/index.php">日記本</a>
                </li>
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
                        <a class="dropdown-item" href="./personal.php">個人資料設定</a>
                        <a class="dropdown-item" href="../login_register/login.php">登出</a>
                    </div>
                </li>
            </ul>
        </div>
    </nav>
    <div class="wrap"><!-- 外殼 -->
        <div class='leftbox'><!-- 內殼1 -->
            <div class="photobox"> <!-- 內殼1之內殼 -->
                <div class="hopecansize">
                <img src="<?=$currentuser['PHOTO'] ?>" class="perpic">
                </div>
                <!-- Button trigger modal -->
                <div class="buttonbox"><button type="button" class="buttontype" data-bs-toggle="modal" data-bs-target="#staticBackdrop">更換照片</button></div>


                <!-- Modal -->
                            <div class="modal fade" id="staticBackdrop" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header"> 
                                            <h5 class="modal-title" id="staticBackdropLabel"></h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                        </div>

                                        <div class="modal-body">
                                            <form action="./update.php" method="post" enctype="multipart/form-data">
                                                <input type="hidden" name="method" value="changephoto" >
                                                    <div class="mb-3">
                                                        <label for="myfile" class="form-label">上傳相片</label>
                                                        <input name="myfile" class="form-control" type="file" id="myfile" accept=".jpg, .png,.jpeg" required>
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                                        <button type="submit" class="btn btn-primary" name="update" value="updateprofile">Update</button>
                                                    </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div> 
            </div>  
            <div style="display:flex;flex-direction:row;" id="here">
                <div class="personaldata"> <!-- 內殼1之內殼 -->
                    <p class="title" style="color:#f18d7e">個人資料</p>
                    <label>Name</label>
                    <p class="text1"><?=$currentuser['NAME'] ?></p>
                    <label>accont</label>
                    <p class="text1"><?=$currentuser['ACCOUNT'] ?></p>
                    <label>password</label>
                    <p class="text1"><?=$currentuser['PASSWORD'] ?></p>
                    <label>對方資料</label>
                    <p class="text1"><?=$partneruser['ACCOUNT'] ?></p>
                </div>


                <div class="buttonbox"><!-- 內殼1之內殼 -->
                   
                        <button type="submit" class="buttontype2" onclick="updatecontent()">
                                編輯個人資料
                        </button>
            
                
                </div>
            </div>
        </div>
        <div id="diary"> <!-- 內殼2 --> 
         <p class='title' style="color:#f5f1ee">我的日記</p>
         
            <div class="modal-body" id="tryscroll" >
          
               
                <?php 
                $sql = "SELECT * FROM DIARY WHERE UIDS=".$_SESSION['userId']."";
                $result=oci_parse($link,$sql);
                oci_execute($result);
                // $currentdiary = oci_fetch_array($result);
                while($currentdiary = oci_fetch_array($result)){
                echo "
                <div class='eachdiary'>
                <p class='time'>".$currentdiary['TIME']."</p>
                <p class='text2'>".$currentdiary['CONTENT']."</p>
                </div>
                ";

                }
                // $sql = "SELECT * FROM DIARY WHERE UIDS=".$_SESSION['userId']."";
                // $result122=oci_parse($link,$sql);
                // oci_execute($result122);
                // if(oci_num_rows($result122)==0){
                //     echo"<p class='nodata'>目前沒有日記！請多多分享！</p>";
                // }
               
                ?>
                </div>
            
        </div>

    </div><!-- 外殼結束 -->
    <!-- text1 label wrap -->

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-/bQdsTh/da6pkI1MST/rWKFNjaCP5gBSY4sEBT38Q/9RBh9AH40zEOg7Hlq2THRZ" crossorigin="anonymous"></script>
</body> 



<script>
    var currentuser = '<?php echo $currentuser['NAME'] ?>';
    var currentaccount = '<?php echo $currentuser['ACCOUNT'] ?>';
    var currentpass = '<?php echo $currentuser['PASSWORD'] ?>';
    function updatecontent(){
        $.ajax({
            url:"update.php",
            type:"POST",
            data:{
            method:'updatecontent',
            myname:currentuser,
            myaccount:currentaccount,
            mypass:currentpass},
        

            success:function(result){
                $('#here').html(result);
            },

        });

    }

    function update(){
        

        
        var name = $('#updatename').val();
        var acc = $("#updateacc").val();
        var pass= $("#updatepass").val();
        
        $.ajax({
            url:"update2.php",
            type:"POST",
            data:{
            newname:name,
            newacc:acc,
            newpass:pass,
            myfunc:updatecontent},

            success:function(result){
                $("#updatename").val("");
                $("#updateacc").val("");
                $("#updatepass").val("");
                $('#here').html(result);
                // alert('更新成功！');
                
            }

        });
            
    }


    
</script>
</html>