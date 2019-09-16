<?php

namespace DB1\Acquirer\ESitef\Entities;

use DB1\Acquirer\ESitef\Exceptions\MutateInstanceException;
use DB1\Acquirer\ESitef\Validators\StringValidator;

class TokenizeCardEntity
{
	/** @var CardEntity */
	private $card;

	/** @var string */
	private $authorizer_id;

	/** @var string */
	private $merchant_usn;

	/** @var string */
	private $customer_id;

	private function __construct(){}

	public static function builder(): TokenizeCardEntityBuilder
	{
		$instance = new self();
		$propertySetter = function ($name, $value) use ($instance) {
			$instance->{$name} = $value;
		};

		return new TokenizeCardEntityBuilder($instance, $propertySetter);
	}

	public function getCard(): CardEntity
	{
		return $this->card;
	}

	public function getAuthorizerId(): string
	{
		return $this->authorizer_id;
	}

	public function getMerchantUsn(): string
	{
		return $this->merchant_usn;
	}

	public function getCustomerId(): string
	{
		return $this->customer_id;
	}
}

class TokenizeCardEntityBuilder
{
	/** @var CardEntity */
	private $card;

	/** @var string */
	private $authorizer_id;

	/** @var string */
	private $merchant_usn;

	/** @var string */
	private $customer_id;

	public function __construct(TokenizeCardEntity $instance, callable $propertySetter)
	{
		$this->instance = $instance;
		$this->propertySetter = $propertySetter;
	}

	/**
	 * @return TokenizeCardEntity
	 * @throws MutateInstanceException
	 */
	public function build(): TokenizeCardEntity
	{
		$this->validateBuild();
		$this->setProperty('card', $this->card);
		$this->setProperty('authorizer_id', $this->authorizer_id);
		$this->setProperty('merchant_usn', $this->merchant_usn);
		$this->setProperty('customer_id', $this->customer_id);
		unset($this->propertySetter);
		return $this->instance;
	}

	/**
	 * @param string $name
	 * @param $value
	 * @return TokenizeCardEntityBuilder
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

	public function with_card(CardEntity $card): self
	{
		$this->card = $card;
		return $this;
	}

	public function with_authorizer_id(string $authorizer_id): self
	{
		$this->authorizer_id = $authorizer_id;
		return $this;
	}

	public function with_merchant_usn(string $merchant_usn): self
	{
		$this->merchant_usn = $merchant_usn;
		return $this;
	}

	public function with_customer_id(string $customer_id): self
	{
		$this->customer_id = $customer_id;
		return $this;
	}

	private function validateBuild(): void {
		StringValidator::isNotEmpty($this->authorizer_id, 'Parameter authorizer_id cannot be empty');
		StringValidator::isNotEmpty($this->merchant_usn, 'Parameter merchant_usn cannot be empty');
		StringValidator::isNotEmpty($this->customer_id, 'Parameter customer_id cannot be empty');
		StringValidator::isNotEmpty($this->card->getCardNumber(), 'Parameter card_number cannot be empty');
		StringValidator::isNotEmpty($this->card->getCardExpiryDate(), 'Parameter card_expiry_date cannot be empty');
	}
}
