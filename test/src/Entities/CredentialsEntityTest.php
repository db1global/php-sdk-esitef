<?php

namespace Test\Acquirer\ESitef\Entities;

use DB1\Acquirer\ESitef\Entities\CredentialsEntity;
use PHPUnit\Framework\TestCase;

class CredentialsEntityTest extends TestCase {

	public function test_CredentialsEntity_ShouldBuild(): void
	{
		$credentials = CredentialsEntity::builder()
			->with_merchant_id($merchant_id = '1231231231')
			->with_merchant_key($merchant_key = 'ASFSADFCCSDFSDF5558SDFSDFSDF')
			->build();

		$this->assertEquals($merchant_id, $credentials->getMerchantId());
		$this->assertEquals($merchant_key, $credentials->getMerchantKey());
	}

	public function test_CredentialsEntity_WithWrongData_ShouldThrowException(): void
	{
		$this->expectException(\InvalidArgumentException::class);
		$this->expectExceptionMessage('Parameter merchant_id cannot be empty');
		CredentialsEntity::builder()->build();
	}

	/** @dataProvider invalidDataProvider */
	public function test_CredentialsEntityBuilderWithInvalidData_ShouldThrowException(
		string $merchant_id,
		string $merchant_key,
		string $expected_message
	): void
	{
		self::expectException(\InvalidArgumentException::class);
		self::expectExceptionMessage($expected_message);

		CredentialsEntity::builder()
			->with_merchant_id($merchant_id)
			->with_merchant_key($merchant_key)
			->build();
	}

	public function invalidDataProvider(): array
	{
		return [
			//$merchant_id     $merchant_key                     $expected_message
			[''                , 'ASFSADFCCSDFSDF5558SDFSDFSDF'  , 'Parameter merchant_id cannot be empty'],
			['1231231231'      , ''                              , 'Parameter merchant_key cannot be empty'],
			[''                , ''                              , 'Parameter merchant_id cannot be empty'],
		];
	}
}
