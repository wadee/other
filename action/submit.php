<?php
require "../config.php";
$mobile=$_GET['mobile'];

$insert_sql="update ".$tablename." set current_count=current_count+1  where phonenum= '".$mobile."'";
mysql_query($insert_sql,$myconn);
echo mysql_error();
echo "true";

?>