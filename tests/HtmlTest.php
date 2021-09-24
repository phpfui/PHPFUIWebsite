<?php

/**
 * This file is part of the PHPFUI package
 *
 * (c) Bruce Wells
 *
 * For the full copyright and license information, please view
 * the LICENSE.md file that was distributed with this source
 * code
 */
class HtmlTest extends \PHPFUI\HTMLUnitTester\Extensions
  {

	public function testExampleDirectory()
    {
		foreach (new \DirectoryIterator(PROJECT_ROOT . '/Example') as $fileInfo)
			{
			$file = $fileInfo->getFilename();
			$index = strpos($file, '.php');
			if (! $index)
				{
				continue;
				}
			$class = '\\Example\\' . substr($file, 0, strlen($file) - 4);
			$_SERVER['REQUEST_URI'] = '/Example/' . $file;
			$_SERVER['SERVER_NAME'] = 'localhost';

			$object = new $class([]);
			$this->assertValidHtml("{$object}", 'Error in file ' . $file);
			}
    }

	public function testCSSDirectory()
		{
		$this->assertDirectory('ValidCSS', PROJECT_ROOT . '/www');
		$this->assertDirectory('NotWarningCSS', PROJECT_ROOT . '/www');
		}
  }
