<?php
         include "../config.php";
         session_start();
       
         $sql = "SELECT * FROM USERS WHERE UIDS=".$_SESSION['userId']."";
         $result=oci_parse($link,$sql);
         oci_execute($result);
         $currentuser = oci_fetch_array($result);
     
         $sql2 = "SELECT * FROM USERS WHERE ROOMID =" . $currentuser['ROOMID'] . " AND UIDS != '" . $currentuser['UIDS'] . "'";
         $stmt=oci_parse($link,$sql2); 
         oci_execute($stmt); 
         $partneruser = oci_fetch_array($stmt, OCI_ASSOC);

        $newname=$_POST["newname"];
        $newacc=$_POST["newacc"];
        $newpass=$_POST["newpass"];
        $output="";
        $sql = "UPDATE USERS SET \"NAME\" = '$newname', \"ACCOUNT\" = '$newacc', \"PASSWORD\" = '$newpass' WHERE UIDS = '{$_SESSION['userId']}'";
        $result = oci_parse($link, $sql);
        oci_execute($result);
        if($result){

            $output.="
            <div style='display:flex;flex-direction:row'>
            <div style='display:flex;flex-direction:column' class='personaldata'>
            <p class='title'>個人資料</p>
            <label>Name</label>
            <p class='text1'>".$newname."</p>
            <label>accont</label>
            <p class='text1'>@".$newacc."</p>
            <label>password</label>
            <p class='text1'>".$newpass."</p>
            <label>對方資料</label>
            <p class='text1'>@".$partneruser['ACCOUNT']."</p>
            </div>
            <div class='buttonbox'><!-- 內殼1之內殼 -->
                   
            <button type='submit' class='buttontype2' onclick='updatecontent()'>
            編輯個人資料
            </button>
            
                
             </div>
                
            </div>";
        
            echo $output;

        }
    

    ?>