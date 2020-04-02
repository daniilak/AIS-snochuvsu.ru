<?php
require_once(__DIR__ . '/_Controller.php');
$d = new Requests();

switch ($params[2]) {
	case "getByID":
		$d->withJson($d->getByID());
	break;
	case "getAll":
		$d->withJson($d->getAll());
	break;
	case "getList":
		$d->withJson($d->getList());
	break;
	case "sendRequest":
		$d->withJson($d->sendRequest());
	break;
	
	case "append":
		Cookies::authCheck();
		$d->withJson($d->append());
	break;
	case "update":
		Cookies::authCheck();
		$d->withJson($d->update());
	break;
	case "replace":
		Cookies::authCheck();
		$d->withJson($d->replace());
	break;
	case "setPlace":
		Cookies::authCheck();
		$d->withJson($d->setPlace());
	break;
	case "moderator":
		Cookies::authCheck();
		$d->withJson($d->moderator());
	break;
	case "remove":
		Cookies::authCheck();
		$d->withJson($d->remove());
	break;
	
	default:
		$d->withJson(["error"=>"asd"]);	
}

exit();


