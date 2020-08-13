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
class UnitTest extends \PHPFUI\PHPUnitSyntaxCoverage\Extensions
	{

	public function testDirectory() : void
		{
		$this->assertValidPHPDirectory(__DIR__ . '/../App', 'App directory is not valid');
		$this->assertValidPHPDirectory(__DIR__ . '/../PHPFUI', 'PHPFUI directory is not valid');
		}

	public function testValidPHPFile() : void
		{
		$this->assertValidPHPFile(__DIR__ . '/../www/index.php', 'Index file is bad');
		$this->assertValidPHPFile(__DIR__ . '/../common.php', 'common file is bad');
		$this->assertValidPHPFile(__DIR__ . '/../commonbase.php', 'commonbase file is bad');
		}

	}
