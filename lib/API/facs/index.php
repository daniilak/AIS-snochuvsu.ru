<?php
require_once(__DIR__ . '/_Controller.php');
$d = new Facs();

switch ($params[2]) {
	case "getByID":
		$d->withJson($d->getByID());
	break;
	case "getAll":
		$d->withJson($d->getAll());
	break;
	default:
		$d->withJson(["error"=>"asd"]);	
}

exit();


