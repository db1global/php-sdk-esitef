<?php

namespace DB1\Acquirer\ESitef\Validators;

class StringValidator
{
	public static function isNotEmpty(?string $string, string $message_return = 'String cannot be empty'): void
	{
		if(empty($string)){
			throw new \InvalidArgumentException($message_return);
		}
	}
}
