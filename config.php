<?php
//主机地址，一般为localhost不用改
$dbhost = '127.0.0.1';
//数据库名
$dbname = 'iamtaotao123';
//用户名
$dbuser = 'iamtaotao123';
//密码
$dbpwd = '24362436';
//表名
$tablename = 'jinrongjie_05';

//gamemark必须唯一，妨止游戏数据混淆
$gamemark="jinrongjie";



$normaluser="normal";
$tempuser="temp";


$myconn=mysql_connect($dbhost,$dbuser,$dbpwd);
mysql_select_db($dbname,$myconn);
?>