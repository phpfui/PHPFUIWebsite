<?php

namespace PHPFUI\ORM\Record\Definition;

/**
 * Autogenerated. Do not modify. Modify SQL table, then run oneOffScripts\generateCRUD.php table_name
 *
 * @property int $migrationId MySQL type int(11)
 * @property \PHPFUI\ORM\Record\Migration $migration related record
 * @property string $ran MySQL type timestamp
 */
abstract class Migration extends \PHPFUI\ORM\Record
	{
	protected static bool $autoIncrement = false;

	/** @var array<string, array<mixed>> */
	protected static array $fields = [
		// MYSQL_TYPE, PHP_TYPE, LENGTH, KEY, ALLOWS_NULL, DEFAULT
		'migrationId' => ['int(11)', 'int', 11, true, false, ],
		'ran' => ['timestamp', 'string', 20, false, false, ],
	];

	/** @var array<string, true> */
	protected static array $primaryKeys = ['migrationId' => true, ];

	protected static string $table = 'migration';
	}
