<?php

namespace Piges\Ucp;

use Exception;
use Piges\Ucp\Token\UcpTokenService;

class UcpFilter {

	private static UcpTokenService $ucpTokenService;

	public static function filter() {
		if(!isset(self::$ucpTokenService) || self::$ucpTokenService == null) {
			self::$ucpTokenService = new UcpTokenService();
		}
		
		$ucpToken = self::getUcpToken();
		
		if($ucpToken == "") {
			throw new Exception("Ucp not present in the request", 401);
		}

		if(!self::$ucpTokenService->validateToken($ucpToken)) {
			throw new Exception("Problem in Ucp token", 401);
		}

		UcpHolder::setUcp(self::$ucpTokenService->getUcp($ucpToken));
	}
	
	private static function getUcpToken() {
		$headers = apache_request_headers();
		
		return $headers['X-Ucp-Jwt'];
	}

}

?>