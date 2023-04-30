<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mainpage</title>
    <!-- ------------- -->
    <link rel="stylesheet" type="text/css" href="mainpage.css">
    <link rel="stylesheet" type="text/css" href="../footer.css">
    <link href="../navbar.css" rel="Stylesheet" type="text/css" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-KK94CHFLLe+nY2dmCWGMq91rCGa5gtU4mk92HdvYe+M/SXH301p5ILy+dN9+nJOZ" crossorigin="anonymous">
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.14.7/dist/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.3.1/dist/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
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
        $_SESSION['userId'] = $_GET['userId'];
        $_SESSION['name'] = $_GET['name'];
        $_SESSION['roomnum'] = $_GET['roomnum'];
    ?>

    <nav class="upper">
        <div>創造專屬彼此的 UTOPIA 吧！</div>
    </nav>

    
    <!-- nav -->
    <nav class="navbar navbar-expand-lg navbar-light fixed-top" id="bg_color">
        <a class="navbar-brand" href="#">名稱</a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNavDropdown" aria-controls="navbarNavDropdown" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNavDropdown">
            <ul class="navbar-nav">
                <li class="nav-item">
                    <a class="nav-link" href="../chatroom/php/index.php">聊天室</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#">日記本</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#">相簿</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#sec2">紀念日</a>
                </li>
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" id="navbarDropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        其他
                    </a>
                    <div class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">
                        <a class="dropdown-item" href="../update/php/personal.php">個人資料設定</a>
                        <a class="dropdown-item" href="#">登入/登出</a>
                    </div>
                </li>
            </ul>
        </div>
    </nav>

    <section class="section0"></section>

    <section class="section1">
        <div class="cool_container">
            <div class="cool">
                <div class="cool_word">創造專屬彼此的 UTOPIA 吧！</div>
            </div>
        </div>
    </section>
    <section class="section2" id="sec2">
        <div id="slider">
            <input type="radio" name="slider" id="slide1">
            <input type="radio" name="slider" id="slide2">
            <input type="radio" name="slider" id="slide3">
            <div id="slides">
                <div id="overflow">
                    <div class="inner">
                        <div class="slide slide_1">
                            <div class="slide-content">
                                <h2>紀念日1</h2>
                                <p>距離100天</p>
                                <p>D-23</p>
                            </div>
                        </div>
                        <div class="slide slide_2">
                            <div class="slide-content">
                                <h2>紀念日2</h2>
                                <p>距離2年</p>
                                <p>D-143</p>
                            </div>
                        </div>
                        <div class="slide slide_3">
                            <div class="slide-content">
                                <h2>紀念日3</h2>
                                <p>距離1年</p>
                                <p>D-2</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div id="controls">
                <label for="slide1"></label>
                <label for="slide2"></label>
                <label for="slide3"></label>
            </div>
            <div id="bullets">
                <label for="slide1"></label>
                <label for="slide2"></label>
                <label for="slide3"></label>
            </div>
        </div>
        <div class="add_anniversary"><a href="./add_anniversary.php?roomnum=<?php echo $_SESSION['roomnum']; ?>UIDS=<?php echo $_SESSION['userId']; ?>name=<?php echo $_SESSION['name']; ?>" class="add_anniversarya">新增紀念日</a></div>
    </section>

    <?php
        
    ?>

    <section class="section3">
        <div class="section3_container">
            <div class="left">
                <div class="section3_pic_container"><a href="#" style="height: 100%; width: 100%;"><img src="../img/diary.jpg" alt="圖片出了一點問題！" id="diary_photo"></a></div>
                <div class="section3_description"><a href="#" class="nodecoration">日記本</a></div>
                <div class="section3_button"><a href="#" style="height: 100%; width: 100%;" class="button_a">GO !</a></div>
            </div>
            <div class="right">
                <div class="section3_pic_container"><a href="#" style="height: 100%; width: 100%;"><img src="../img/album.jpg" alt="圖片出了一點問題！" id="diary_photo"></a></div>
                <div class="section3_description"><a href="#" class="nodecoration">相簿</a></div>
                <div class="section3_button"><a href="#" style="height: 100%; width: 100%;" class="button_a">GO !</a></div>
            </div>
        </div>
    </section>
    <section class="section4">
        <marquee class="cr_marquee">創造專屬彼此的 UTOPIA 吧！cr. B094020013 B094020024 B094020042 2023</marquee>
    </section>

    <footer>
        <div class="upper_footer">
            <div class="footer_left">名字</div>
            <div class="footer_right">
                <div class="footer_table">Table of Contents</div>
                <div class="footer_lists">
                    <ul>
                        <li><a href="#">聊天室</a></li>
                        <li><a href="#">紀念日</a></li>
                        <li><a href="#">日記本</a></li>
                        <li><a href="#">相簿</a></li>
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