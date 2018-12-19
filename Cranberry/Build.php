<?php

namespace CB;

class Build {
	public static function Build($settings) {
		\PHPCanner::log('Beginning build of "' . $settings->name . '".');

		if (!chdir(getcwd())) {
			\PHPCanner::end('ERROR: Could not chdir into current directory!');
		}

		//stuff

		//finalize
		\PHPCanner::end(PHP_EOL . 'Successfully build website!');
	}
}
