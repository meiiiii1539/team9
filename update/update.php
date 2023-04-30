<?php 
    include "../config.php";
    session_start();
  
    if($_POST["method"]=="updatecontent"){
    $name = $_POST["myname"];
    $acc = $_POST["myaccount"];
    $pass = $_POST["mypass"];
    $output="";
    $output.="
    <form style='width:70%'>
    <div class='personaldata' id='here'>
    <p class='title'>個人資料</p>
    <label>Name</label>
    <input required type='text' value='$name' class='updateinput' id='updatename' autocomplete='current-password'>
    <label>accont</label>
    <input required type='text' value='$acc'class='updateinput' id='updateacc' autocomplete='current-password'>
    <label>password</label>
    <input required type='password' value='$pass' class='updateinput' id='updatepass' autocomplete='current-password'>
    </div>    
    </form>
    <div class='buttonbox'>
    <button type='submit' class='buttontype2' onclick='update()'>確認</button>
    </div>";

    echo $output;

    
    }


    else if($_POST["method"]=="changephoto"){
        echo "12345";
        if(@$_FILES["myfile"]["error"]!=0){
            echo "出現錯誤". $_FILES["myfile"]["error"];
            $status=0;
        }else{
            $filename= @$_FILES["myfile"]["name"];  
            $destination= "../static/destination/$filename";

            
            if(file_exists($destination)){ //存在為true 不存在為false
                echo "目的地有此檔案";
                echo "<script>";
                echo "history.back(-1)";
                echo "</script>"; 
            }else{
                if(move_uploaded_file(@$_FILES["myfile"]["tmp_name"],$destination)){
                    //move_uploaded_file函式檢查並確保由 file 指定的檔案是合法的上傳檔案
                    $sql= "UPDATE USERS SET PHOTO='$destination' WHERE UIDS = '{$_SESSION['userId']}'";
                    $result=oci_parse($link,$sql);
                    oci_execute($result);
                    if($result){
                        echo "上傳成功";
                        echo "<script>";
                        echo "history.back(-1)";
                        echo "</script>"; 
                    }else{
                        echo "上傳失敗";
                        $status=0;
                    }
                }
                else{
                    echo "12345000";
                }
    
            }
        }
 
    }
    
?>