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

	private static function GetAllFiles($dir, $type = 'all') {
		$foundFiles = array_values(array_filter(glob($dir . DIRECTORY_SEPARATOR . ($type === 'php' ? '*.php' : '*')), 'is_file'));

		if ($type === 'misc') {
			$foundCount = count($foundFiles);
			for ($i = 0; $i < $foundCount; $i++) {
				if (substr($foundFiles[$i], -4) === '.php') {
					unset($foundFiles[$i]);
				}
			}
		}

		$dirs = glob($dir . DIRECTORY_SEPARATOR . '*', GLOB_ONLYDIR);

		for ($i = 0; $i < count($dirs); $i++) {
			$newPath = explode(DIRECTORY_SEPARATOR, $dirs[$i]);
			$newPath = $newPath[count($newPath) - 1];
			$foundFiles = array_merge($foundFiles, self::GetAllFiles($dir . DIRECTORY_SEPARATOR . $newPath, $type));
		}

		return $foundFiles;
	}
}