<?php

namespace CB;

class Program {
	public static function Main($args) {
		\PHPCanner::log(\PHPCanner::NAME . ' version ' . \PHPCanner::VERSION . PHP_EOL);

		CLIArgs::Handle($args);

		if (!file_exists(getcwd() . DIRECTORY_SEPARATOR . '__site.json')) {
			\PHPCanner::end('Missing __site.json!');
		}

		//read json
		$settings = json_decode(file_get_contents(getcwd() . DIRECTORY_SEPARATOR . '__site.json'));

		//validate settings
		//<editor-fold>
		$settingsErrorMessage = [];
		if (!isset($settings->name)) {
			array_push($settingsErrorMessage, 'ERROR: "name" must be set!');
		}
		if (!isset($settings->description)) {
			array_push($settingsErrorMessage, 'ERROR: "description" must be set!');
		}
		if (!isset($settings->outputDirectory)) {
			array_push($settingsErrorMessage, 'ERROR: "outputDirectory" must be set!');
		}
		else{
			if(realpth($settings->outputDirectory) == realpath(\PHPCanner::get_exec_name())){
				array_push($settingsErrorMessage, 'ERROR: "outputDirectory" cannot be the current directory!');
			}
		}
		//</editor-fold>

		//setup output dir
		//<editor-fold>
		if (empty($settingsErrorMessage)) {
			if (!file_exists($settings->outputDirectory)) {
				if (!@mkdir($settings->outputDirectory, 0777, true)) {
					array_push($settingsErrorMessage, 'ERROR: Could not create output directory: ' . $settings->outputDirectory);
				}
			}
		}

		//if alls good precede
		if (empty($settingsErrorMessage)) {
			/*foreach ($settings as $key => $value) {
				$settings->{$key} = str_replace('\'', '\\\'', $value);
			}*/

			Build::Build($settings);
		}
		else {
			\PHPCanner::end(implode(PHP_EOL, $settingsErrorMessage));
		}
		//</editor-fold>
	}
}
