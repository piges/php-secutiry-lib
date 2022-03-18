<?php

namespace Piges\Auth\Token\Provider;

use Firebase\JWT\JWT;
use Firebase\JWT\Key;
use Piges\Auth\Dto\Authentication;
use Piges\Auth\Token\RemoteJwkSigningKeyResolver;
use Piges\Auth\Token\AccessTokenService;

class CognitoProviderService implements AccessTokenService {

	public function getAuthentication(string $accessToken): Authentication {
		$id = null;
		$authorities = Array();
		{
			$accessTokenBody = json_decode(base64_decode(str_replace('_', '/', str_replace('-','+',explode('.', $accessToken)[1]))));
			
			// Service account
			if($accessTokenBody->sub == $accessTokenBody->client_id) {
				$id = $accessTokenBody->sub;
				
				switch ($accessTokenBody->scope) {
					case 'PIGES.IO/SYSTEM':
						$authorities[] = "ROLE_SYSTEM";
						break;
					case 'PIGES.IO/MODULE':
						$authorities[] = "ROLE_MODULE";
						break;
					default:
						break;
				}
			}

			// User account
			if($accessTokenBody->sub != $accessTokenBody->client_id) {
				$id = str_replace("|", ".", $accessTokenBody->username);

				foreach ($accessTokenBody->{'cognito:groups'} as $key => $group) {
					if($group == "ADMIN") {
						$authorities[] = "ROLE_ADMIN";
					}
				}
			}
		}
		return new Authentication($id, $accessToken, $authorities);
	}

	public function validateToken(string $accessToken): bool {
		$accessTokenHeader = json_decode(base64_decode(str_replace('_', '/', str_replace('-','+',explode('.', $accessToken)[0]))));
		$key = RemoteJwkSigningKeyResolver::GetKey($accessToken);
		try {
			JWT::decode($accessToken, new Key($key, $accessTokenHeader->alg));
			return true;
		} catch (\Throwable $th) {
			return false;
		}
	}

}