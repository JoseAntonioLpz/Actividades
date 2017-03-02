<?php

header('Content-Type: application/json');

require_once('../clases/Autoload.php');
require_once('../clases/vendor/autoload.php');

$json = json_decode(file_get_contents('php://input'));
$parametros = explode('/', $_GET['url']);

$api = new Api($_SERVER['REQUEST_METHOD'], $json, $parametros, $_GET);
$api->doJob();

//echo $api->getResponse();
$respuesta = json_encode($api->getResponse()); 
echo $respuesta;