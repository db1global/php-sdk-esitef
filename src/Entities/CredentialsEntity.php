<?php

namespace DB1\Acquirer\ESitef\Entities;

use DB1\Acquirer\ESitef\Exceptions\MutateInstanceException;

class CredentialsEntity
{
	/** @var string */
	private $merchant_id;

	/** @var string */
	private $merchant_key;

	private function __construct(){}

	public static function builder(): CredentialsEntityBuilder
	{
		$instance = new self();
		$propertySetter = function ($name, $value) use ($instance) {
			$instance->{$name} = $value;
		};

		return new CredentialsEntityBuilder($instance, $propertySetter);
	}
	
	public function getMerchantId(): string 
	{
		return $this->merchant_id;
	}
	
	public function getMerchantKey(): string 
	{
		return $this->merchant_key;
	}
}

class CredentialsEntityBuilder
{
	/** @var string */
	private $merchant_id;

	/** @var string */
	private $merchant_key;

	public function __construct(CredentialsEntity $instance, callable $propertySetter)
	{
		$this->instance = $instance;
		$this->propertySetter = $propertySetter;
	}

	/**
	 * @return CredentialsEntity
	 * @throws MutateInstanceException
	 */
	public function build(): CredentialsEntity
	{
		$this->validateBuild();
		$this->setProperty('merchant_id', $this->merchant_id);
		$this->setProperty('merchant_key', $this->merchant_key);
		unset($this->propertySetter);
		return $this->instance;
	}

	/**
	 * @param string $name
	 * @param $value
	 * @return CredentialsEntityBuilder
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

	public function with_merchant_id(string $merchant_id): self
	{
		$this->merchant_id = $merchant_id;
		return $this;
	}

	public function with_merchant_key(string $merchant_key): self
	{
		$this->merchant_key = $merchant_key;
		return $this;
	}

	private function validateBuild(): void {
		if(!$this->merchant_id){
			throw new \InvalidArgumentException('Parameter merchant_id cannot be empty');
		}
		if(!$this->merchant_key){
			throw new \InvalidArgumentException('Parameter merchant_key cannot be empty');
		}
	}
}
