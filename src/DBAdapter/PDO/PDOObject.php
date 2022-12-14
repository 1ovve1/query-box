<?php

declare(strict_types=1);

namespace QueryBox\DBAdapter\PDO;

use QueryBox\DBAdapter\{QueryTemplate};
use QueryBox\DBAdapter\DBAdapter;
use QueryBox\DBAdapter\QueryResult;
use QueryBox\DBAdapter\QueryTemplateBindAble;
use QueryBox\Exceptions\Unchecked\BadQueryResultException;
use QueryBox\Exceptions\Unchecked\FailedDBConnectionWithDBException;
use QueryBox\Migration\Container\Query;
use PDO;
use PDOException;

/**
 * Implements DBAdapter for PDO connection type
 */
class PDOObject implements DBAdapter
{
    /** @var PDO - curr instance of db connection */
    readonly PDO $instance;

	/**
	 * @param string $dsn
	 * @param string $dbUsername
	 * @param string $dbPass
	 */
    private function __construct(string $dsn, string $dbUsername, string $dbPass) {
		$this->instance = self::connectPDO($dsn, $dbUsername, $dbPass);
    }

	/**
	 * @inheritDoc
	 */
	static function connectViaDSN(string $dbType, string $dbHost, string $dbName, string $dbPort, string $dbUsername, string $dbPass): DBAdapter
	{
		$dsn = self::getDsn($dbType, $dbHost, $dbName, $dbPort);

		try{
			$instance = new self($dsn, $dbUsername, $dbPass);
		} catch (PDOException $pdoException) {
			throw new FailedDBConnectionWithDBException($dsn, $pdoException);
		}

		return $instance;
	}


	/**
	 * Generate DSN by params
	 * @param string $dbType
	 * @param string $dbHost
	 * @param string $dbName
	 * @param string $dbPort
	 * @return string
	 */
	protected static function getDsn(string $dbType, string $dbHost,
	                                 string $dbName, string $dbPort) : string
	{
		$charsetOption = ($dbType === 'mysql') ? ';charset=utf8': '';
		return sprintf(
			'%s:host=%s;dbname=%s;port=%s' . $charsetOption,
			$dbType, $dbHost, $dbName, $dbPort,
		);
	}

	/**
	 * Create connection to PDO
	 *
	 * @param string $dsn - dsn string format
	 * @param string $dbUsername
	 * @param string $dbPass
	 * @return PDO - connection to db
	 */
	protected static function connectPDO(string $dsn,
	                                     string $dbUsername,
	                                     string $dbPass) : PDO
	{
		return new PDO(
			$dsn, $dbUsername, $dbPass,
			[
				PDO::ATTR_PERSISTENT => true,
				PDO::MYSQL_ATTR_USE_BUFFERED_QUERY => true,
			]
		);
	}

	/**
	 * {@inheritDoc}
	 */
    public function rawQuery(Query $query): QueryResult
    {
		try {
			$res = $this->instance->query($query->getRawSql());
		} catch (PDOException $pdoException) {
			throw new BadQueryResultException($query->getRawSql(), $pdoException);
		}

		if (false === $res) {
			throw new BadQueryResultException($query->getRawSql());
		}

        return new PDOQueryResult($res);
    }

	/**
	 * {@inheritDoc}
	 */
    public function prepare(string $template): QueryTemplateBindAble
    {
        $template = $this->instance->prepare($template);

        return new PDOTemplate($template);
    }

	/**
	 * {@inheritDoc}
	 */
    public function getForceInsertTemplate(string $tableName,
                                           array $fields,
                                           int $stagesCount = 1): QueryTemplate
    {
        return new PDOForceInsertTemplate($this, $tableName, $fields, $stagesCount);
    }
}
