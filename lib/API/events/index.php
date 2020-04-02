<?php
require_once(__DIR__ . '/_Controller.php');
$d = new Events();

switch ($params[2]) {
	case "getByID":
		Cookies::authCheck();
		$d->withJson($d->getByID());
	break;
	case "getAll":
		$d->withJson($d->getAll());
	break;
	case "getForReplace":
		$d->withJson($d->getForReplace());
	break;
	case "getAllByGroupDate":
		$d->withJson($d->getAllByDate());
	break;
	
	case "append":
		Cookies::authCheck();
		if ($GLOBALS['user']['id_role'] == 0) $d->withJson(false);
		$d->withJson($d->append());
	break;
	case "place_dis":
		Cookies::authCheck();
		$d->withJson($d->placeDis());
	break;
	
	case "remove":
		Cookies::authCheck();
		if ($GLOBALS['user']['id_role'] == 0) $d->withJson(['data'=>false]);
		$d->withJson($d->remove());
	break;
	case "pass":
		Cookies::authCheck();
		$d->withJson($d->pass());
	break;
	case "update":
		Cookies::authCheck();
		$d->withJson($d->update());
	break;
	
	default:
		$d->withJson(["error"=>"asd"]);	
}

exit();


