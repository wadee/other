<?php
require "../config.php";
$mobile=$_GET['mobile'];
$score=$_GET['score'];


$sql="update ".$tablename." set score=score+".$score." where phonenum= '".$mobile."'";
mysql_query($sql,$myconn);

?>