<?php
$mysql_hostname = "localhost";
$mysql_user = "root";
$mysql_password = "afornalli";
$mysql_database = "futfacil_web";
$prefix = "";
$bd = mysql_connect($mysql_hostname, $mysql_user, $mysql_password) or die("Não foi possível se conectar ao banco de dados");
mysql_select_db($mysql_database, $bd) or die("Não foi possível definir a tabela do banco de dados");

?>