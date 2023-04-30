<?php

include("../../config.php");
$fromUser = $_POST["fromUser"];
$toUser= $_POST["toUser"];
$message = $_POST["message"];
$roomid = $_POST["roomid"];

$output="";

$sql =  "INSERT INTO TEXTS(ROOMID,TIMEEE,UIDS,CONTENT,SEQUENCES) VALUES('$roomid',CURRENT_TIMESTAMP,'$fromUser','$message',TEXTS_SEQUENCE.NEXTVAL)";
$temp= oci_parse($link,$sql);
oci_execute($temp);
if($temp){
    $output.="";
}
else{
    $output.="ERROR";
}
echo $output;

?>