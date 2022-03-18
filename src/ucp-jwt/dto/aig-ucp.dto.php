<?php

class AigUcp {
	
	private string $uid;

	private AigContext $context;

	private Array $permissions;

	private Array $eopoos;

	public function getUid(): string {
		return $this->uid;
	}

	public function setUid(String $uid): void {
		$this->uid = $uid;
	}
	
	public function getContext(): AigContext {
		return $this->context;
	}
	
	public function setContext(AigContext $context): void {
		$this->context = $context;
	}
	public function getPermissions(): Array {
		return $this->permissions;
	}
	
	public function setPermissions(Array $permissions): void {
		$this->permissions = $permissions;
	}
	
	public function getEopoos(): Array {
		return $this->eopoos;
	}
	
	public function setEopoos(Array $eopoos): void {
		$this->eopoos = $eopoos;
	}
	
	public function toString(): string {
		$sb = "";
	    $sb += "class AigUcp {\n";
	    $sb += "    uid: " + $this->uid + "\n";
	    $sb += "    context: " + $this->context->toString() + "\n";
	    $sb += "    permissions: " + $this->permissions + "\n";
	    $sb += "    permissions: " + $this->eopoos + "\n";
	    $sb += "}";
	    return $sb;
	}
}
