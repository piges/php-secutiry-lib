<?php

namespace Piges\Auth\Token;

use Piges\Auth\Authentication;

interface TokenService {
	
	public function getAuthentication(string $accessToken): Authentication;

	public function validateToken(string $accessToken): bool;

}