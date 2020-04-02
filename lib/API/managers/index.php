<?php
require_once(__DIR__ . '/_Controller.php');
$d = new Managers();

switch ($params[2]) {
	case "getAll":
		$d->withJson($d->getAll());
	break;
	case "insert":
		Cookies::authCheck();
		$d->withJson($d->insert());
	break;
	case "remove":
		Cookies::authCheck();
		$d->withJson($d->remove());
	break;
	default:
		$d->withJson(["error"=>"default"]);	
}

exit();


