<?php

namespace Piges\Auth;

class AuthenticationHolder {

	private static Authentication $authentication;

	public static function getAuthentication(): Authentication {
		return self::$authentication;
	}

	public static function setAuthentication(Authentication $authentication) {
		self::$authentication = $authentication;
	}
}