<?php

namespace DB1\Acquirer\ESitef\Exceptions;

class MutateInstanceException extends \Exception
{
	public function __construct() {
		parent::__construct('Cannot mutate instance after build', 0);
	}
}
