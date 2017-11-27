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

class BookProduct extends ShopProduct
{
	private $numPages = 0;

	public function __construct($title, $firstName, $mainName, $price, $numPages) 
	{
		parent::__construct($title, $firstName, $mainName, $price);
		$this->numPages = $numPages;
	}

	function getNumberOfPages()
	{
		return $this->numPages;
	}

	function getSummaryLine()
	{
		// $base = "{$this->title} ({$this->producerMainName}, ";
		// $base .= "{$this->producerFirstName}) ";
		$base = parent::getSummaryLine();
		$base .= ": {$this->numPages} p.";
		return $base;
	}
}

class ShopProductWriter
{
	private $products = array();

	public function addProduct(ShopProduct $shopProduct)
	{
		$this->products[] = $shopProduct;
	}
	
	public function write()
	{
		
		/*$str = "{$shopProduct->title}: "
			. $shopProduct->getProducer()
			. "({$shopProduct->price})\n";*/

		$str = "";
		foreach ($this->products as $shopProduct) {
			$str .= "{$shopProduct->title}: ";
			$str .= $shopProduct->getProducer();
			$str .= "({$shopProduct->getPrice()})\n";
		}
		print $str;
	}
}

// $product1 = new shopProduct();
// $product2 = new shopProduct();
// $product1->title = "Dog's heart";
// $product1->producerMainName = "Bulgakov";
// $product1->producerFirstName = "Mikhail";
// $product1->price = 5.99;

// $product2->title = "Inspector";

// print "Author: {$product1->producerFirstName} "
// 		. "{$product1->producerMainName}\n";

$product1 = new shopProduct("Dog's heart", "Mikhail", "Bulgakov", 5.99);
$product2 = new CDProduct("Missing", "Group", "DDT", 10.99, 5);

// print "Author: {$product1->getProducer()}\n";

$writer = new ShopProductWriter();
$writer->write($product1);

// print "Author: " . $product1->getProducer() . "\n";
// print "Singer: " . $product2->getProducer() . "\n";
// print "Price - {$product1->getPrice()}\n";
