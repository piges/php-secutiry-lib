<?php

namespace Piges\Ucp;

use Piges\Ucp\Dto\Ucp;

class UcpHolder {
	
	private static Ucp $ucp;

	public static function getUcp(): Ucp {
		return self::$ucp;
	}

	public static function setUcp(Ucp $ucp) {
		self::$ucp = $ucp;
	}

}