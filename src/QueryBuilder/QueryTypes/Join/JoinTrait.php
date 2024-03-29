<?php declare(strict_types=1);

namespace QueryBox\QueryBuilder\QueryTypes\Join;


use QueryBox\QueryBuilder\Helper;

trait JoinTrait
{
	/**
	 * @inheritDoc
	 */
	public function innerJoin(array|string $table, array $condition): JoinQuery
	{
		['tableName' => $table, 'condition' => [$leftSideField, $rightSideField]] = Helper::joinArgsHandler($table, $condition);

		return new ImplInnerJoin($this, $table, $leftSideField, $rightSideField);
	}

	/**
	 * @inheritDoc
	 */
	public function leftJoin(array|string $table, array $condition): JoinQuery
	{
		['tableName' => $table, 'condition' => [$leftSideField, $rightSideField]] = Helper::joinArgsHandler($table, $condition);

		return new ImplLeftJoin($this, $table, $leftSideField, $rightSideField);
	}

	/**
	 * @inheritDoc
	 */
	public function rightJoin(array|string $table, array $condition): JoinQuery
	{
		['tableName' => $table, 'condition' => [$leftSideField, $rightSideField]] = Helper::joinArgsHandler($table, $condition);


		return new ImplRightJoin($this, $table, $leftSideField, $rightSideField);
	}


}