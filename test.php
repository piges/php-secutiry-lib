<?php

if (isset($_SERVER['HTTP_ORIGIN'])) {
	//header("Access-Control-Allow-Origin: {$_SERVER['HTTP_ORIGIN']}");
	header('Access-Control-Allow-Credentials: true');
	header('Access-Control-Max-Age: 86400');
}

if ($_SERVER['REQUEST_METHOD'] == 'OPTIONS') {
	if (isset($_SERVER['HTTP_ACCESS_CONTROL_REQUEST_METHOD']))
		header("Access-Control-Allow-Methods: GET, POST, OPTIONS");
	
	if (isset($_SERVER['HTTP_ACCESS_CONTROL_REQUEST_HEADERS']))
		header("Access-Control-Allow-Headers: {$_SERVER['HTTP_ACCESS_CONTROL_REQUEST_HEADERS']}");

	exit(0);
}

header('Content-Type: application/json; charset=utf-8');

use Piges\Auth\AuthenticationHolder;
use Piges\Auth\SecurityFilter;
require __DIR__ . '/vendor/autoload.php';


$response = Array();

try {
	SecurityFilter::filter();

	$response["data"] = Array(
		'user' => AuthenticationHolder::getAuthentication()->getId(),
		'token' => AuthenticationHolder::getAuthentication()->getToken(),
		'auth' => AuthenticationHolder::getAuthentication()->getAuthorities(),
	);

	$response["message"] = "yess";
	$response["code"] = "200";


} catch (\Throwable $th) {
	$response["message"] = $th->getMessage();
	$response["code"] = $th->getCode();
	$response["error"] = $th;
}

http_response_code($response["code"]);
print json_encode($response);