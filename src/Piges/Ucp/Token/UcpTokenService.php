<?php

namespace Piges\Ucp\Token;

use Exception;
use Firebase\JWT\JWT;
use Firebase\JWT\Key;
use Piges\Auth\AuthenticationHolder;
use Piges\Ucp\Dto\Tenant;
use Piges\Ucp\Dto\Ucp;

class UcpTokenService {

	public function getUcp(string $ucpToken): Ucp {
		$uid = null;
		$tenant = null;
		$permissions = null;
		$eopoos = null;
		{
			$ucpTokenBody = json_decode(base64_decode(str_replace('_', '/', str_replace('-','+',explode('.', $ucpToken)[1]))));

			$uid = $ucpTokenBody->aigUcp->uid;
			
			{
				$tenant = new Tenant();
				$tenant->setName($ucpTokenBody->aigUcp->context->name);
				$tenant->setTenantCode($ucpTokenBody->aigUcp->context->contextCode);
				$tenant->setNameDatabase($ucpTokenBody->aigUcp->context->nameDatabase);
			}
		}
		return new Ucp($uid, $tenant, $ucpTokenBody->aigUcp->permissions, $ucpTokenBody->aigUcp->eopoos);
	}

	public function validateToken(string $ucpToken): bool {
		$ucpTokenHeader = json_decode(base64_decode(str_replace('_', '/', str_replace('-','+',explode('.', $ucpToken)[0]))));
		$key = base64_decode("LS0tLS1CRUdJTiBQVUJMSUMgS0VZLS0tLS0KTUlJQklqQU5CZ2txaGtpRzl3MEJBUUVGQUFPQ0FROEFNSUlCQ2dLQ0FRRUFtekZMckcrbUhhVnd5WUVDY05qSQpFZVM2OFNNOXphbGp3ODlIVW16NUJWdkR2c2ozbmFWcXh2U2UvWHpqREpXcUJjaElrQ3hCWC9ZSU1VU1Rhb3VlCmtxS01VNGdlYjhQNTFSZ2czNkhCVlhyZE5BYURmQjBEb0NjSk1kbDhGODUzSVNrb3padHJjaUFoakxPNlFsUDUKcXBTNDRpUG0yVUxYR1RqZGNPd3Z6S21vY21qL2NZaDQzSUlHbXQxSGltK05WclBVTW5BYXd5emZ6bC9UR3FmSQoxcS9jcGY2OXhCSGpvajZUbGoza3lZazZnUnpBMzJMR0J2VUNHdTlDSlE4RzU0d25QV2EwOFRxMWZRQ1NuM1hkCmgrTjFGSkpFUmNGM1RaeFdqa3dRMmdsbk16MllWOTZ4VEpFVEF4THdQdEF6WDc1bE04cEViK3VML0NVSENTUlgKSndJREFRQUIKLS0tLS1FTkQgUFVCTElDIEtFWS0tLS0t");
		try {
			$jwtClaims = JWT::decode($ucpToken, new Key($key, $ucpTokenHeader->alg));
			
			if($jwtClaims->aigUcp->uid != AuthenticationHolder::getAuthentication()->getId()) {
				throw new Exception("Account and Ucp not match", 401);
			}

			return true;
		} catch (\Throwable $th) {
			return false;
		}		
	}

}