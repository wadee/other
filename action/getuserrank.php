<?php
require "../config.php";
$mobile=$_GET['mobile'];


$sql="select count(1) as userrank from ".$tablename." where score >= (select score from ".$tablename." where phonenum = '".$mobile."')";
$result=mysql_query($sql,$myconn);
while($row = mysql_fetch_array($result))
{
    echo '{"rank":"'.($row[0]).'",';
	
	$sql2="select score from ".$tablename." where phonenum = '".$mobile."'";
	$result2=mysql_query($sql2,$myconn);
	while($row2 = mysql_fetch_array($result2))
	{			
		echo '"score":"'.$row2[0].'",';
		
		$sql3="select score from ".$tablename." order by score desc limit 1";
		$result3=mysql_query($sql3,$myconn);
		while($row3 = mysql_fetch_array($result3))
		{		 
			echo '"remain":"'.($row3[0]-$row2[0]).'"}';
		}
	}
}



?>