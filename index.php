<?php
require_once __DIR__.'/silex.phar';
//use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Silex\Extension\DoctrineExtension;

$app = new Silex\Application();
$app['debug'] = true;
/*
$app->get('hello/{name}', function($name) use($app) {
  return 'Hello '.$app->escape($name);
});

$blogPosts = array(
    1 => array(
        'date' => '2011-03-29',
	'author' => 'igorw',
	'title' => 'Using Silex',
	'body' => '...',

    ),
    2 => array(
        'date' => '2011-04-22',
	'author' => 'antonio',
	'title' => 'la mar mosatrague',
	'body' => 'Cuerpooooooo',
    ),

);

$app->get('/blog', function() use($blogPosts) {
    $output = '';
    foreach ($blogPosts as $post) {
        $output .= $post['title'];
	$output .= '<br />';
    }

    return $output;
});

$app->get('/blog/show/{id}', function ($id) use ($blogPosts) {
    if (!isset($blogPosts[$id])) {
        throw new NotFoundHttpException();
    }

    $post = $blogPosts[$id];
    $output = "<h1>{$post['title']}</h1>";
    $output .= "<p>{$post['body']}</p>";
    return $output;
});
*/
/*
$app->register(new DoctrineExtension(), array(
    'db.options' => array(
        'driver' => 'pdo_mysql',
	'dbname' => 'asterisk',
	'user' => 'asterisk',
	'password' => 'asterisk',
	'host' => '192.168.1.133',
        //'host' => 'localhost',
        //'port' => 3306,
    ),
//    'db.options' => array(
//      'driver' => 'pdo_sqlite',
//      'path' => __DIR__.'/app.db',
//    ),
    'db.dbal.class_path' => __DIR__.'/../vendor/doctrine-dbal/lib',
    'db.common.class_path' => __DIR__.'/../vendor/doctrine-common/lib',
));
*/
$db = new PDO('mysql:host=192.168.1.133;dbname=asterisk', 'asterisk', 'asterisk',
	array(PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC));
//$db->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
function obtenerLlamadas($db){
    $sql = 'SELECT * '.
           'FROM cel '.
	   	   'WHERE eventtype LIKE "CHAN_START" '.
	   	   'AND uniqueid = linkedid';
    //$dato = $app['db']->fetchAll($sql);
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
