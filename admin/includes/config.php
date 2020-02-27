<?php  
// DB credentials.
define('DB_HOST','IBSKE00298');
define('DB_USER','root');
define('DB_PASS','');
define('DB_NAME','tms');
// Establish database connection.
try
{
$dbh = new PDO("sqlsrv:Server=IBSKE00298;Database=tms","sa", "pass@word1",array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES 'utf8'"));
}
catch (PDOException $e)
{
exit("Error: " . $e->getMessage());
}
?>