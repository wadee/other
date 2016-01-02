<html>
<head>
<title>建立数据库</title>
 <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
</head>
<body>
<?php require 'config.php';?>
<?php
$my_connect = mysql_connect($dbhost,$dbuser,$dbpwd);     //连接数据库
if($my_connect)    //判断是否已经连接上
{
echo "成功连接!<br/>";
}
else
{
die("连接数据库失败");
}

mysql_select_db($dbname,$my_connect);
session_start();
mysql_query("SET NAMES 'utf8'",$my_connect);

$sql="CREATE TABLE ".$tablename."(
						id int  NOT NULL AUTO_INCREMENT,
						PRIMARY KEY(id),
                        phonenum varchar(20) NOT NULL,
						current_count int NOT NULL DEFAULT 0,
						last_play varchar(20) DEFAULT 'empty',
						score int DEFAULT 0)";
						
if(mysql_query($sql,$my_connect))
{
	echo "创建数据表成功!<br/>";
}
else{
echo mysql_error()."<br/>";
}

mysql_close($my_connect);//关闭数据库


?>
</body>
</html>