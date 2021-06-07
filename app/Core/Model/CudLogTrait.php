<?php

namespace SimpleMessenger\Core\Model;

/**
 * CudLogTrait (without soft delete)
 */
trait CudLogTrait
{
	/** @var int|null $created_by_id */
	protected $created_by_id;

	/** @var \DateTime|null $created */
	protected $created;

	/** @var int|null $updated_by_id */
	protected $updated_by_id;

	/** @var \DateTime|null $updated */
	protected $updated;


	/**
	 * Init CudLog relations
	 */
	public function initCudLog()
	{
		$this->belongsTo(
			'created_by_id', '\SimpleMessenger\User\Model\User', 'id',
			[
				'alias' => 'createdBy'
			]
		);

		$this->belongsTo(
			'updated_by_id', '\SimpleMessenger\User\Model\User', 'id',
			[
				'alias' => 'updatedBy'
			]
		);

		$this->addBehavior(
			new \Phalcon\Mvc\Model\Behavior\Timestampable(
				[
					'beforeCreate' => [
						'field'  => 'created',
						'format' => 'Y-m-d\TH:i:s.v\Z',
					]
				]
			)
		);

		$this->addBehavior(
			new \Phalcon\Mvc\Model\Behavior\Timestampable(
				[
					'beforeUpdate' => [
						'field'  => 'updated',
						'format' => 'Y-m-d\TH:i:s.v\Z',
					]
				]
			)
		);
	}

	/**
	 * @return \SimpleMessenger\User\Model\User|null
	 */
	public function getCreatedBy(): ?\SimpleMessenger\User\Model\User
	{
		return $this->getRelated('createdBy');
	}

	/**
	 * @param \SimpleMessenger\User\Model\User|null $createdBy
	 * @return self
	 */
	public function setCreatedBy(?\SimpleMessenger\User\Model\User $createdBy): self
	{
		$this->__set('createdBy', $createdBy);
		return $this;
	}

	/**
	 * @return \DateTime|null
	 */
	public function getCreated(): ?\DateTime
	{
		return ($this->created) ? new \DateTime($this->created) : null;
	}

	/**
	 * @param \DateTime|null $created
	 * @return self
	 */
	public function setCreated(?\DateTime $created): self
	{
		$this->created = $created;
		return $this;
	}

	/**
	 * @return \SimpleMessenger\User\Model\User|null
	 */
	public function getUpdatedBy(): ?\SimpleMessenger\User\Model\User
	{
		return $this->getRelated('updatedBy');
	}

	/**
	 * @param \SimpleMessenger\User\Model\User|null $updatedBy
	 * @return self
	 */
	public function setUpdatedBy(?\SimpleMessenger\User\Model\User $updatedBy): self
	{
		$this->__set('updatedBy', $updatedBy);
		return $this;
	}

	/**
	 * @return \DateTime|null
	 */
	public function getUpdated(): ?\DateTime
	{
		return ($this->updated) ? new \DateTime($this->updated) : null;
	}

	/**
	 * @param \DateTime|null $updated
	 * @return self
	 */
	public function setUpdated(?\DateTime $updated): self
	{
		$this->updated = $updated;
		return $this;
	}
}