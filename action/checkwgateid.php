<?php
require "../config.php";
$wgateid=$_GET['wgateid'];

$strSql="select count(*) from ".$tablename." where id='".$wgateid."'";

$query = mysql_query($strSql);
$row = mysql_fetch_array($query);


if($row[0]!=0)
{
 echo "true";
}
else
{
echo "false";
}
			
?>