<?php

require 'ManejadorBD.php';

$idFuncion = $_GET['funcion'];
$idSucursal = $_GET['sucursal'];
$idUsuario = $_GET['usuario'];


$m = new ManejadorBD();
$result = $m->buyTicket($idFuncion,$idSucursal,$idUsuario,NULL);
echo json_encode($result,JSON_FORCE_OBJECT);

?>