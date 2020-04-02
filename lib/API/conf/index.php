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


