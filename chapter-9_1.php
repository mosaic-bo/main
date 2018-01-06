<?php

abstract class Employee
{
	protected $name;
	private static $types = array('Minion', 'CluedUp', 'WellConnected');

	static function recruit($name)
	{
		$num = rand(1, count(self::$types)) - 1;
		$class = self::$types[$num];
		$f = new $class($name);
		$f->fire();
		return $f;
	}

	function __construct($name)
	{
		$this->name = $name;
	}

	abstract function fire();
}

class Minion extends Employee
{
	function fire()
	{
		print "{$this->name}: remove from the table \n";
	}
}

class WellConnected extends Employee
{
	function fire()
	{
		print "{$this->name}: call papic \n";
	}
}

class NastyBoss
{
	private $employees = array();

	// function addEmployee($employeeName)
	function addEmployee(Employee $employee)
	{
		// $this->employees[] = new Minion($employeeName);
		$this->employees[] = $employee;
	}

	function projectFails()
	{
		if (count($this->employees) > 0) {
			$emp = array_pop($this->employees);
			$emp->fire();
		}
	}
}

class CluedUp extends Employee
{
	function fire()
	{
		print "{$this->name}: call a lawyer\n";
	}
}

/*$boss = new NastyBoss();
$boss->addEmployee("Igor");
$boss->addEmployee("Vladimir");
$boss->addEmployee("Mariya");
$boss->projectFails();*/

/*$boss = new NastyBoss();
$boss->addEmployee(new Minion("Igor"));
$boss->addEmployee(new CluedUp("Vladimir"));
$boss->addEmployee(new Minion("Mariya"));
$boss->projectFails();
$boss->projectFails();
$boss->projectFails();*/

$boss = new NastyBoss();
$boss->addEmployee(Employee::recruit("Igor"));
$boss->addEmployee(Employee::recruit("Vladimir"));
$boss->addEmployee(Employee::recruit("Mariya"));