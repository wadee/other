<?php
require "../config.php";
$mobile=$_GET['mobile'];

$strSql="select count(*) from ".$tablename." where phonenum='".$mobile."'";

$query = mysql_query($strSql);
$row = mysql_fetch_array($query);

if($row[0]!=0)
{
 echo 1;
}
else
{
echo 0;
}
			
?>