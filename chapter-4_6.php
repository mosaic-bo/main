<?php

class Person
{
	/*private $_name;
	private $_age;
	private $writer;*/

	private $name;
	private $age;
	private $id;
	public $account;

	function __construct($name, $age, Account $account)
	{
		$this->name = $name;
		$this->age = $age;
		$this->account = $account;
	}

	function getName()
	{
		return "Ivan";
	}

	function getAge()
	{
		return "45";
	}

	function setId($id)
	{
		$this->id = $id;
	}

	function __clone()
	{
		$this->id = 0;
		$this->account = clone $this->account;
	}

	function __toString()
	{
		$desc = $this->getName();
		$desc .= " (Age " . $this->getAge() . " years)";
		return $desc;
	}
}

class Account
{
	public $balance;

	function __construct($balance)
	{
		$this->balance = $balance;
	}
}

$person = new Person("Ivan", 44, new Account(200));

/*$person->setId(343);
$person2 = clone $person;
$person->account->balance += 10;
print $person2->account->balance;*/

print $person;