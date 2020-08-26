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
		$this->assertValidPHPDirectory(__DIR__ . '/../App', 'App directory has an error');
		$this->assertValidPHPDirectory(__DIR__ . '/../PHPFUI', 'PHPFUI directory has an error');
		$this->assertValidPHPDirectory(__DIR__ . '/../DeepCopy', 'DeepCopy directory has an error');
		$this->assertValidPHPDirectory(__DIR__ . '/../Firebase', 'Firebase directory has an error');
		$this->assertValidPHPDirectory(__DIR__ . '/../cebe', 'cebe directory has an error');
		$this->assertValidPHPDirectory(__DIR__ . '/../Example', 'Example directory has an error');
		$this->assertValidPHPDirectory(__DIR__ . '/../Gitonomy', 'Gitonomy directory has an error');
		$this->assertValidPHPDirectory(__DIR__ . '/../GuzzleHttp', 'GuzzleHttp directory has an error');
		$this->assertValidPHPDirectory(__DIR__ . '/../Highlight', 'Highlight directory has an error');
		$this->assertValidPHPDirectory(__DIR__ . '/../Monolog', 'Monolog directory has an error');
		$this->assertValidPHPDirectory(__DIR__ . '/../NXP', 'NXP directory has an error');
		$this->assertValidPHPDirectory(__DIR__ . '/../phpDocumentor', 'phpDocumentor directory has an error');
		$this->assertValidPHPDirectory(__DIR__ . '/../PHPFUI', 'PHPFUI directory has an error');
		$this->assertValidPHPDirectory(__DIR__ . '/../PHPHtmlParser', 'PHPHtmlParser directory has an error');
		$this->assertValidPHPDirectory(__DIR__ . '/../PhpParser', 'PhpParser directory has an error');
		$this->assertValidPHPDirectory(__DIR__ . '/../Psr', 'Psr directory has an error');
		$this->assertValidPHPDirectory(__DIR__ . '/../Rize', 'Rize directory has an error');
		$this->assertValidPHPDirectory(__DIR__ . '/../Symfony', 'Symfony directory has an error');
		$this->assertValidPHPDirectory(__DIR__ . '/../Symfony', 'Symfony directory has an error');
		$this->assertValidPHPDirectory(__DIR__ . '/../Webmozart', 'Webmozart directory has an error');
		}

	public function testValidPHPFile() : void
		{
		$this->assertValidPHPFile(__DIR__ . '/../www/index.php', 'Index file is bad');
		$this->assertValidPHPFile(__DIR__ . '/../common.php', 'common file is bad');
		$this->assertValidPHPFile(__DIR__ . '/../commonbase.php', 'commonbase file is bad');
		}

	}
