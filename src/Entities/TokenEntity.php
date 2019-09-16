<?php

namespace DB1\Acquirer\ESitef\Entities;

use DB1\Acquirer\ESitef\Exceptions\MutateInstanceException;
use DB1\Acquirer\ESitef\Validators\StringValidator;

class TokenEntity
{
	/** @var string */
	private $token;

	/** @var string */
	private $card_cvv;

	private function __construct(){}

	public static function builder(): TokenEntityBuilder
	{
		$instance = new self();
		$propertySetter = function ($name, $value) use ($instance) {
			$instance->{$name} = $value;
		};

		return new TokenEntityBuilder($instance, $propertySetter);
	}

	public function getToken(): string
	{
		return $this->token;
	}

	public function getCardCvv(): string
	{
		return $this->card_cvv;
	}
}

class TokenEntityBuilder
{
	/** @var string */
	private $token;

	/** @var string */
	private $card_cvv;

	public function __construct(TokenEntity $instance, callable $propertySetter)
	{
		$this->instance = $instance;
		$this->propertySetter = $propertySetter;
	}

	/**
	 * @return TokenEntity
	 * @throws MutateInstanceException
	 */
	public function build(): TokenEntity
	{
		$this->validateBuild();
		$this->setProperty('token', $this->token);
		$this->setProperty('card_cvv', $this->card_cvv);
		unset($this->propertySetter);
		return $this->instance;
	}

	/**
	 * @param string $name
	 * @param $value
	 * @return TokenEntityBuilder
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

	public function with_token(string $token): self
	{
		$this->token = $token;
		return $this;
	}

	public function with_card_cvv(string $card_cvv): self
	{
		$this->card_cvv = $card_cvv;
		return $this;
	}

	private function validateBuild(): void {
		StringValidator::isNotEmpty($this->token, 'Parameter token cannot be empty');
		StringValidator::isNotEmpty($this->card_cvv, 'Parameter card_cvv cannot be empty');
	}
}
