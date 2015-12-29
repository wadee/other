<?php
require "../config.php";
$wgateid=$_GET['wgateid'];

$sql="update ".$tablename." set current_count=1 where id= '".$wgateid."'";
mysql_query($sql,$myconn);


?>