<?php

namespace Piges\Auth;

class Authentication {

	private string $id;
	private string $token;
	private Array $authorities;

	function __construct(string $id, string $token, Array $authorities) {
		$this->id = $id;
		$this->token = $token;
		$this->authorities = $authorities;
	}

	public function getId(): string {
		return $this->id;
	}

	public function getToken(): string {
		return $this->token;
	}

	public function getAuthorities(): Array {
		return $this->authorities;
	}
	
}
