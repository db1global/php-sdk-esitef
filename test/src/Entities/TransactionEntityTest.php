<?php

namespace Test\Acquirer\ESitef\Entities;

use DB1\Acquirer\ESitef\Entities\TransactionEntity;
use PHPUnit\Framework\TestCase;

class TransactionEntityTest extends TestCase {

	public function test_TransactionEntityBuilder_ShouldBuild(): void
	{
		$card = TransactionEntity::builder()
			->with_merchant_usn($merchant_usn = '12042142155')
			->with_order_id($order_id = '12042142155')
			->with_installments($installments = '1')
			->with_installment_type($installment_type = '4')
			->with_authorizer_id($authorizer_id = '2')
			->with_amount($amount = '1000')
			->build();

		$this->assertEquals($merchant_usn, $card->getMerchantUsn());
		$this->assertEquals($order_id, $card->getOrderId());
		$this->assertEquals($installments, $card->getInstallments());
		$this->assertEquals($installment_type, $card->getInstallmentType());
		$this->assertEquals($authorizer_id, $card->getAuthorizerId());
		$this->assertEquals($amount, $card->getAmount());

	}

	public function test_TransactionEntityBuilder_WithWrongData_ShouldThrowException(): void
	{
		$this->expectException(\InvalidArgumentException::class);
		$this->expectExceptionMessage('Parameter merchant_usn cannot be empty');
		TransactionEntity::builder()->build();
	}

	/** @dataProvider invalidDataProvider */
	public function test_TransactionEntityBuilderWithInvalidData_ShouldThrowException(
		string $merchant_usn,
		string $order_id,
		string $installments,
		string $installment_type,
		string $authorizer_id,
		string $amount,
		string $expected_message
	): void
	{
		self::expectException(\InvalidArgumentException::class);
		self::expectExceptionMessage($expected_message);

		TransactionEntity::builder()
			->with_merchant_usn($merchant_usn)
			->with_order_id($order_id)
			->with_installments($installments)
			->with_installment_type($installment_type)
			->with_authorizer_id($authorizer_id)
			->with_amount($amount)
			->build();
	}

	public function invalidDataProvider(): array
	{
		return [
			//$merchant_usn  $order_id      $installments  $installment_type  $authorizer_id  $amount  $expected_message
			[''           ,  '12042142155', '1'          , '4'              , '2'           , '1000' , 'Parameter merchant_usn cannot be empty'],
			['12042142155',  ''           , '1'          , '4'              , '2'           , '1000' , 'Parameter order_id cannot be empty'],
			['12042142155',  '12042142155', ''           , '4'              , '2'           , '1000' , 'Parameter installments cannot be empty'],
			['12042142155',  '12042142155', '1'          , ''               , '2'           , '1000' , 'Parameter installment_type cannot be empty'],
			['12042142155',  '12042142155', '1'          , '4'              , ''            , '1000' , 'Parameter authorizer_id cannot be empty'],
			['12042142155',  '12042142155', '1'          , '4'              , '2'           , ''     , 'Parameter amount cannot be empty'],
			[''           ,  ''           , ''           , ''               , ''            , ''     , 'Parameter merchant_usn cannot be empty'],
		];
	}
}
