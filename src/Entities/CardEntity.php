<?php

namespace DB1\Acquirer\ESitef\Entities;

use DB1\Acquirer\ESitef\Exceptions\MutateInstanceException;
use DB1\Acquirer\ESitef\Validators\StringValidator;

class CardEntity
{
	/** @var string */
	private $card_number;

	/** @var string */
	private $card_expiry_date;

	/** @var string */
	private $card_cvv;

	/** @var string */
	private $nit;

	private function __construct(){}

	public static function builder(): CardEntityBuilder
	{
		$instance = new self();
		$propertySetter = function ($name, $value) use ($instance) {
			$instance->{$name} = $value;
		};

		return new CardEntityBuilder($instance, $propertySetter);
	}

	public function getCardNumber(): string
	{
		return $this->card_number;
	}

	public function getCardExpiryDate(): string
	{
		return $this->card_expiry_date;
	}

	public function getCardCvv(): string
	{
		return $this->card_cvv;
	}

	public function getNit(): string
	{
		return $this->nit;
	}
}

class CardEntityBuilder
{
	/** @var string */
	private $card_number;

	/** @var string */
	private $card_expiry_date;

	/** @var string */
	private $card_cvv;

	/** @var string */
	private $nit;

	public function __construct(CardEntity $instance, callable $propertySetter)
	{
		$this->instance = $instance;
		$this->propertySetter = $propertySetter;
	}

	/**
	 * @return CardEntity
	 * @throws MutateInstanceException
	 */
	public function build(): CardEntity
	{
		$this->validateBuild();
		$this->setProperty('card_number', $this->card_number);
		$this->setProperty('card_expiry_date', $this->card_expiry_date);
		$this->setProperty('card_cvv', $this->card_cvv);
		$this->setProperty('nit', $this->nit);
		unset($this->propertySetter);
		return $this->instance;
	}

	/**
	 * @param string $name
	 * @param $value
	 * @return CardEntityBuilder
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

	public function with_card_number(string $card_number): self
	{
		$this->card_number = $card_number;
		return $this;
	}

	public function with_card_expiry_date(string $card_expiry_date): self
	{
		$this->card_expiry_date = $card_expiry_date;
		return $this;
	}

	public function with_card_cvv(string $card_cvv): self
	{
		$this->card_cvv = $card_cvv;
		return $this;
	}

	public function with_nit(string $nit): self
	{
		$this->nit = $nit;
		return $this;
	}

	private function validateBuild(): void {
		StringValidator::isNotEmpty($this->card_number, 'Parameter card_number cannot be empty');
		StringValidator::isNotEmpty($this->card_expiry_date, 'Parameter card_expiry_date cannot be empty');
		StringValidator::isNotEmpty($this->card_cvv, 'Parameter card_cvv cannot be empty');
		StringValidator::isNotEmpty($this->nit, 'Parameter nit cannot be empty');
	}
}
