<?php

namespace SimpleMessenger\Core\Mapper;

/**
 * CudLogMapperTrait
 */
trait CudLogMapperTrait
{
	/**
	 * Map CudLog fields
	 *
	 * @param mixed $source
	 * @param int $depth
	 * @return array
	 */
	protected function mapCudLog($source, int $depth = 0): array
	{
		return [
			'created' => ($source->getCreated() instanceof \DateTime) ? $source->getCreated()->format('Y-m-d\TH:i:s.v\Z') : null,
			'createdBy' => ($source->getCreatedBy() instanceof \SimpleMessenger\User\Model\User) ? (new \SimpleMessenger\User\Mapper\UserMapper())->map($source->getCreatedBy(), $depth) : null,
			'updated' => ($source->getUpdated() instanceof \DateTime) ? $source->getUpdated()->format('Y-m-d\TH:i:s.v\Z') : null,
			'updatedBy' => ($source->getUpdatedBy() instanceof \SimpleMessenger\User\Model\User) ? (new \SimpleMessenger\User\Mapper\UserMapper())->map($source->getUpdatedBy(), $depth) : null,
		];
	}
}