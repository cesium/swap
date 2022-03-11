<?php

namespace App\Exceptions;

use Exception;

class NoExchangesCanBeDone extends Exception
{
	/**
	 * Create a new exception instance.
	 *
	 * @param string $message
	 */
	public function __construct($message = 'None possible exchanges where found.')
	{
		parent::__construct($message);
	}
}
