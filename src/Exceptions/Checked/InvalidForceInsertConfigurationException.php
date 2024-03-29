<?php declare(strict_types=1);

namespace QueryBox\Exceptions\Checked;

use QueryBox\Exceptions\ExceptionCodes;
use Exception;

class InvalidForceInsertConfigurationException extends Exception
{
	public function __construct(string $message)
	{
		parent::__construct(
			$message,
			ExceptionCodes::INVALID_FORCE_INSERT_CONFIGURATION_CODE
		);
	}

}