<?php 
// DB credentials.
define('DB_HOST','localhost');
define('DB_USER','myanniversary');
define('DB_PASS','Myaacctp@55');
define('DB_NAME','myanniversary');
// Establish database connection.
try
{
$dbh = new PDO("mysql:host=".DB_HOST.";dbname=".DB_NAME,DB_USER, DB_PASS,array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES 'utf8'"));
}
catch (PDOException $e)
{
exit("Error: " . $e->getMessage());
}
?>
