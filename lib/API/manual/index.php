<?php

require_once(__DIR__ . '/_Controller.php');
$d = new Manual();

switch ($params[2]) {
	case "getUsersList":
		Cookies::authCheck();
		$d->withJson($d->getUsersList());
	break;
	case "updateUserMode":
		Cookies::authCheck();
		if ($GLOBALS['user']['id_role'] == 0) $d->withJson(false);
		$d->withJson($d->updateUserMode());
	break;
	
	
	default:
		$d->withJson(["error"=>"default"]);	
}

exit();


