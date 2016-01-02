<?php
require "../config.php";
$mobile=$_GET['mobile'];
$ingame=$_GET['ingame'];

$strSql="select current_count from ".$tablename." where phonenum='".$mobile."'";
$query = mysql_query($strSql);
$row = mysql_fetch_array($query);



// if($row[0]>0)
// {   
//     //如果在游戏当中，那么减去可用次数
// 	if($ingame==1)
// 	{
// 		$sql="update ". $tablename ." set current_count = current_count+1 where id= '".$mobile."'";
// 		mysql_query($sql,$myconn);
// 	}
// }

if ($row == false) {
    echo 0;
    exit;
}
echo $row['current_count'];

?>