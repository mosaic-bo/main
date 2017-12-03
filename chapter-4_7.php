<?php

class Product
{
	public $name;
	public $price;

	function __construct($name, $price)
	{
		$this->name = $name;
		$this->price = $price;
	}
}

class ProcessSale
{
	private $callbacks;

	function registerCallback($callback)
	{
		if (!is_callable($callback)) {
			throw new Exception("Callback function unavailable!");
		}

		$this->callbacks[] = $callback;
	}

	function sale($product)
	{
		print "{$product->name}: processed... <br />";

		foreach ($this->callbacks as $callback) {
			call_user_func($callback, $product);
		}
	}
}

$logger = function($product)
{
	print "write down... ({$product->name}) <br />";
};

/*$logger = function($product)
{
	print "{$product->price}";
};*/

$processor = new ProcessSale();
$processor->RegisterCallback($logger);

$processor->sale(new Product("Shoes", 6));
print '<br />';
$processor->sale(new Product("Coffee", 7));