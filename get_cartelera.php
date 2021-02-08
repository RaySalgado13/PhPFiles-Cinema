<?php

require 'ManejadorBD.php';

$m = new ManejadorBD();
$result = $m->getCatalogo();
echo json_encode($result,JSON_FORCE_OBJECT);

?>