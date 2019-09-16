<?php

namespace Test\Acquirer\ESitef\Entities;

use DB1\Acquirer\ESitef\Validators\StringValidator;
use PHPUnit\Framework\TestCase;

class StringValidatorTest extends TestCase {

	public function test_StringEmpty_WithDefaultMessage_ShouldThrowException(): void
	{
		self::expectException(\InvalidArgumentException::class);
		self::expectExceptionMessage('String cannot be empty');

		StringValidator::isNotEmpty($string = '');
	}

	public function test_StringEmpty_WithCustomMessage_ShouldThrowException(): void
	{
		self::expectException(\InvalidArgumentException::class);
		self::expectExceptionMessage('String cannot be empty this test');

		StringValidator::isNotEmpty($string = '', $message_return = 'String cannot be empty this test');
	}

	public function test_StringNull_WithDefaultMessage_ShouldThrowException(): void
	{
		self::expectException(\InvalidArgumentException::class);
		self::expectExceptionMessage('String cannot be empty');

		StringValidator::isNotEmpty($string = null);
	}

	public function test_StringNull_WithCustomMessage_ShouldThrowException(): void
	{
		self::expectException(\InvalidArgumentException::class);
		self::expectExceptionMessage('String cannot be null this test');

		StringValidator::isNotEmpty($string = '', $message_return = 'String cannot be null this test');
	}
}
