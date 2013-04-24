<?php
$conn = mysql_connect("SAE_MYSQL_HOST_M","SAE_MYSQL_USER","SAE_MYSQL_PASS") or die("无法连接数据库");
mysql_select_db("SAE_MYSQL_DB". $conn) or die ("不能选择数据库: ".mysql_error());
mysql_query("set names 'utf8'"); 
