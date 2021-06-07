<?php

namespace SimpleMessenger\Core\Model;

/**
 * AbstractModel
 */
abstract class AbstractModel extends \Phalcon\Mvc\Model
{
	/**
	 * Initialize model
	 */
	abstract public function initialize();

	/** @inheritDoc */
	public function save(): bool
	{
		if (!parent::save()) {
			if (!empty($this->getValidationErrors())) {
				throw new \SimpleMessenger\Core\Exception\BaseException($this->getValidationErrors(), 400);
			}

			throw new \SimpleMessenger\Core\Exception\BaseException(get_class($this) . " cannot be saved", 500);
		}

		return true;
	}

	/** @inheritDoc */
	public function delete(): bool
	{
		 if (!parent::delete()) {
			 throw new \SimpleMessenger\Core\Exception\BaseException(get_class($this) . " cannot be deleted", 500);
		 }

		 return true;
	}

	/**
	 * Get validation errors
	 *
	 * @return array
	 */
	public function getValidationErrors(): array
	{
		$messages = [];

		foreach (parent::getMessages() as $message) {
			if (is_subclass_of($message->getType(), \Phalcon\Validation\AbstractValidator::class)) {
				$messages[] = $message->getMessage();
			}
		}

		return $messages;
	}
}