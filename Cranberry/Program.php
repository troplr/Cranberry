<?php

namespace CB;

use CB\Website\DynamicContent\Variable;

class Program {
	public static function Main(array $cliArgs) {
		$f = new Variable('TEST', function (){return 'AAA';});
		\PHPCanner::log('Test should say AAA: ' . $f->Filter('{{TEST}}'));
		\PHPCanner::end('Hello world!');
	}
}
