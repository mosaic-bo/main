<?php

abstract class Expression
{
	private static $keyCount = 0;
	private $key;

	abstract function interpret(InterpreterContext $context);

	function getKey()
	{
		if (!isset($this->key)) {
			self::$keyCount++;
			$this->key = self::$keyCount;
		}
		return $this->key;
	}
}

class LiteralExpression extends Expression
{
	private $value;

	function __construct($value)
	{
		$this->value = $value;
	}

	function interpret(InterpreterContext $context)
	{
		$context->replace($this, $this->value);
	}
}

class VariableExpression extends Expression
{
	private $name;
	private $val;

	function __construct($name, $val = null)
	{
		$this->name = $name;
		$this->val = $val;
	}

	function interpret(InterpreterContext $context)
	{
		if (!is_null($this->val)) {
			$context->replace($this, $this->val);
			$this->val = null;
		}
	}

	function setValue($value)
	{
		$this->val = $value;
	}

	function getKey()
	{
		return $this->name;
	}
}

class InterpreterContext
{
	private $expressionStore = array();

	function replace(Expression $exp, $value)
	{
		$this->expressionStore[$exp->getKey()] = $value;
	}

	function lookup(Expression $exp)
	{
		return $this->expressionStore[$exp->getKey()];
	}
}

abstract class OperatorExpression extends Expression
{
	protected $l_op;
	protected $r_op;

	function __construct(Expression $l_op, Expression $r_op)
	{
		$this->l_op = $l_op;
		$this->r_op = $r_op;
	}

	function interpret(InterpreterContext $context)
	{
		$this->l_op->interpret($context);
		$this->r_op->interpret($context);
		$result_l = $context->lookup($this->l_op);
		$result_r = $context->lookup($this->r_op);
		$this->doInterpret($context, $result_l, $result_r);
	}

	protected abstract function doInterpret(InterpreterContext $context, $result_l, $result_r);
}

class EqualsExpression extends OperatorExpression
{
	protected function doInterpret(InterpreterContext $context,
									$result_l, $result_r)
	{
		$context->replace($this, $result_l == $result_r);
	}
}

class BoleanOrExpression extends OperatorExpression
{
	protected function doInterpret(InterpreterContext $context,
									$result_l, $result_r)
	{
		$context->replace($this, $result_l || $result_r);
	}
}

class BoleanAndExpression extends OperatorExpression
{
	protected function doInterpret(InterpreterContext $context,
									$result_l, $result_r)
	{
		$context->replace($this, $result_l && $result_r);
	}
}

/*$context = new InterpreterContext();
$literal = new LiteralExpression('Four');
$literal->interpret($context);
print $context->lookup($literal) . "\n";*/

/*$context = new InterpreterContext();
$myvar = new VariableExpression('input', 'Four');
$myvar->interpret($context);
print $context->lookup($myvar) . "\n";

$newvar = new VariableExpression('input');
$newvar->interpret($context);
print $context->lookup($newvar) . "\n";

$myvar->setValue("Five");
$myvar->interpret($context);
print $context->lookup($myvar) . "\n";
print $context->lookup($newvar) . "\n";
*/

$context = new InterpreterContext();
$input = new VariableExpression('input');
$statement = new BoleanOrExpression(
	new EqualsExpression($input, new LiteralExpression('Four')),
	new EqualsExpression($input, new LiteralExpression('4'))
	);

foreach (array("Four", "4", "52") as $val) {
	$input->setValue($val);
	print "$val:\n";
	$statement->interpret($context);
	if ($context->lookup($statement)) {
		print "matches \n\n";
	} else {
		print "does not matches \n\n";
	}
}