<?php declare(strict_types=1);

namespace QueryBox\QueryBuilder\QueryTypes\Condition;

use QueryBox\QueryBuilder\QueryTypes\Condition\DatabaseContract;
use QueryBox\QueryBuilder\ActiveRecord\ActiveRecord;

class ImplConditionAnd extends ContinueConditionQuery
{
	/**
	 * @param ActiveRecord $parent
	 * @param string $field
	 * @param string $sign
	 * @param DatabaseContract $value
	 */
	public function __construct(ActiveRecord $parent,
	                            string $field,
	                            string $sign,
	                            int|float|bool|string|null $value)
	{
		parent::__construct(
			$this::createQueryBox(
				clearArgs: [$field, $sign],
				dryArgs: [$value],
				parentBox: $parent->getQueryBox()
			)
		);
	}
}