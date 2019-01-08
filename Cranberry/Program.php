<?php

namespace CB;

use CB\Website\DynamicContent\Variable;

class Program {
	public static function Main(array $cliArgs) {
		$f = new Variable('TEST', function (){return date(DATE_ISO8601);});
		\PHPCanner::log($f->Filter('Today is \{{TEST}} - {{TEST}}'));
		\PHPCanner::end('Hello world!');
	}
}
