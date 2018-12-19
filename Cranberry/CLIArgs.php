<?php

namespace CB;

class CLIArgs {
	public static function Handle($args) {
		if (count($args) > 1) {
			switch ($args[1]) {
				case 'build':
					break;

				case 'init':
					self::Init($args);
					break;

				case 'about':
					self::About();
					break;

				case 'info':
					self::About();
					break;

				case 'license':
					self::License(false);
					break;

				case 'license-full':
					self::License(true);
					break;

				case 'update':
					self::Update();
					break;

				default:
					self::Help();
					break;
			}
		}
		else {
			self::Help();
		}
	}

	private static function Init($args) {
		if (isset($args[2])) {
			if (file_exists($args[2])) {
				if (!chdir($args[2])) {
					\PHPCanner::end('ERROR: Could not chdir into directory ' . $args[2]);
				}
			}
			else {
				if (!@mkdir($args[2]) || !chdir($args[2])) {
					\PHPCanner::end('ERROR: Could not create directory ' . $args[2]);
				}
			}
		}

		if (!file_exists('__site.json')) {
			if (mkdir('__cb') &&
				mkdir('__cb' . DIRECTORY_SEPARATOR . 'assets') &&
				mkdir('__cb' . DIRECTORY_SEPARATOR . 'assets' . DIRECTORY_SEPARATOR . 'themes') &&
				mkdir('__cb' . DIRECTORY_SEPARATOR . 'layouts') &&
				mkdir('__cb' . DIRECTORY_SEPARATOR . 'scripts') &&
				file_put_contents('__site.json', \PHPCanner::get_file('default/__site.json')) &&
				file_put_contents('__cb' . DIRECTORY_SEPARATOR . 'assets' . DIRECTORY_SEPARATOR . 'themes' . DIRECTORY_SEPARATOR . 'default.css', \PHPCanner::get_file('default/__cb/assets/themes/default.css')) &&
				file_put_contents('__cb' . DIRECTORY_SEPARATOR . 'layouts' . DIRECTORY_SEPARATOR . 'default.html', \PHPCanner::get_file('default/__cb/layouts/default.html')) &&
				file_put_contents('__cb' . DIRECTORY_SEPARATOR . 'scripts' . DIRECTORY_SEPARATOR . 'cb.js', \PHPCanner::get_file('default/__cb/scripts/cb.js')) &&
				file_put_contents('index.md', \PHPCanner::get_file('default/index.md'))) {

				/* ====
				 * THEN
				 * ====
				 */

				if (file_put_contents('.gitignore', '# Cranberry build directory' . PHP_EOL . '__out/' . PHP_EOL, FILE_APPEND)) {
					\PHPCanner::log('Added __out/ to .gitignore');
				}
				else {
					\PHPCanner::end('ERROR: Could not write to .gitignore (write error)!');
				}
				\PHPCanner::end('Initialized new website in ' . getcwd());
			}
			else {
				\PHPCanner::end('ERROR: Could not create new website (write error)!');
			}
		}
		else {
			\PHPCanner::end('ERROR: Website already exists in ' . getcwd());
		}
	}

	private static function About() {
		\PHPCanner::end(\PHPCanner::DESCRIPTION . PHP_EOL . PHP_EOL . 'A project by:' . PHP_EOL . \PHPCanner::CONTRIBUTORS . PHP_EOL . PHP_EOL . 'Use the license command to see the license.');
	}

	private static function License($full = false) {
		if (!$full) {
			\PHPCanner::end(\PHPCanner::LICENSE);
		}
		else {
			\PHPCanner::end('MIT License' . PHP_EOL . '' . PHP_EOL .

				'Copyright (c) 2018 Max Loiacono' . PHP_EOL . '' . PHP_EOL .

				'Permission is hereby granted, free of charge, to any person obtaining a copy' .
				'of this software and associated documentation files (the "Software"), to deal' .
				'in the Software without restriction, including without limitation the rights' .
				'to use, copy, modify, merge, publish, distribute, sublicense, and/or sell' .
				'copies of the Software, and to permit persons to whom the Software is' .
				'furnished to do so, subject to the following conditions:' . PHP_EOL . '' . PHP_EOL .

				'The above copyright notice and this permission notice shall be included in all' .
				'copies or substantial portions of the Software.' . PHP_EOL . '' . PHP_EOL .

				'THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR' .
				'IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,' .
				'FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE' .
				'AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER' .
				'LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,' .
				'OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN THE' .
				'SOFTWARE.');
		}
	}

	private static function Help() {
		if (file_exists('/usr/bin/wget')) {
			$remote = [];
			exec('wget -T 0.34 -qO- https://raw.githubusercontent.com/itsmaxymoo/Cranberry/master/pcan.json | cat', $remote);
			$remote = json_decode(implode(PHP_EOL, $remote));

			if (!empty($remote) && $remote->version != \PHPCanner::VERSION) {
				\PHPCanner::log('A new version of ' . \PHPCanner::NAME . ' (' . \PHPCanner::VERSION . '->' . $remote->version . ') is available at https://github.com/itsmaxymoo/Cranberry. Run \'cb update\' to update automatically.' . PHP_EOL);
			}
			else if (empty($remote)) {
				\PHPCanner::log('Could not check for updates.' . PHP_EOL);
			}
		}

		\PHPCanner::end('' .
			\PHPCanner::DESCRIPTION . PHP_EOL . PHP_EOL .
			'Please specify a command:' . PHP_EOL .
			"\t" . 'build' . "\t\t" . 'Build website in current directory.' .
			PHP_EOL . "\t" . 'init {PATH}' . "\t" . 'Create a new website in {PATH}.' .
			PHP_EOL . "\t" . 'about' . "\t\t" . 'See information about ' . \PHPCanner::NAME . '.' .
			PHP_EOL . "\t" . 'license' . "\t\t" . 'Read the license.' .
			PHP_EOL . "\t" . 'license-full' . "\t" . 'Read the full license text.');
	}

	private static function Update() {
		if (file_exists('/usr/bin/wget')) {
			$remote = [];
			exec('wget -T 0.34 -qO- https://raw.githubusercontent.com/itsmaxymoo/Cranberry/master/pcan.json | cat', $remote);
			$remote = json_decode(implode(PHP_EOL, $remote));

			if (!empty($remote) && $remote->version != \PHPCanner::VERSION) {
				\PHPCanner::log('Updating from https://raw.githubusercontent.com/itsmaxymoo/Cranberry/master/cb...');
				$newCranberry = [];
				exec('wget -qO- https://raw.githubusercontent.com/itsmaxymoo/Cranberry/master/cb | cat', $newCranberry);
				$newCranberry = implode(PHP_EOL, $newCranberry);
				if (file_put_contents(realpath(\PHPCanner::get_exec_name()), $newCranberry)) {
					\PHPCanner::end('Successfully updated (' . \PHPCanner::VERSION . '->' . $remote->version . ')!');
				}
				else {
					\PHPCanner::end('ERROR: Could not write to ' . \PHPCanner::get_exec_name());
				}
			}
			else if (empty($remote)) {
				\PHPCanner::end('ERROR: Could not check for updates!');
			}
			else {
				\PHPCanner::end('ERROR: There is no need to update!');
			}
		}
		else {
			\PHPCanner::end('ERROR: /usr/bin/wget not found!');
		}
	}
}
