<?php

namespace DB1\Acquirer\ESitef\Entities;

use DB1\Acquirer\ESitef\Exceptions\MutateInstanceException;
use DB1\Acquirer\ESitef\Validators\StringValidator;

class TransactionEntity
{
	/** @var string */
	private $merchant_usn;

	/** @var string */
	private $order_id;

	/** @var string */
	private $installments;

	/** @var string */
	private $installment_type;

	/** @var string */
	private $authorizer_id;

	/** @var string */
	private $amount;

	private function __construct(){}

	public static function builder(): TransactionEntityBuilder
	{
		$instance = new self();
		$propertySetter = function ($name, $value) use ($instance) {
			$instance->{$name} = $value;
		};

		return new TransactionEntityBuilder($instance, $propertySetter);
	}

	public function getMerchantUsn(): string
	{
		return $this->merchant_usn;
	}

	public function getOrderId(): string
	{
		return $this->order_id;
	}

	public function getInstallments(): string
	{
		return $this->installments;
	}

	public function getInstallmentType(): string
	{
		return $this->installment_type;
	}

	public function getAuthorizerId(): string
	{
		return $this->authorizer_id;
	}

	public function getAmount(): string
	{
		return $this->amount;
	}
}

class TransactionEntityBuilder
{
	/** @var string */
	private $merchant_usn;

	/** @var string */
	private $order_id;

	/** @var string */
	private $installments;

	/** @var string */
	private $installment_type;

	/** @var string */
	private $authorizer_id;

	/** @var string */
	private $amount;

	public function __construct(TransactionEntity $instance, callable $propertySetter)
	{
		$this->instance = $instance;
		$this->propertySetter = $propertySetter;
	}

	/**
	 * @return TransactionEntity
	 * @throws MutateInstanceException
	 */
	public function build(): TransactionEntity
	{
		$this->validateBuild();
		$this->setProperty('merchant_usn', $this->merchant_usn);
		$this->setProperty('order_id', $this->order_id);
		$this->setProperty('installments', $this->installments);
		$this->setProperty('installment_type', $this->installment_type);
		$this->setProperty('authorizer_id', $this->authorizer_id);
		$this->setProperty('amount', $this->amount);
		unset($this->propertySetter);
		return $this->instance;
	}

	/**
	 * @param string $name
	 * @param $value
	 * @return TransactionEntityBuilder
	 * @throws MutateInstanceException
	 */
	private function setProperty(string $name, $value): self
	{
		if (!isset($this->propertySetter)) {
			throw new MutateInstanceException();
		}

		$propertySetter = $this->propertySetter;
		$propertySetter($name, $value);

		return $this;
	}

	public function with_merchant_usn(string $merchant_usn): self
	{
		$this->merchant_usn = $merchant_usn;
		return $this;
	}

	public function with_order_id(string $order_id): self
	{
		$this->order_id = $order_id;
		return $this;
	}

	public function with_installments(string $installments): self
	{
		$this->installments = $installments;
		return $this;
	}

	public function with_installment_type(string $installment_type): self
	{
		$this->installment_type = $installment_type;
		return $this;
	}

	public function with_authorizer_id(string $authorizer_id): self
	{
		$this->authorizer_id = $authorizer_id;
		return $this;
	}

	public function with_amount(string $amount): self
	{
		$this->amount = $amount;
		return $this;
	}

	private function validateBuild(): void {
		StringValidator::isNotEmpty($this->merchant_usn, 'Parameter merchant_usn cannot be empty');
		StringValidator::isNotEmpty($this->order_id, 'Parameter order_id cannot be empty');
		StringValidator::isNotEmpty($this->installments, 'Parameter installments cannot be empty');
		StringValidator::isNotEmpty($this->installment_type, 'Parameter installment_type cannot be empty');
		StringValidator::isNotEmpty($this->authorizer_id, 'Parameter authorizer_id cannot be empty');
		StringValidator::isNotEmpty($this->amount, 'Parameter amount cannot be empty');
	}
}
