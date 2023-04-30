<!DOCTYPE html>

<?php
include("../../config.php");
session_start();
$userId = $_SESSION['userId'];
$name = $_SESSION['name'];
$roomnum = $_SESSION['roomnum'];
$_SESSION['userId'] = $userId;
$_SESSION['name'] = $name;
$_SESSION['roomnum'] = $roomnum;



$sql = "SELECT * FROM USERS WHERE UIDS='{$_SESSION['userId']}'";
$stmt=oci_parse($link,$sql); 
oci_execute($stmt); 
$currentuser = oci_fetch_array($stmt, OCI_ASSOC);

$sql2 = "SELECT * FROM USERS WHERE ROOMID =".$currentuser['ROOMID']." AND UIDS != '".$currentuser['UIDS']."'";
$stmt=oci_parse($link,$sql2); 
oci_execute($stmt); 
$partneruser = oci_fetch_array($stmt, OCI_ASSOC);

$sql = "SELECT ROOMID FROM USERS WHERE UIDS =".$currentuser['UIDS']."";
$temp = oci_parse($link,$sql);
oci_execute($temp);
$roomid =oci_fetch_array($temp,OCI_ASSOC);
?>

<head>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-F3w7mX95PdgyTmZZMECAngseQB83DfGTowi0iMjiWaeVhAn4FJkqJByhZMI3AhiU" crossorigin="anonymous">
    <link href="../../navbar.css" rel="stylesheet">
    <link href="../css/index.css" rel="stylesheet">
    
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <title>chatroom</title>
</head>
<body>

     <!-- nav -->
     <nav class="navbar navbar-expand-lg navbar-light fixed-top" id="bg_color">
        <a class="navbar-brand" href="../../mainpage_anni/mainpage.php?roomnum=<?php echo $_SESSION['roomnum']; ?>&userId=<?php echo $_SESSION['userId']; ?>&name=<?php echo $_SESSION['name']; ?>">BE WITH U ʕ•̫͡•ʔ❤ʕ•̫͡•ʔ</a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNavDropdown" aria-controls="navbarNavDropdown" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNavDropdown">
            <ul class="navbar-nav">
                <!-- <li class="nav-item">
                    <a class="nav-link" href="../chatroom/php/index.php">聊天室</a>
                </li> -->
                <li class="nav-item">
                    <a class="nav-link" href="../../diary/index.php">日記本</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="../../photo_room/photo_book.php">相簿</a>
                </li>
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
    <div class="wrap">
        <div class="leftpanel">
            <div class="profileimgzone">
                <div class="profilecut">
                    <img src="../<?=$currentuser['PHOTO']?>" alt="profile" class="profileimg">
                </div> 
                <!-- <button onclick="buttonFunction()">點</button> -->
                       
            </div>
            <div style="text-align:left;padding-left:5%">
            <p class="currentinfo">姓名：<?php echo $currentuser['NAME']?></p>
            <p class="currentinfo">帳號：<?php echo $currentuser['ACCOUNT']?></p>
            </div>
        <script>
                        function buttonFunction() {
                        location.href = '../../update/php/personal.php';
                        // 可以添加其他操作
                        }
         </script>
        </div>
        <div class="rightpanel">
            <div class="head">
                <p class="partnername"><?php echo $partneruser['NAME']?></p>
                <p class="partneraccount"><?php echo $partneruser['ACCOUNT']?></p>
            </div>
            <div class="rightpaneldown">
                <div id="innerright" class="modal-body">
                <?php 
                    $sql = "SELECT * FROM TEXTS WHERE ROOMID ='".$currentuser['ROOMID']."'ORDER BY SEQUENCES";
                    $chat = oci_parse($link,$sql);
                    oci_execute($chat);


                        while($row = oci_fetch_array($chat)){
                            if($row["UIDS"]==$currentuser['UIDS']){
                                echo "<p class='currentp'> ".$currentuser['NAME']."</p>";
                                echo "<div class='currentchatbox'>
                                        <p>".$row['CONTENT']."</p>
                                    </div>";
                            }
                            else{
                                echo "<p class='partnerp'> ".$partneruser['NAME']."</p>";
                                echo "<div class='partnerchatbox'>
                                    <p>".$row['CONTENT']."</p>
                                    </div>";
                            }
                        }
                    
               
                ?> 

                </div>
                <!--  -->
                <div id="textputinhere_outside">
                    <textarea class="form-control" id="textputinhere"></textarea>
                    <button class="btn btn-danger" id="sendtext" type="button">Send!</button>
                </div>
                <!--  -->
            </div>
    </div>

    </div>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.10.1/dist/umd/popper.min.js" integrity="sha384-W8fXfP3gkOKtndU4JGtKDvXbO53Wy8SZCQHczT5FMiiqmQfUpWbYdTil/SxwZgAN" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.1/dist/js/bootstrap.min.js" integrity="sha384-skAcpIdS7UcVUC05LJ9Dxay8AXcDYfBJqt1CJ85S/CFujBsIzCIv+l9liuYLaMQ/" crossorigin="anonymous"></script></body>

<script type="text/javascript">
    var roomid = '<?php echo $roomid['ROOMID'] ?>';
    var currentuser = '<?php echo $currentuser['UIDS'] ?>';
    var partneruser = '<?php echo $partneruser['UIDS'] ?>';
    $(document).ready(function(){
        
        $("#sendtext").on("click",function(){
            
            $.ajax({
                url:"insertMessage.php",
                method:"POST",
                data:{
                
                    fromUser: currentuser,
                    toUser: partneruser,
                    message:$("#textputinhere").val() , 
                    roomid :roomid,
                },
                dataType:"text",
                success:function(data){
                    $("#textputinhere").val("");

                }
            });

        });
    setInterval(() => {
        $.ajax({
            url:"realtimeChat.php",
            method:"POST",
            data:{
                
                fromUser:currentuser,
                toUser:partneruser,
                roomid :roomid,
            },
            dataType:"text",
            success: function(data){
                console.log(data);
                $("#innerright").html(data);
            }

        }
        )
    }, 700);

    });


</script>




</html>




  <!-- <form action="../../member.php" method="GET">   
                <input type="hidden" name="method" value="logout">  
                <button type="submit" class="shape-ex11" style="border:none" >
                            登出
                </button>
            </form>  -->