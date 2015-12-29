<?php
require "../config.php";
$wgateid=$_GET['wgateid'];
$phone=$_GET['phone'];



$insert_sql="insert into ".$tablename." (id,phonenum) VALUES ('".$wgateid."','".$phone."')";
mysql_query($insert_sql,$myconn);
echo mysql_error();
echo "true";

?>