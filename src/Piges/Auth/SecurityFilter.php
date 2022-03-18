<?php

namespace Piges\Auth;

use Exception;
use Piges\Auth\Token\TokenService;
use Piges\Auth\Token\Provider\CognitoProviderService;

class SecurityFilter {

	private static TokenService $tokenService;

	public static function filter() {
		if(!isset(self::$tokenService) || self::$tokenService == null) {
			self::$tokenService = new CognitoProviderService();
		}
		
		$accessToken = self::getBearerToken();
		
		if($accessToken == "") {
			throw new Exception("not readeable token", 401);
		}

		if(!self::$tokenService->validateToken($accessToken)) {
			throw new Exception("not valid token", 401);
		}

		AuthenticationHolder::setAuthentication(self::$tokenService->getAuthentication($accessToken));
	}
	
	/**
	 * get access token from header
	 * */
	private static function getBearerToken()
	{
		$headers = self::getAuthorizationHeader();
		// HEADER: Get the access token from the header
		if (!empty($headers)) {
			if (preg_match('/Bearer\s(\S+)/', $headers, $matches)) {
				return $matches[1];
			}
		}
		return null;
	}

	/** 
	 * Get header Authorization
	 * */
	private static function getAuthorizationHeader()
	{
		$headers = null;
		if (isset($_SERVER['Authorization'])) {
			$headers = trim($_SERVER["Authorization"]);
		} else if (isset($_SERVER['HTTP_AUTHORIZATION'])) { //Nginx or fast CGI
			$headers = trim($_SERVER["HTTP_AUTHORIZATION"]);
		} elseif (function_exists('apache_request_headers')) {
			$requestHeaders = apache_request_headers();
			// Server-side fix for bug in old Android versions (a nice side-effect of this fix means we don't care about capitalization for Authorization)
			$requestHeaders = array_combine(array_map('ucwords', array_keys($requestHeaders)), array_values($requestHeaders));
			//print_r($requestHeaders);
			if (isset($requestHeaders['Authorization'])) {
				$headers = trim($requestHeaders['Authorization']);
			}
		}
		return $headers;
	}

}

?>