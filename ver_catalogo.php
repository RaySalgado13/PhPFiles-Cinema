<?php

require 'ManejadorBD.php';
$table = $_GET['table'];

$m = new ManejadorBD();
$result = $m->showAll($table);
echo json_encode($result,JSON_OBJECT_AS_ARRAY);

?>