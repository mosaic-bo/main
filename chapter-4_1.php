<?php

// class StaticExample
// {
// 	static public $aNum = 0;

// 	static public function sayHello()
// 	{
// 		self::$aNum++;
// 		print "Hello (" . self::$aNum . ")\n";
// 	}
// }

// // print StaticExampe::$aNum;
// StaticExample::sayHello();

class ShopProduct implements IdentityObject
{
	use PriceUtilities, IdentityTrait;
	private $id = 0;
	protected $title = "Standard goods";
	private $producerMainName = "Surname of the author";
	private $producerFirstName = "Author's name";
	protected $price = 0;
	private $discount = 2;

	function __construct($title, $firstName, $mainName, $price)
	{
		$this->title = $title;
		$this->producerFirstName = $firstName;
		$this->producerMainName = $mainName;
		$this->price = $price;
	}

	public function setDiscount($num)
	{
		$this->discount = $num;
	}

	function getPrice()
	{
		return ($this->price - $this->discount);
	}

	public function getTitle()
	{
		return $this->title;
	}

	function getSummaryLine()
	{
		$base = "$this->title({$this->producerMainName}, ";
		$base .= "{$this->producerFirstName})";
		return $base;
	}

	public function setId($id)
	{
		$this->id = $id;
	}

	public static function getInstance($id, PDO $pdo)
	{
		$stmt = $pdo->prepare("SELECT * FROM products WHERE id=?");
		$result = $stmt->execute(array ($id));

		$row = $stmt->fetch();

		if (empty($row)) {
			return NULL;
		}

		if ($row['type'] === "book") {
			$product = new BookProduct(
				$row['title'],
				$row['firstname'],
				$row['mainname'],
				$row['price'],
				$row['numpages']
			);
		} else {
			if ($row['type'] === "cd") {
				$product = new CDProduct(
										$row['title'],
										$row['firstname'],
										$row['mainname'],
										$row['price'],
										$row['playlength']
				);
			} else {
				$product = new ShopProduct(
										$row['title'],
										$row['firstname'],
										$row['mainname'],
										$row['price']
				);
			}
			$product->setId($row['id']);
			$product->setDiscount($row['discount']);
			
		}
		// return $product;
		print $product->getSummaryLine();	
	}

	function storeIdentityObject(IdentityObject $idObj)
	{
		
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

abstract class ShopProductWriter
{
	protected $products = array();

	public function addProduct(ShopProduct $shopProduct)
	{
		$this->products[] = $shopProduct;
	}
	
	abstract public function write();
}

class XmlProductWriter extends ShopProductWriter
{
	public function write()
	
	{

		$writer = new XMLWriter();
		$writer->openMemory();
		$writer->startDocument('1.0', 'UTF-8');
		$writer->startElement("products");

		foreach ($this->products as $shopProduct) {
			$writer->startElement("product");
			$writer->writeAttribute("title", $shopProduct->getTitle());
			$writer->startElement("h1");
			$writer->text($shopProduct->getSummaryLine());
			$writer->endElement(); // h1
			$writer->endElement(); // product
		}

		$writer->endElement(); // product
		$writer->endDocument();
		print $writer->flush();
	}
}

class TextProductWriter extends ShopProductWriter
{
	public function write()
	{
		$str = "GOODS:\n";
		foreach ($this->products as $shopProduct) {
			$str .= $shopProduct->getSummaryLine()."\n";
		}
		print $str;
	}
}

/*$pdo = new PDO('mysql:host=localhost;dbname=test', 'root', '');
$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
$obj = ShopProduct::getInstance(2, $pdo);*/

$product1 = new ShopProduct("Dog's heart", "Mikhail", "Bulgakov", 5.99);
// $product2 = new CDProduct("Missing", "Group", "DDT", 10.99, 5);

$result = new XmlProductWriter();
$result->addProduct($product1);
$result->write();