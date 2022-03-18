<?php

namespace Piges\Auth\Token;

use Piges\Auth\Dto\Authentication;

interface AccessTokenService {
	
	public function getAuthentication(string $accessToken): Authentication;

	public function validateToken(string $accessToken): bool;

}