<?php declare(strict_types=1);

namespace QueryBox\Exceptions\Checked;

use QueryBox\Exceptions\ExceptionCodes;
use Exception;

class QueryTemplateNotFoundException extends Exception
{
	const MESSAGE = "QueryTemplate was not found";

	public function __construct()
	{
		parent::__construct(
			self::MESSAGE,
			ExceptionCodes::QUERY_TEMPLATE_WAS_NOT_FOUND_CODE
		);
	}

}