<?php declare(strict_types=1);

namespace QueryBox\QueryBuilder\QueryTypes\Delete;


class ImplDelete extends DeleteQuery
{
	public function __construct(string $tableName)
	{
		parent::__construct(
			$this::createQueryBox(
				clearArgs: [$tableName]
			)
		);
	}
}