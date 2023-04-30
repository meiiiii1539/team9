<?php
include("../../config.php");
session_start();



$fromUser = $_POST["fromUser"];
$toUser = $_POST["toUser"];
$roomid = $_POST["roomid"];
$output ="";

$sql = "SELECT * FROM USERS WHERE UIDS='".$fromUser."'";
$stmt=oci_parse($link,$sql); 
oci_execute($stmt); 
$currentuser = oci_fetch_array($stmt, OCI_ASSOC);

$sql2 = "SELECT * FROM USERS WHERE ROOMID = '{$currentuser['ROOMID']}' AND UIDS != '{$currentuser['UIDS']}'";
$temp=oci_parse($link,$sql2); 
if(!oci_execute($temp)) {
    echo $sql2;
}
$partneruser = oci_fetch_array($temp, OCI_ASSOC);



$sql = "SELECT * FROM TEXTS WHERE ROOMID ='".$currentuser['ROOMID']."'ORDER BY SEQUENCES";
$chat = oci_parse($link,$sql);
oci_execute($chat);


    while($row = oci_fetch_array($chat)){
        if($row["UIDS"]==$currentuser['UIDS']){
            $output.= "<p style='text-align: right;
                        margin-bottom: 0px;
                        margin-right: 5%;
                        font-weight: bolder;
                        font-size: 12px;'> ".$currentuser['NAME']."</p>

                        <div style=' text-align: right;
                        width: 30%;
                        max-height: 20%;
                        background-color: #f08984;
                        margin-left: 65%;
                        margin-top: 5px;
                        margin-bottom: 30px;
                        border-radius: 15px;
                        font-size: 12px;'>

                        <p style='padding: 15px;'>".$row['CONTENT']."</p>
                         </div>";
        }
        else{
           $output.= "<p style=' text-align: left;
                        margin-bottom: 0px;
                        margin-right: 10%;
                        font-weight: bolder;
                        margin-left: 5%;
                        font-size: 12px;'> ".$partneruser['NAME']."</p>

                        <div style=' text-align: left;
                        font-size: 12px;
                        width: 30%;
                        max-height: 20%;
                        background-color: #f5f1ee;
                        margin-top: 5px;
                        margin-bottom: 30px;
                        margin-left: 2%;
                        border: solid 4px #f08984;
                        border-radius: 15px;'>

                        <p style='padding: 15px;'>".$row['CONTENT']."</p>
                        </div>";
        }
    }

echo $output;



?>
