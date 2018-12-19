<?php

namespace DN;

class File{
	public static function rcopy($sourceDirectory, $newDirectory){
		$sourceDirectory = realpath($sourceDirectory);

		if(!is_dir($sourceDirectory)){return false;}

		if(!is_dir($newDirectory)){
			if(!mkdir($newDirectory)){
				return false;
			}
		}

		$newDirectory = realpath($newDirectory);

		$files = array_values(array_filter(glob($sourceDirectory . DIRECTORY_SEPARATOR . '*'), 'is_file'));
		foreach ($files as $file){
			$file = basename($file);

			if(!copy($sourceDirectory . DIRECTORY_SEPARATOR . $file, $newDirectory . DIRECTORY_SEPARATOR . $file)){
				return false;
			}
		}

		$dirs = glob($sourceDirectory . DIRECTORY_SEPARATOR . '*', GLOB_ONLYDIR);
		foreach ($dirs as $dir){
			$dir = basename($dir);

			return self::rcopy($sourceDirectory . DIRECTORY_SEPARATOR . $dir, $newDirectory . DIRECTORY_SEPARATOR . $dir);
		}

		return true;
	}

	public static function rglob($directory, $pattern = '*'){
		$foundFiles = array_values(array_filter(glob($directory . DIRECTORY_SEPARATOR . $pattern), 'is_file'));

		$dirs = glob($directory . DIRECTORY_SEPARATOR . '*', GLOB_ONLYDIR);

		for ($i = 0; $i < count($dirs); $i++) {
			$newPath = explode(DIRECTORY_SEPARATOR, $dirs[$i]);
			$newPath = $newPath[count($newPath) - 1];
			$foundFiles = array_merge($foundFiles, self::rglob($directory . DIRECTORY_SEPARATOR . $newPath, $pattern));
		}

		return $foundFiles;
	}
}
