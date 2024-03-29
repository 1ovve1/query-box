<?php

declare(strict_types=1);

namespace QueryBox\DBAdapter;

use QueryBox\Migration\Container\Query;
use QueryBox\Exceptions\Checked\InvalidForceInsertConfigurationException;

/**
 * Common interface for database connection
 */
interface DBAdapter
{
	/**
	 * @param string $dbType - type name of curr db
	 * @param string $dbHost - db host
	 * @param string $dbName - db name
	 * @param string $dbPort - port
	 * @return DBAdapter
	 */
	static function connectViaDSN(string $dbType, string $dbHost,
	                              string $dbName, string $dbPort,
	                              string $dbUsername, string $dbPass): self;

	/**
	 * Execute custom query container
	 *
	 * @param Query $query - query container
	 * @return QueryResult
	 */
    public function rawQuery(Query $query): QueryResult;
  

	/**
	 * Prepare query by template. Use execute for execute statement or getTemplate to get QueryTemplate object
	 *
	 * @param string $template - template
	 * @return QueryTemplateBindAble - prepared state
	 */
    public function prepare(string $template): QueryTemplateBindAble;

	/**
	 * Prepare lazy insert template and
	 *
	 * @param string $tableName
	 * @param array<string> $fields - fields
	 * @param int $stagesCount - stages count
	 * @return QueryTemplate - prepared statement object
	 * @throws InvalidForceInsertConfigurationException
	 */
    public function getForceInsertTemplate(
        string $tableName,
        array $fields,
        int $stagesCount = 1
    ): QueryTemplate;
}
