<?php
require_once(__DIR__ . '/_Controller.php');
$d = new Conf();

switch ($params[2]) {
	case "getActive":
		$d->withJson($d->getActive());
	break;
	case "getAll":
		$d->withJson($d->getAll());
	break;
	case "getAllData":
		Cookies::authCheck();
		if ($GLOBALS['user']['id_role'] < 3) {$d->withJson(["error"=>"default"]);exit();}
		$d->withJson($d->getAllData());
	break;
	case "setConfActive":
		Cookies::authCheck();
		if ($GLOBALS['user']['id_role'] < 5) {$d->withJson(["error"=>"default"]);exit();}
		$d->withJson($d->setConfActive());
	break;
	case "setConfName":
		Cookies::authCheck();
		if ($GLOBALS['user']['id_role'] < 5) {$d->withJson(["error"=>"default"]);exit();}
		$d->withJson($d->setConfName());
	break;
	case "setRecName":
		Cookies::authCheck();
		if ($GLOBALS['user']['id_role'] < 5) {$d->withJson(["error"=>"default"]);exit();}
		$d->withJson($d->setRecName());
	break;
	case "removeRec":
		Cookies::authCheck();
		if ($GLOBALS['user']['id_role'] < 5) {$d->withJson(["error"=>"default"]);exit();}
		$d->withJson($d->removeRec());
	break;
	case "appendRec":
		Cookies::authCheck();
		if ($GLOBALS['user']['id_role'] < 5) {$d->withJson(["error"=>"default"]);exit();}
		$d->withJson($d->appendRec());
	break;
	case "setDate":
		Cookies::authCheck();
		if ($GLOBALS['user']['id_role'] < 5) {$d->withJson(["error"=>"default"]);exit();}
		$d->withJson($d->setDate());
	break;
	
	
	case "insert":
		Cookies::authCheck();
		if ($GLOBALS['user']['id_role'] < 3) {$d->withJson(["error"=>"default"]);exit();}
		$d->withJson($d->insert());
	break;
	case "remove":
		Cookies::authCheck();
		if ($GLOBALS['user']['id_role'] < 3) {$d->withJson(["error"=>"default"]);exit();}
		$d->withJson($d->remove());
	break;
	case "edit":
		Cookies::authCheck();
		if ($GLOBALS['user']['id_role'] < 3) {$d->withJson(["error"=>"default"]);exit();}
		$d->withJson($d->edit());
	break;
	default:
		$d->withJson(["error"=>"default"]);	
}

exit();


