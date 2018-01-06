<?php

abstract class Lesson
{
	private $duration;
	private $costStrategy;

	function __construct($duration, costStrategy $strategy)
	{
		$this->duration = $duration;
		$this->costStrategy = $strategy;
	}

	function cost()
	{
		return $this->costStrategy->cost($this);
	}

	function chargeType()
	{
		return $this->costStrategy->chargeType();
	}

	function getDuration()
	{
		return $this->duration;
	}
}

class Lecture extends Lesson
{

}

class Seminar extends Lesson
{

}

abstract class CostStrategy
{
	abstract function cost(Lesson $lesson);
	abstract function chargeType();
}

class TimedCostStrategy extends CostStrategy
{
	function cost(Lesson $lesson)
	{
		return ($lesson->getDuration() * 5);
	}

	function chargeType()
	{
		return "Hourly payment";
	}
}

class FixedCostStrategy extends CostStrategy
{
	function cost(Lesson $lesson)
	{
		return 30;
	}

	function chargeType()
	{
		return "Fixed rate";
	}
}

class RegistrationMgr
{
	function register(Lesson $lesson)
	{
		$notifier = Notifier::getNotifier();
		$notifier->inform("New lesson: cost - ({$lesson->cost()})");
	}
}

abstract class Notifier
{
	static function getNotifier()
	{
		if (rand(1,2) === 1) {
			return new MailNotifier();
		} else {
			return new TextNotifier();
		}
	}

	abstract function inform($message);
}

class MailNotifier extends Notifier
{
	function inform($message)
	{
		print "Notice by e-mail {$message}\n";
	}
}

class TextNotifier extends Notifier
{
	function inform($message)
	{
		print "Text notification: {$message}\n";
	}
}

/*$lessons[] = new Seminar(4, new TimedCostStrategy());
$lessons[] = new Lecture(4, new FixedCostStrategy());

foreach ($lessons as $lesson) {
	print "Charge for class {$lesson->cost()}. ";
	print "Payment type: {$lesson->chargeType()}\n";
}*/

$lessons1 = new Seminar(4, new TimedCostStrategy());
$lessons2 = new Lecture(4, new FixedCostStrategy());

$mgr = new RegistrationMgr();
$mgr->register($lessons1);
$mgr->register($lessons2);
