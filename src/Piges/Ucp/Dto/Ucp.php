<?php

namespace Piges\Ucp\Dto;

class Ucp {
	
	private string $uid;
	private Tenant $tenant;
	private Array $permissions;
	private Array $eopoos;

	function __construct(string $uid, Tenant $tenant, Array $permissions, Array $eopoos) {
		$this->uid = $uid;
		$this->tenant = $tenant;
		$this->permissions = $permissions;
		$this->eopoos = $eopoos;
	}

	public function getUid(): string {
		return $this->uid;
	}

	public function getTenant(): Tenant {
		return $this->tenant;
	}

	public function getPermissions(): Array {
		return $this->permissions;
	}
	
	public function getEopoos(): Array {
		return $this->eopoos;
	}
	
}
