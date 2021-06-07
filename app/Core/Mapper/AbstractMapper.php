<?php

namespace SimpleMessenger\Core\Mapper;

/**
 * AbstractMapper
 */
abstract class AbstractMapper extends \Phalcon\Di\Injectable
{
	/** @var int $maxDepth */
	protected int $maxDepth = 1;


	/**
	 * Map response from source
	 *
	 * @param mixed $source
	 * @param int $depth
	 * @return array
	 */
	abstract public function map($source, int $depth = 0): array;

	/**
	 * Map collection from source
	 *
	 * @param mixed $source
	 * @param int $depth
	 * @return array
	 */
	public function mapCollection($source, int $depth = 0): array
	{
		$output = [];

		foreach ($source as $item) {
			$output[] = $this->map($item, $depth);
		}

		return $output;
	}
}