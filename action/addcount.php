<?php
// require "../config.php";
// $mobile=$_GET['mobile'];

// $sql="update ".$tablename." set current_count=0 where id= '".$mobile."'";
// mysql_query($sql,$myconn);

require "../config.php";
$mobile=$_GET['mobile'];

$insert_sql="insert into ".$tablename." (phonenum) VALUES ('".$mobile."')";
mysql_query($insert_sql,$myconn);
echo mysql_error();
echo "true";