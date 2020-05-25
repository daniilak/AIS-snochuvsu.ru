<?php
require_once(__DIR__ . '/_Controller.php');
$d = new Comments();

switch ($params[2]) {
	case "getAll":
		$d->withJson($d->getAll());
	break;
	case "insert":
		Cookies::authCheck();
		$d->withJson($d->add());
	break;
	default:
		$d->withJson(["error"=>"default"]);	
}

exit();


