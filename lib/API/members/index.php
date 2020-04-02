<?php
require_once(__DIR__ . '/_Controller.php');
$d = new Members();

switch ($params[2]) {
	case "getAll":
		$d->withJson($d->getAll());
	break;
	case "append":
		Cookies::authCheck();
		$d->withJson($d->append());
	break;
	case "remove":
		Cookies::authCheck();
		$d->withJson($d->remove());
	break;
	case "update":
		Cookies::authCheck();
		$d->withJson($d->update());
	break;
	
	default:
		$d->withJson(["error"=>"default"]);	
}

exit();


