<?php

class ShopProduct 
{
	private $title = "Standard goods";
	private $producerMainName = "Surname of the author";
	private $producerFirstName = "Author's name";
	protected $price = 0;
	protected $discount = 0;

	function __construct($title, $firstName, $mainName, $price)
	{
		$this->title = $title;
		$this->producerFirstName = $firstName;
		$this->producerMainName = $mainName;
		$this->price = $price;
	}

	function getProducer()
	{
		return "{$this->producerFirstName} "
				. "{$this->producerMainName}";
	}

	function getSummaryLine()
	{
		$base = "$this->title({$this->producerMainName}, ";
		$base .= "{$this->producerFirstName})";
		return $base;
	}

	function setDiscount($num)
	{
		$this->discount = $num;
	}

	function getPrice()
	{
		return ($this->price - $this->discount);
	}
}

class CDProduct extends ShopProduct
{
	private $playLength = 0;

	public function __construct($title, $firstName, $mainName, $price, $playLength)
	{
		parent::__construct($title, $firstName, $mainName, $price);
		$this->playLength = $playLength;
	}

	function getPlayLength()
	{
		return $this->playLength;
	}

	function getSummaryLine()
	{
		$base = "{$this->title} ({$this->producerMainName}, ";
		$base .= "{$this->producerFirstName}) ";
		$base .= "Playing time - {$this->playLength}";
		return $base;
	}
}

/*function classData(ReflectionClass $class)
{
	$details = "";
	$name = $class->getName();
	if ($class->isUserDefined()) {
		$details .= "$name -- class is determined by the user\n";
	}

	if ($class->isInternal()) {
		$details .= "$name -- built-in class\n";
	}

	if ($class->isInterface()) {
		$details .= "$name -- this interface\n";
	}

	if ($class->isAbstract()) {
		$details .= "$name -- this is an abstract class\n";
	}

	if ($class->isFinal()) {
		$details .= "$name -- this is a final class\n";
	}

	if ($class->isInstantiable()) {
		$details .= "$name -- you can instantiate a class\n";
	} else {
		$details .= "$name -- can not instantiate a class\n";
	}

	if ($class->isCloneable()) {
		$details .= "$name -- can be cloned\n";
	} else {
		$details .= "$name -- can not be cloned\n";
	}

	return $details;
}

$prod_class = new ReflectionClass('CDProduct');
print classData($prod_class);*/

class ReflectionUtil
{
	static function getClassSource(ReflectionClass $class)
	{
		$path = $class->getFileName();
		$lines = @file($path);
		$from = $class->getStartLine();
		$to = $class->getEndLine();
		$len = $to - $from + 1;
		return implode(array_slice($lines, $from - 1, $len));
	}
}

print ReflectionUtil::getClassSource(
									new ReflectionClass('CDProduct'));

