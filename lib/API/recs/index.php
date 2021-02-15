<?php
require_once(__DIR__ . '/_Controller.php');
$d = new Recs();

switch ($params[2]) {
	case "get":
		Cookies::authCheck();
		$d->withJson($d->get());
	break;
	case "getAll":
		Cookies::authCheck();
		if ($GLOBALS['user']['id_role'] < 3) {$d->withJson(["error"=>"default"]);exit();}
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
	case "edit":
		Cookies::authCheck();
		$d->withJson($d->edit());
	break;
	case "update":
		Cookies::authCheck();
		$d->withJson($d->update());
	break;
	
	default:
		$d->withJson(["error"=>"default"]);	
}

exit();


