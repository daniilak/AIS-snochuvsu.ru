<?php
require_once(__DIR__ . '/_Controller.php');
$d = new InstTypes();

switch ($params[2]) {
	case "getAll":
		$d->withJson($d->getAll());
	break;
	default:
		$d->withJson(["error"=>"default"]);	
}

exit();


