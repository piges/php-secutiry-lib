<?php

namespace Piges\Auth\Token\Provider;

use Firebase\JWT\JWT;
use Firebase\JWT\Key;
use Piges\Auth\Authentication;
use Piges\Auth\Token\RemoteJwkSigningKeyResolver;
use Piges\Auth\Token\TokenService;

class CognitoProviderService implements TokenService {

	public function getAuthentication(string $accessToken): Authentication {
		$id = null;
		$authorities = Array();
		{
			$accessTokenHeader = json_decode(base64_decode(str_replace('_', '/', str_replace('-','+',explode('.', $accessToken)[0]))));

			$accessTokenObj = JWT::decode($accessToken, new Key(RemoteJwkSigningKeyResolver::GetKey($accessToken), $accessTokenHeader->alg));
			
			// Service account
			if($accessTokenObj->sub == $accessTokenObj->client_id) {
				$id = $accessTokenObj->sub;
				
				switch ($accessTokenObj->scope) {
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
			if($accessTokenObj->sub != $accessTokenObj->client_id) {
				$id = str_replace("|", ".", $accessTokenObj->username);

				foreach ($accessTokenObj->{'cognito:groups'} as $key => $group) {
					if($group == "ADMIN") {
						$authorities[] = "ROLE_ADMIN";
					}
				}
			}
		}
		return new Authentication($id, $accessToken, $authorities);
	}

	public function validateToken(string $accessToken): bool {
		return true;
	}

}