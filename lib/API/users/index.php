<?php
Cookies::authCheck();

require_once(__DIR__ . '/_Controller.php');
$users = new Users();

switch ($params[2]) {
	case "getByID":
		$users->withJson($users->getByID());
	break;
	case "withJson":
		$users->withJson($users->withJson());
	break;
	default:
		$users->withJson(["error"=>"asd"]);	
}

exit();




