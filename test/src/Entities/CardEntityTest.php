<?php

namespace Test\Acquirer\ESitef\Entities;

use DB1\Acquirer\ESitef\Entities\CardEntity;
use PHPUnit\Framework\TestCase;

class CardEntityTest extends TestCase {

	public function test_CardEntityBuilder_AllElements_ShouldBuild(): void
	{
		$card = CardEntity::builder()
			->with_card_number($card_number = '5555555555555555')
			->with_card_expiry_date($card_expiry_date = '1222')
			->with_card_cvv($card_cvv = '123')
			->build();

		$this->assertEquals($card_number, $card->getCardNumber());
		$this->assertEquals($card_expiry_date, $card->getCardExpiryDate());
		$this->assertEquals($card_cvv, $card->getCardCvv());
	}

	public function test_CardEntityBuilder_WithoutCvv_ShouldBuild(): void
	{
		$card = CardEntity::builder()
			->with_card_number($card_number = '5555555555555555')
			->with_card_expiry_date($card_expiry_date = '1222')
			->build();

		$this->assertEquals($card_number, $card->getCardNumber());
		$this->assertEquals($card_expiry_date, $card->getCardExpiryDate());
		$this->assertEmpty($card->getCardCvv());
	}

	public function test_CardEntityBuilder_WithWrongData_ShouldThrowException(): void
	{
		$this->expectException(\InvalidArgumentException::class);
		$this->expectExceptionMessage('Parameter card_number cannot be empty');
		CardEntity::builder()->build();
	}

	/** @dataProvider invalidDataProvider */
	public function test_CardEntityBuilderWithInvalidData_ShouldThrowException(
		string $card_number,
		string $card_expiry_date,
		string $card_cvv,
		string $nit,
		string $expected_message
	): void
	{
		self::expectException(\InvalidArgumentException::class);
		self::expectExceptionMessage($expected_message);

		CardEntity::builder()
			->with_card_number($card_number)
			->with_card_expiry_date($card_expiry_date)
			->with_card_cvv($card_cvv)
			->build();
	}

	public function invalidDataProvider(): array
	{
		return [
			//$card_number     $card_expiry_date  $card_cvv   $nit              $expected_message
			[''                , '1222'           , '123'     ,'QWEQWEXXX0000'  , 'Parameter card_number cannot be empty'],
			['5555555555555555', ''               , '123'     ,'QWEQWEXXX0000'  , 'Parameter card_expiry_date cannot be empty'],
			[''                , ''               , ''        ,'QWEQWEXXX0000'  , 'Parameter card_number cannot be empty'],
		];
	}
}
