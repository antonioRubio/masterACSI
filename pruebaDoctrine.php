<?php
require 'Doctrine/Common/ClassLoader.php';
use Doctrine\Common\ClassLoader;
$classLoader = new ClassLoader('Doctrine');
$classLoader->register();

use Doctrine\DBAL\DriverManager;
//require 'Doctrine/DBAL/Configuration.php';
//require 'Doctrine/DBAL/DriverManager.php';

$config = new \Doctrine\DBAL\Configuration();
$connectionParams = array(
	'driver' => 'pdo_mysql',
	'dbname' => 'asterisk',
	'user' => 'asterisk',
	'password' => 'asterisk',
	'host' => '192.168.1.133',
);
$conn = DriverManager::getConnection($connectionParams, $config);
$sql = 'SELECT * FROM cel';
$stmt = $conn->query($sql);
$sm = $conn->getSchemaManager();
echo "<pre>";
print_r($sm->listTables());
echo "</pre>";
while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
	echo '<pre>';
	print_r($row);
	echo '</pre>';
}
?>