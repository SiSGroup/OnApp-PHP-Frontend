<?php

require_once "VirtualMachine.php";


$obj = new ONAPP_VirtualMachine();

$obj->auth(
    "109.123.105.162",
    "admin",
    "dev6dot162"
);


$obj->migrate(
    657,
    1
);

print_r($obj);

?>
