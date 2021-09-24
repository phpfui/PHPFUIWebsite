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
		$this->assertValidPHPDirectory(PROJECT_ROOT . '/cebe', 'cebe directory has an error');
		$this->assertValidPHPDirectory(PROJECT_ROOT . '/DeepCopy', 'DeepCopy directory has an error');
		$this->assertValidPHPDirectory(PROJECT_ROOT . '/Example', 'Example directory has an error');
		$this->assertValidPHPDirectory(PROJECT_ROOT . '/Gitonomy', 'Gitonomy directory has an error');
		$this->assertValidPHPDirectory(PROJECT_ROOT . '/Highlight', 'Highlight directory has an error');
		$this->assertValidPHPDirectory(PROJECT_ROOT . '/NXP', 'NXP directory has an error');
		$this->assertValidPHPDirectory(PROJECT_ROOT . '/phpDocumentor', 'phpDocumentor directory has an error');
		$this->assertValidPHPDirectory(PROJECT_ROOT . '/PHPFUI', 'PHPFUI directory has an error');
		$this->assertValidPHPDirectory(PROJECT_ROOT . '/PHPHtmlParser', 'PHPHtmlParser directory has an error');
		$this->assertValidPHPDirectory(PROJECT_ROOT . '/PhpParser', 'PhpParser directory has an error');
		$this->assertValidPHPDirectory(PROJECT_ROOT . '/Psr', 'Psr directory has an error');
		$this->assertValidPHPDirectory(PROJECT_ROOT . '/stringEncode', 'stringEncode directory has an error');
		$this->assertValidPHPDirectory(PROJECT_ROOT . '/Symfony', 'Symfony directory has an error');
		$this->assertValidPHPDirectory(PROJECT_ROOT . '/Webmozart', 'Webmozart directory has an error');
		$this->assertValidPHPDirectory(PROJECT_ROOT . '/www', 'www directory has an error');
		}

	public function testValidPHPFile() : void
		{
		$this->assertValidPHPFile(PROJECT_ROOT . '/www/index.php', 'Index file is bad');
		$this->assertValidPHPFile(PROJECT_ROOT . '/common.php', 'common file is bad');
		$this->assertValidPHPFile(PROJECT_ROOT . '/commonbase.php', 'commonbase file is bad');
		}

	}
