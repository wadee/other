<?php
require "../config.php";
$wgateid=$_GET['wgateid'];
$score=$_GET['score'];


$sql="update ".$tablename." set score=score+".$score." where id= '".$wgateid."'";
mysql_query($sql,$myconn);

?>