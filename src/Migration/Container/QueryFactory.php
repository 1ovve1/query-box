<?php

declare(strict_types=1);

namespace QueryBox\Migration\Container;

use QueryBox\Migration\Container\MigrationParams;

/**
 * Common query factory interface that return Query containers
 */
interface QueryFactory
{
    /**
     * Generate query container manually
     *
     * @param string $query - query string
     * @param callable|null $validate - validate callback
     * @return Query
     */
    public static function customQuery(string $query,?callable $validate = null): Query;

    /**
     * Generate describe query (probably work only in mysql?)
     *
     * @param string $tableName - name of table
     * @return Query - query object
     */
    public static function genMetaQuery(string $tableName): Query;

	/**
	 * Generate create table if exists query
	 *
	 * @param string $tableName - name of table
	 * @param MigrationParams $params
	 * @return Query - query object
	 */
    public static function genCreateTableQuery(string $tableName, array $params): Query;

    /**
     * Return show tables query
     *
     * @return Query - query object
     */
    public static function genShowTableQuery(): Query;
}
