<?php

interface IdentityObject
{
	public function generateId();
}

trait TaxTools
{
	function calculateTax($price)
	{
		return 222;
	}
}

/*trait PriceUtilities 
{
	private static $taxrate = 17;

	static function calculateTax($price)
	{
		return ((self::$taxrate/100) * $price);
	}
}*/

trait PriceUtilities{
	public function calculateTax($price)
	{
		return (($this->getTaxRate()/100) * $price);
	}

	abstract function getTaxRate();
}

abstract class Service
{

}

class UtilityService extends Service
{
	use PriceUtilities {
	PriceUtilities::calculateTax as private;
	} 
	/*use PriceUtilities, TaxTools {
	TaxTools::calculateTax insteadof PriceUtilities;
	PriceUtilities::calculateTax as basicTax;
	}*/

	private $price;

	function __construct($price)
	{
		$this->price = $price;
	}

	function getTaxRate()
	{
		return 17;
	}

	function getFinalPrice()
	{
		return ($this->price + $this->calculateTax($this->price));
	}
}

trait IdentityTrait
{
	public function generateId()
	{
		return uniqId();
	}
}

/*$p = new ShopProduct("Missing", "Group", "DDT", 10.99, 5);
print $p->calculateTax(100) . "\n <br />";
print $p->generateId() . "\n <br />";*/

/*$u = new UtilityService();
print $u->calculateTax(100) . "\n";*/

$u = new UtilityService(100);
print $u->getFinalPrice() . "\n";

// print $u::calculateTax(100) . "\n";
// print UtilityService::calculateTax(100) . "\n";

// print $u->basicTax(100) . "\n";