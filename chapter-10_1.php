<?php

abstract class Unit
{
	function getComposite()
	{
		return null;
	}

	abstract function bombardStrength();

	function addUnit(Unit $unit)
	{
		throw new UnitException(get_class($this) . "refers to 'leaves'");
	}

	function removeUnit(Unit $unit)
	{
		throw new UnitException(get_class($this) . "refers to 'leaves'");
	}
}

abstract class CompositeUnit extends Unit
{
	private $units = array();

	function getComposite()
	{
		return $this;
	}

	protected function units()
	{
		return $this->units;
	}

/*	function removeUnit(Unit $unit)
	{
		$this->units = array_udiff($this->units, array($unit),
						function($a, $b) {return ($a === $b)?0:1;});
	}

	function addUnit(Unit $unit)
	{
		if (in_array($unit, $this->units, true)) {
			return;
		}
		$this->units[] = $unit;
	}*/
}

class UnitException extends Exception {}

class Archer extends Unit
{
	function bombardStrength()
	{
		return 4;
	}
}

class LaserCannonUnit extends Unit
{
	function bombardStrength()
	{
		return 44;
	}
}

class Army extends Unit
{
	private $units = array();

	function addUnit(Unit $unit)
	{
		// array_push($this->armies, $army);
		if (in_array($unit, $this->units, true)) {
			return;
		}
		$this->units[] = $unit;
	}

	function removeUnit(Unit $unit)
	{
		$this->units = array_udiff($this->units, array($unit),
				function($a, $b) {return ($a === $b)?0:1;}
				);
	}

	function bombardStrength()
	{
		$ret = 0;
		foreach ($this->units as $unit) {
			$ret += $unit->bombardStrength();
		}

/*		foreach ($this->armies as $army) {
			$ret += $army->bombardStrenght();
		}*/
		return $ret;
	}
}

$main_army = new Army();

$main_army->addUnit(new Archer());
$main_army->addUnit(new LaserCannonUnit());

$sub_army = new Army();
$sub_army->addUnit(new Archer());
$sub_army->addUnit(new Archer());
$sub_army->addUnit(new Archer());

$main_army->addUnit($sub_army);

print "Attacking force: {$main_army->bombardStrength()}\n";