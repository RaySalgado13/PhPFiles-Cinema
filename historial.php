<?php

require 'ManejadorBD.php';
$usuario = $_GET['usuario'];

$m = new ManejadorBD();
$result = $m->findHistorial($usuario);
echo json_encode($result,JSON_FORCE_OBJECT);

?>