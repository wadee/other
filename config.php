<?php
//主机地址，一般为localhost不用改
$dbhost = '127.0.0.1:3306';
//数据库名
$dbname = 'other';
//用户名
$dbuser = 'root';
//密码
$dbpwd = '123456';
//表名
$tablename = 'jinrongjie_05';

//gamemark必须唯一，妨止游戏数据混淆
$gamemark="jinrongjie";



$normaluser="normal";
$tempuser="temp";


$myconn=mysql_connect($dbhost,$dbuser,$dbpwd);
mysql_select_db($dbname,$myconn);
?>