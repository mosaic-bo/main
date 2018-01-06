<?php

abstract class Tile
{
	abstract function getWealthFactor();
}

class Plains extends Tile
{
	private $wealthFactor = 2;

	function getWealthFactor()
	{
		return $this->wealthFactor;
	}
}

abstract class TileDecorator extends Tile
{
	protected $tile;

	function __construct(Tile $tile)
	{
		$this->tile = $tile;
	}
}

class DiamondDecorator extends TileDecorator
{
	function getWealthFactor()
	{
		return $this->tile->getWealthFactor() + 2;
	}
}

class PollutionDecorator extends TileDecorator
{
	function getWealthFactor()
	{
		return $this->tile->getWealthFactor() - 4;
	}
}

class RequestHelper{}

abstract class ProcessRequest
{
	abstract function process(RequestHelper $req);
}

class MainProcess extends ProcessRequest
{
	function Process(RequestHelper $req)
	{
		print __CLASS__ . ": query execution \n";
	}
}

abstract class DecorateProcess extends ProcessRequest
{
	protected $processRequest;

	function __construct(ProcessRequest $pr)
	{
		$this->processRequest = $pr;
	}
}

class LogRequest extends DecorateProcess
{
	function process(RequestHelper $req)
	{
		print __CLASS__ . ": registration request \n";
		$this->processRequest->process($req);
	}
}

class AuthenticateRequest extends DecorateProcess
{
	function process(RequestHelper $req)
	{
		print __CLASS__ . ": request authentication \n";
		$this->processRequest->process($req);
	}
}

class StructureRequest extends DecorateProcess
{
	function process(RequestHelper $req)
	{
		print __CLASS__ . ": ordering query data \n";
		$this->processRequest->process($req);
	}
}

$tile1 = new Plains();
print $tile1->getWealthFactor();

$tile2 = new DiamondDecorator(new Plains());
print $tile2->getWealthFactor();

$tile3 = new PollutionDecorator(
			new DiamondDecorator(new Plains())	
			);
print $tile3->getWealthFactor();

$process = new AuthenticateRequest(
				new StructureRequest(
					new LogRequest(
						new MainProcess()
			)));
$process->process(new RequestHelper());