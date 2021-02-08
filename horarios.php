<?php

require 'ManejadorBD.php';
$pelicula = $_GET['pelicula'];

$m = new ManejadorBD();
$result = $m->findHorarios($pelicula);
echo json_encode($result,JSON_FORCE_OBJECT);

?>