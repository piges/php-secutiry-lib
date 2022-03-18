<?php

namespace Piges\Auth\Token;

use CoderCat\JWKToPEM\JWKConverter;
use Exception;

class RemoteJwkSigningKeyResolver {

	private static $keysHolder = Array();

	public static function GetKey(string $accessToken): string {
		$accessTokenHeader = json_decode(base64_decode(str_replace('_', '/', str_replace('-','+',explode('.', $accessToken)[0]))));
		
		$key = self::$keysHolder[$accessTokenHeader->kid];

		if($key == null) {
			$accessTokenBody = json_decode(base64_decode(str_replace('_', '/', str_replace('-','+',explode('.', $accessToken)[1]))));
			$jwksUrl = $accessTokenBody->iss + "/.well-known/jwks.json";

			self::updateKeys($jwksUrl);
		}
		
		if(self::$keysHolder[$accessTokenHeader->kid] == null ) {
			throw new Exception("accessToken not valid", 401);
		}

		return self::$keysHolder[$accessTokenHeader->kid];
	}

	private static function updateKeys(string $jwksUrl) {
		// TODO remote call
		$responseString = '{"keys":[{"alg":"RS256","e":"AQAB","kid":"4gK8AS5LAbEiT1Zz22GqwVcLD3bPZCTI32pFcvamxbY=","kty":"RSA","n":"4WTdINuwPOvVT0lI4I8Gtt5XNTb5SZnKS64LStEsh4RoB4vbNWL9TiKd7AVDYlYcwChni70--hIB0iNi7hFPtz5ekFGRl_CDvbN3S0lYTVCCH9xVELXjZBtw2PM7pHE-BdLQML7LngCy1DQ8Rir-vReqdbBNWgshiAKDnIRXd06VXc2tbOfLP9o0uGFMgO21oORgkH7yZJJGadxQsZeqHIfagsSoyHYNDCIZ5mU7pXxt4LY0bogSNSd_StMKrAxevpoZXxM6M4ar_ENelk1syNIGTMgZOrcKoC-dRkoY3DuZRyhD_hEn0_SUKC--hNg2XMuZEo7kco-1lFbrB6NAXQ","use":"sig"},{"alg":"RS256","e":"AQAB","kid":"kW2F9wvACr+Ch+RR6ckgjDywFLhwHTeFeP1z9UxOzoY=","kty":"RSA","n":"wHzBunoT8yEqK-kjyN5JzhankueIALejP1vJeBSG0ur19OlW8oYwbRNWLPpXKMkemMj8Ood-RJo2iHuIvtOAbNTQGGpMCTEREXwwr7PM6Ov8Rs-bnsqpaJzAKOJlJfJuZzXTJmWSQecW2S4Gr4rz6nQ0ptsFxXKHl1DxFTvHElyOYrxLcZDAZy_g9NCAQzOMU3ZPwT-pA618xskUTv4acCbMaOIE3XYy9cGisLeXRoq6g4Ab0h3Tl5p2Ht9nUZHR3QBFNed4Sbkn5jeW8YNpWsbX87ZkJkQ1C6ooZA1OZ_jPV4J6CgBgQ-XSZwKU_79oqa2K_2Gam0PF21f9On84nQ","use":"sig"}]}';
		$response = json_decode($responseString, true);

		$jwkConverter = new JWKConverter();
		foreach ($response['keys'] as $i => $JWK) {
			$PEM = $jwkConverter->toPEM($JWK);
			self::$keysHolder[$JWK['kid']] = $PEM;
		}
	}

}