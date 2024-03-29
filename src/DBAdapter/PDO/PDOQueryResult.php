<?php declare(strict_types=1);

namespace QueryBox\DBAdapter\PDO;

use QueryBox\DBAdapter\QueryResult;
use QueryBox\Exceptions\Checked\NullableQueryResultException;
use PDOStatement;

class PDOQueryResult implements QueryResult
{
	/**
	 * @var array<int, array<int|string, mixed>>
	 */
	private ?array $fetchResult = null;

	function __construct(
		private readonly ?PDOStatement $queryState
	)
	{}

	/**
	 * @return PDOStatement
	 * @throws NullableQueryResultException
	 */
	function getQueryResult(): PDOStatement
	{
		if (null === $this->queryState) {
			throw new NullableQueryResultException();
		}

		return $this->queryState;
	}

	/**
	 * @inheritDoc
	 */
	public function fetchAll(int $flag = QueryResult::PDO_F_ASSOC): array
	{
		if (null === $this->fetchResult) {
			try {
				$this->fetchResult = $this->getQueryResult()->fetchAll($flag);
			} catch (NullableQueryResultException) {
				return [];
			}
		}

		return $this->fetchResult;
	}

	/**
	 * @inheritDoc
	 */
	function fetchAllAssoc(): array
	{
		return $this->fetchAll();
	}

	/**
	 * @inheritDoc
	 */
	function fetchAllNum(): array
	{
		return $this->fetchAll(QueryResult::PDO_F_NUM);
	}

	/**
	 * @inheritDoc
	 */
	function fetchCollumn(): array
	{
		return $this->fetchAll(QueryResult::PDO_F_COL);
	}	

	/**
	 * @inheritDoc
	 */
	function rowCount(): int
	{
		try{
			return $this->getQueryResult()->rowCount();
		} catch (NullableQueryResultException) {
			return 0;
		}
	}

	/**
	 * @inheritDoc
	 */
	function isEmpty(): bool
	{
		return empty($this->rowCount());
	}

	/**
	 * @return bool
	 */
	function isNotEmpty(): bool
	{
		return !$this->isEmpty();
	}

	/**
	 * @return bool
	 */
	function hasOnlyOneRow(): bool
	{
		try {
			return $this->getQueryResult()->rowCount() === 1;
		} catch (NullableQueryResultException) {
			return false;
		}
	}

	/**
	 * @inheritDoc
	 */
	function hasManyRows(): bool
	{
		return !$this->hasOnlyOneRow() && $this->isNotEmpty();
	}

}