<?php
require_once __DIR__.'/silex.phar';
use Silex\Extension\DoctrineExtension;

$app = new Silex\Application();
$app['debug'] = true;

$db = new PDO('mysql:host=192.168.1.133;dbname=asterisk', 'asterisk', 'asterisk',
	array(PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC));
function obtenerLlamadas($db){
    $sql = 'SELECT * '.
           'FROM cel '.
	   	   'WHERE eventtype LIKE "CHAN_START" '.
	   	   'AND uniqueid = linkedid';
    $query = $db->query($sql);
	
	return $query;
}
function obtenerEventos($linkedId, $db) {
	$sql = 'SELECT * '.
		   'FROM cel '.
		   "WHERE linkedid LIKE '{$linkedId}'";
	$query = $db->query($sql);

	return $query;
		    
}
$app->get('/asterisk', function () use ($db, $app) {
	$llamadas = obtenerLlamadas($db);
    $output = '';
    foreach($llamadas as $llamada) {
    	$linkedId = $llamada['linkedid'];
		$output .= '<hr />';
		$eventos = obtenerEventos($linkedId, $db);
		$output .= json_encode($eventos->fetchAll());
		$output .= '<hr /><br />';
    }
    return $output;
});

$app->run();
?>
