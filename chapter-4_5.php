<?php

class Person
{
	/*private $_name;
	private $_age;
	private $writer;*/

	private $name;
	private $age;
	private $id;

/*	function __get($property)
	{
		$method = "get{$property}";
		if (method_exists($this, $method)) {
			return $this->$method();
		}
	}

	function getName()
	{
		return "Ivan";
	}

	function getAge()
	{
		return "45";
	}

	function __set($property, $value)
	{
		$method = "set{$property}";
		if (method_exists($this, $method)) {
			return $this->$method($value);
		}
	}

	function setName($name)
	{
		$this->_name = $name;
		if (!is_null($name)) {
			print $this->_name = strtoupper($this->_name);
		}
	}

	function setAge($age)
	{
		$this->_age = strtoupper($age);
	}

	function __construct(PersonWriter $writer)
	{
		$this->writer = $writer;
	}

	function __call($methodname, $args)
	{
		if (method_exists($this->writer, $methodname)) {
			return $this->writer->$methodname($this);
		}
	}
*/

	function __construct($name, $age)
	{
		$this->name = $name;
		$this->age = $age;
	}

	function setId($id)
	{
		$this->id = $id;
	}

	/*function __destruct()
	{
		if (!empty($this->id)) {
			print "Object preservation person";
		}
	}*/

	function __clone()
	{
		$this->id = 0;
	}
}

/*class PersonWriter
{
	function writeName(Person $p)
	{
		print $p->getName() . "\n";
	}

	function writeAge(Person $p)
	{
		print $p->getAge() . "\n";
	}
}*/



/*class Address
{
	private $number;
	private $street;

	function __construct($mayBeNumber, $mayBeStreet=null)
	{
		if (is_null($mayBeStreet)) {
			$this->streetAddress = $mayBeNumber;
		} else {
			$this->number = $mayBeNumber;
			$this->street = $mayBeStreet;
		}
	}

	function __set($property, $value)
	{
		if ($property === "streetAddress") {
			if (preg_match("/^(\d+.*?)[\s,]+(.+)$/", $value, $matches)) {
				$this->number = $matches[1];
				$this->street = $matches[2];
			} else {
				throw new Exception("Error in address: '{$value}'");
			}
		}
	}

	function __get($property)
	{
		if ($property === "streetAddress") {
			return $this->number . " " . $this->street;
		}
	}
}*/

// setLocale(LC_ALL, "ru-RU.CP1251");
// $p = new Person();

// print $p->name;

// $p->name = "Ivan";

/*$person = new Person(new PersonWriter());
$person->writeName();

/*$address = new Address("441b Bakers Street");
print "Address: {$address->streetAddress} <br />";

$address = new Address(15, "Albert Mews");
print "Address: {$address->streetAddress} <br />";

$address->streetAddress = "34, West 24th Avenue";
print "Address: {$address->streetAddress} <br />";
print_r($address);*/

$person = new Person("Ivan", 44);
$person->setId(343);
// unset($person);

$person2 = clone $person;
print_r($person2);