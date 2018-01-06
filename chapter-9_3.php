<?php

abstract class ApptEncoder
{
	abstract function encode();
}

class BloggsApptEncoder extends ApptEncoder
{
	function encode()
	{
		return "The meeting data is encoded in the format BloggsCal \n";
	}
}

abstract class CommsManager
{
	abstract function getHeaderText();
	abstract function getApptEncoder();
	abstract function getFooterText();
}

class BloggsCommsManager extends CommsManager
{
	function getHeaderText()
	{
		return "BloggsCal page header \n";
	}

	function getApptEncoder()
	{
		return new BloggsApptEncoder();
	}

	function getFooterText()
	{
		return "BloggsCal footer \n";
	}
}

$mrg = new BloggsCommsManager();
print $mrg->getHeaderText();
print $mrg->getApptEncoder()->encode();
print $mrg->getFooterText();
