<?php

namespace Test\Acquirer\ESitef\Entities;

use DB1\Acquirer\ESitef\Entities\TokenEntity;
use PHPUnit\Framework\TestCase;

class TokenEntityTest extends TestCase {

	public function test_TokenEntityBuilder_ShouldBuild(): void
	{
		$token_entity = TokenEntity::builder()
			->with_token($token = 'g16hJtpdU6XEN3FP-ApQ9pKTGII')
			->with_card_cvv($card_cvv = '123')
			->build();

		$this->assertEquals($token, $token_entity->getToken());
		$this->assertEquals($card_cvv, $token_entity->getCardCvv());
	}

	public function test_TokenEntityBuilder_WithWrongData_ShouldThrowException(): void
	{
		$this->expectException(\InvalidArgumentException::class);
		$this->expectExceptionMessage('Parameter token cannot be empty');
		TokenEntity::builder()->build();
	}

	/** @dataProvider invalidDataProvider */
	public function test_TokenEntityBuilderWithInvalidData_ShouldThrowException(
		string $token,
		string $card_cvv,
		string $expected_message
	): void
	{
		self::expectException(\InvalidArgumentException::class);
		self::expectExceptionMessage($expected_message);

		TokenEntity::builder()
			->with_token($token)
			->with_card_cvv($card_cvv)
			->build();
	}

	public function invalidDataProvider(): array
	{
		return [
			//$token                       $card_cvv   $expected_message
			[''                           , '123'     , 'Parameter token cannot be empty'],
			['g16hJtpdU6XEN3FP-ApQ9pKTGII', ''        , 'Parameter card_cvv cannot be empty'],
			[''                           , ''        , 'Parameter token cannot be empty'],
		];
	}
}
