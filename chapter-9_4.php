<?php

abstract class CommsManager
{
	const APPT = 1;
	const TTD = 2;
	const CONTACT = 3;

	abstract function getHeaderText();
	abstract function make($flag_int);
	abstract function getFooterText();
}

class BloggsCommsManager extends CommsManager
{
	function getHeaderText()
	{
		return "BloggsCal page header\n";
	}

	function make($flag_int)
	{
		switch ($flag_int) {
			CASE self::APPT:
				return new BloggsApptEncoder();
			CASE self::CONTACT:
				return new BloggsContactEncoder();
			CASE self::TTD:
				return new BloggsTtdEncoder();
		}
	}

	function getFooterText()
	{
		return "BloggsCal footer\n";
	}
}

$mrg = new BloggsCommsManager();
print $mrg->getHeaderText();
print $mrg->make(1);
print $mrg->getFooterText();