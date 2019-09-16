<?php

namespace Test\Acquirer\ESitef\Entities;

use DB1\Acquirer\ESitef\Entities\CardEntity;
use DB1\Acquirer\ESitef\Entities\TokenizeCardEntity;
use PHPUnit\Framework\TestCase;

class TokenizeCardEntityTest extends TestCase {

	public function test_TokenizeCardEntityBuilder_ShouldBuild(): void
	{
		$card = CardEntity::builder()
			->with_card_number($card_number = '12042142155')
			->with_card_expiry_date($card_expiry_date = '1222')
			->build();

		$tokenize_card = TokenizeCardEntity::builder()
			->with_card($card)
			->with_authorizer_id($authorizer_id = '2')
			->with_merchant_usn($merchant_usn = '16013439434')
			->with_customer_id($customer_id = '11122211122')
			->build();

		$this->assertEquals($authorizer_id, $tokenize_card->getAuthorizerId());
		$this->assertEquals($merchant_usn, $tokenize_card->getMerchantUsn());
		$this->assertEquals($customer_id, $tokenize_card->getCustomerId());
		$this->assertInstanceOf(CardEntity::class, $card);
		$this->assertEquals($card_number, $tokenize_card->getCard()->getCardNumber());
		$this->assertEquals($card_expiry_date, $tokenize_card->getCard()->getCardExpiryDate());
	}

	public function test_TokenizeCardEntityBuilder_WithWrongData_ShouldThrowException(): void
	{
		$this->expectException(\InvalidArgumentException::class);
		$this->expectExceptionMessage('Parameter authorizer_id cannot be empty');
		TokenizeCardEntity::builder()->build();
	}

	/** @dataProvider invalidDataProvider */
	public function test_TokenizeCardEntityBuilderWithInvalidData_ShouldThrowException(
		string $merchant_usn,
		string $authorizer_id,
		string $customer_id,
		string $expected_message
	): void
	{
		self::expectException(\InvalidArgumentException::class);
		self::expectExceptionMessage($expected_message);

		$card = CardEntity::builder()
			->with_card_number($card_number = '12042142155')
			->with_card_expiry_date($card_expiry_date = '1222')
			->build();

		TokenizeCardEntity::builder()
			->with_merchant_usn($merchant_usn)
			->with_authorizer_id($authorizer_id)
			->with_customer_id($customer_id)
			->with_card($card)
			->build();
	}

	public function invalidDataProvider(): array
	{
		return [
			//$merchant_usn  $authorizer_id  $customer_id   $expected_message
			[''           ,  '2'           , '11122211122', 'Parameter merchant_usn cannot be empty'],
			['16013439434',  ''            , '11122211122', 'Parameter authorizer_id cannot be empty'],
			['16013439434',  '2'           , ''           , 'Parameter customer_id cannot be empty'],
			[''           ,  ''            , ''           , 'Parameter authorizer_id cannot be empty'],
		];
	}
}
