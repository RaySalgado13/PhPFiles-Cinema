<?php

require 'ManejadorBD.php';
$usuario = $_GET['usuario'];
$clave = $_GET['clave'];

$m = new ManejadorBD();
$result = $m->findUser($usuario,$clave);
echo json_encode($result,JSON_FORCE_OBJECT);

?>