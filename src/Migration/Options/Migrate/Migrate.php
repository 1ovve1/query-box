<?php declare(strict_types=1);

namespace QueryBox\Migration\Options\Migrate;

use QueryBox\DBAdapter\DBAdapter;
use QueryBox\Migration\Options\Migrate\MigrationParams;
use RuntimeException;

interface Migrate
{
	/**
	 * Static migration
	 *
	 * @param DBAdapter $db
	 * @param string $tableName
	 * @param MigrationParams $paramsToCreate
	 * @return void
	 */
	static function migrate(DBAdapter $db,
	                        string $tableName,
	                        array $paramsToCreate): void;

	/**
	 * Do migrate using db connection and class that implement MigrateAble interface
	 *
	 * @param DBAdapter $db
	 * @param string $className
	 * @return void
	 * @throws RuntimeException - if className not implement MigrateAble or not exists
	 */
	static function migrateFromMigrateAble(DBAdapter $db, string $className): void;

}