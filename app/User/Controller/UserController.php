<?php

namespace SimpleMessenger\User\Controller;

/**
 * UserController
 */
class UserController extends \SimpleMessenger\Core\Controller\AbstractController
{
	/** @var \SimpleMessenger\User\Mapper\UserMapper $mapper */
	protected \SimpleMessenger\User\Mapper\UserMapper $mapper;


	/**
	 * Initialize User controller
	 */
	public function initialize()
	{
		$this->mapper = new \SimpleMessenger\User\Mapper\UserMapper();
	}

	/**
	 * Return mapped collection of all users
	 *
	 * @return array
	 */
	public function listAction(): array
	{
		$users = \SimpleMessenger\User\Model\User::find();

		return $this->mapper->mapCollection($users);
	}

	/**
	 * Return mapped user by given id
	 * Throw exception if user with given id does not exist
	 *
	 * @param int $id
	 * @return array
	 * @throws \SimpleMessenger\Core\Exception\BaseException
	 */
	public function getAction(int $id): array
	{
		$user = \SimpleMessenger\User\Model\User::findFirst($id);
		if (!($user instanceof \SimpleMessenger\User\Model\User)) {
			throw new \SimpleMessenger\Core\Exception\BaseException("User with ID: $id not found.", 404);
		}

		return $this->mapper->map($user);
	}

	/**
	 * Create user from request data
	 *
	 * @return array
	 * @throws \SimpleMessenger\Core\Exception\BaseException
	 */
	public function createAction(): array
	{
		$body = $this->request->getJsonRawBody();

		$user = (new \SimpleMessenger\User\Model\User())
			->setName($body->name)
			->setSurname($body->surname)
			->setEmail($body->email)
			->setPassword($body->password);

		if ($this->user instanceof \SimpleMessenger\User\Model\User) {
			$user->setCreatedBy($this->user);
		}

		$user->save();

		return $this->mapper->map($user);
	}

	/**
	 * Update user with given id
	 * Throw exception if user with given id does not exist
	 *
	 * @param int $id
	 * @return array
	 * @throws \SimpleMessenger\Core\Exception\BaseException
	 */
	public function updateAction(int $id): array
	{
		$user = \SimpleMessenger\User\Model\User::findFirst($id);
		if (!($user instanceof \SimpleMessenger\User\Model\User)) {
			throw new \SimpleMessenger\Core\Exception\BaseException("User with ID: $id not found.", 404);
		}

		$body = $this->request->getJsonRawBody();

		$user
			->setName($body->name)
			->setSurname($body->surname)
			->setEmail($body->email)
			->setPassword($body->password)
			->setUpdatedBy($this->user);

		$user->save();

		return $this->mapper->map($user);
	}

	/**
	 * Delete user with given id
	 * Throw exception if user with given id does not exist
	 *
	 * @param int $id
	 * @return array
	 * @throws \SimpleMessenger\Core\Exception\BaseException
	 */
	public function deleteAction(int $id): array
	{
		$user = \SimpleMessenger\User\Model\User::findFirst($id);
		if (!($user instanceof \SimpleMessenger\User\Model\User)) {
			throw new \SimpleMessenger\Core\Exception\BaseException("User with ID: $id not found.", 404);
		}

		$user->delete();

		return [];
	}
}