<?php
require_once(__DIR__ . '/_Controller.php');
$d = new Juri();

switch ($params[2]) {
	case "getByID":
		$d->withJson($d->getByID());
	break;
	case "getAll":
		$d->withJson($d->getAll());
	break;
	case "append":
		Cookies::authCheck();
		$d->withJson($d->append());
	break;
	case "update":
		Cookies::authCheck();
		$d->withJson($d->update());
	break;
	case "remove":
		Cookies::authCheck();
		$d->withJson($d->remove());
	break;
	
	default:
		$d->withJson(["error"=>"asd"]);	
}

exit();


