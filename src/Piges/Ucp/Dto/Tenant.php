<?php

namespace Piges\Ucp\Dto;

class Tenant {
	
	private string $name;

	private string $tenantCode;

	private string $nameDatabase;

	public function getName(): string {
		return $this->name;
	}

	public function setName(string $name): void {
		$this->name = $name;
	}

	public function getTenantCode(): string {
		return $this->tenantCode;
	}

	public function setTenantCode(string $tenantCode): void {
		$this->tenantCode = $tenantCode;
	}

	public function getNameDatabase(): string {
		return $this->nameDatabase;
	}

	public function setNameDatabase(string $nameDatabase): void {
		$this->nameDatabase = $nameDatabase;
	}

	public function toString(): string {
		$sb = "";
	    $sb =+ "class AigTenant {\n";
	    $sb =+ "    name: "+$this->name+"\n";
	    $sb =+ "    tenantCode: "+$this->tenantCode+"\n";
	    $sb =+ "    nameDatabase: "+$this->nameDatabase+"\n";
	    $sb =+ "}";
	    return $sb;
	}
}
