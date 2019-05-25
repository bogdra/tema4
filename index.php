<?php

require_once('Helpers/Configs.php');

\Helpers\Configs::autoload();

$controller_obj = new \Controllers\Products;
$controller_obj->display();