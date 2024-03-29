<?php declare(strict_types=1);

namespace QueryBox\QueryBuilder\QueryTypes\Where;


use QueryBox\QueryBuilder\Helper;

trait WhereTrait
{
	/**
	 * {@inheritDoc}
	 */
	public function where(callable|array|string $field_or_nested_clbk,
	                      int|float|bool|string|null $sign_or_value = '',
	                      float|int|bool|string|null $value = null): WhereQuery
	{
		// if it first arg are callback then we use nested where
		if (is_callable($field_or_nested_clbk)) {
			return new ImplNestedWhere($this, $field_or_nested_clbk);
		}

		['field' => $field, 'sign' => $sign, 'value' => $value] = Helper::whereArgsHandler($field_or_nested_clbk, $sign_or_value, $value);

		return new ImplWhere($this, $field, $sign, $value);

	}
}