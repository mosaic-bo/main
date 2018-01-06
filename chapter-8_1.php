<?php

abstract class Lesson
{
	protected $duration;
	const FIXED = 1;
	const TIMED = 2;
	private $costtype;

	function __construct($duration, $costtype = 1)
	{
		$this->duration = $duration;
		$this->costtype = $costtype;
	}

	function cost()
	{
		switch ($this->costtype) {
			CASE self::TIMED :
				return (5 * $this->duration);
				break;
			CASE self::FIXED :
				return 30;
				break;
			default:
				$this->costtype = self::FIXED;
				return 30;
		}
	}

	function chargeType()
	{
		switch ($this->costtype) {
			CASE self::TIMED :
				return "Hourly payment";
				break;
			CASE self::FIXED :
				return "Fixed rate";
				break;
			default:
				$this->costtype = self::FIXED;
				return "Fixed rate";
		}
	}
}

class Lecture extends Lesson
{

}

class Seminar extends Lesson
{

}

$lecture = new Lecture(5, Lesson::FIXED);
print "{$lecture->cost()} ({$lecture->chargeType()})\n";

$seminar = new Seminar(3, Lesson::TIMED);
print "{$seminar->cost()} ({$seminar->chargeType()})\n";