<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf8">
<meta name="format-detection" content="telephone=no">
<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
<meta name="apple-mobile-web-app-capable" content="yes">
<meta name="apple-mobile-web-app-status-bar-style" content="black">
<title>用户信息管理</title>
<link rel="stylesheet" media="screen" href="css/css.css" />
</head>
<?php require 'config.php';?>

<form id="msform">
	<fieldset>
		<h2 class="fs-title">所有用户</h2>
		<?php
		$rank=1;		
		echo "<table class='gridtable'> "; 
		echo "<th width=80 scope=col>序号</th> ";
		echo "<th width=80 scope=col>id</th> ";
		echo "<th width=100 scope=col>手机号</th>";
		echo "<th width=100 scope=col>剩余次数</th>";
		echo "<th width=100 scope=col>总层数</th>";
		echo "</tr>";

    $strSql="select * from ".$tablename." order by score desc";
    $result=mysql_query($strSql,$myconn);
    while($row = mysql_fetch_array($result))
    {
?>
	<tr>
	   <td align="center" height="19"><?echo $rank;?></td>
		<td align="center" height="19"><?echo $row["id"]?></td>
		<td align="center"><?echo $row["phonenum"]?></td>
		<td align="center"><?echo $row["current_count"]?></td>
		<td align="center"><?echo $row["score"]?></td>


	</tr>
<?
$rank++;
    }
    //关闭对数据库的连接
    mysql_close($myconn);
?>
</table>
	
	</fieldset>
</form>


<br><br><br><br><br><br><br><br><br><br>
<br><br><br><br><br><br><br><br><br><br>

</body>
</html>
