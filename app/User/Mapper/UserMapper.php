<?php

namespace SimpleMessenger\User\Mapper;

/**
 * UserMapper
 */
class UserMapper extends \SimpleMessenger\Core\Mapper\AbstractMapper
{
	use \SimpleMessenger\Core\Mapper\CudLogMapperTrait;

	/** @var bool $includeApiKey */
	protected bool $includeApiKey = false;

	/**
	 * @inheritDoc
	 * @param \SimpleMessenger\User\Model\User $source
	 */
	public function map($source, int $depth = 0): array
	{
		$output = [];

		$output['id'] = $source->getId();
		$output['name'] = $source->getName();
		$output['surname'] = $source->getSurname();
		$output['email'] = $source->getEmail();

		if ($this->includeApiKey) {
			$output['apiKey'] = $source->getApiKey();
		}

		// Prevent from infinite looping
		if ($depth <= $this->maxDepth) {
			$output = array_merge($output, $this->mapCudLog($source, ++$depth));
		}

		return $output;
	}

	/**
	 * @param bool $includeApiKey
	 * @return self
	 */
	public function setIncludeApiKey(bool $includeApiKey): self
	{
		$this->includeApiKey = $includeApiKey;
		return $this;
	}
}