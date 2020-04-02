<?php
require_once(__DIR__ . '/_Controller.php');
$d = new Tips();

switch ($params[2]) {
	case "getRandom":
		$d->withJson($d->getRandom());
	break;
	default:
		$d->withJson(["error"=>"default"]);	
}

exit();


