<?php

class AigContext {
	
	private string $name;

	private string $contextCode;

	private string $nameDatabase;

	public function getName(): string {
		return $this->name;
	}

	public function setName(string $name): void {
		$this->name = $name;
	}

	public function getContextCode(): string {
		return $this->contextCode;
	}

	public function setContextCode(string $contextCode): void {
		$this->contextCode = $contextCode;
	}

	public function getNameDatabase(): string {
		return $this->nameDatabase;
	}

	public function setNameDatabase(string $nameDatabase): void {
		$this->nameDatabase = $nameDatabase;
	}

	public function toString(): string {
		$sb = "";
	    $sb =+ "class AigContext {\n";
	    $sb =+ "    name: "+$this->name+"\n";
	    $sb =+ "    contextCode: "+$this->contextCode+"\n";
	    $sb =+ "    nameDatabase: "+$this->nameDatabase+"\n";
	    $sb =+ "}";
	    return $sb;
	}
}
