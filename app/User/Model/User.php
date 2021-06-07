<?php

namespace SimpleMessenger\User\Model;

/**
 * Class User
 */
class User extends \SimpleMessenger\Core\Model\AbstractModel
{
	use \SimpleMessenger\Core\Model\IdTrait;
	use \SimpleMessenger\Core\Model\CudLogTrait;

	/** @var string $name */
	protected $name;

	/** @var string $surname */
	protected $surname;

	/** @var string $email */
	protected $email;

	/** @var string $password */
	protected $password;

	/** @var string $api_key */
	protected $api_key;


	/** @inheritDoc */
	public function initialize()
	{
		$this->setSchema('simple_messenger');
		$this->setSource('user');
		$this->initCudLog();
	}

	/**
	 * @return string
	 */
	public function getName()
	{
		return $this->name;
	}

	/**
	 * @param string $name
	 * @return self
	 */
	public function setName($name): self
	{
		$this->name = $name;
		return $this;
	}

	/**
	 * @return string
	 */
	public function getSurname()
	{
		return $this->surname;
	}

	/**
	 * @param string $surname
	 * @return self
	 */
	public function setSurname($surname): self
	{
		$this->surname = $surname;
		return $this;
	}

	/**
	 * @return string
	 */
	public function getEmail()
	{
		return $this->email;
	}

	/**
	 * @param string $email
	 * @return self
	 */
	public function setEmail($email): self
	{
		$this->email = $email;
		return $this;
	}

	/**
	 * @return string
	 */
	public function getPassword()
	{
		return $this->password;
	}

	/**
	 * @param string $password
	 * @return self
	 */
	public function setPassword($password): self
	{
		$this->password = $password;
		return $this;
	}

	/**
	 * @return string
	 */
	public function getApiKey()
	{
		return $this->api_key;
	}

	/**
	 * @param string $apiKey
	 * @return self
	 */
	public function setApiKey($apiKey): self
	{
		$this->api_key = $apiKey;
		return $this;
	}

	/**
	 * Find user by api key
	 *
	 * @param string $apiKey
	 * @return \Phalcon\Mvc\ModelInterface|null
	 */
	public static function findByApiKey(string $apiKey)
	{
		return self::findFirst([
			'conditions' => 'api_key = ?1',
			'bind'       => [
				1 => $apiKey,
			]
		]);
	}

	/**
	 * Find user by email
	 *
	 * @param string $email
	 * @return \Phalcon\Mvc\ModelInterface|null
	 */
	public static function findByEmail(string $email)
	{
		return self::findFirst([
			'conditions' => 'email = ?1',
			'bind'       => [
				1 => $email,
			]
		]);
	}

	/**
	 * Before user create
	 */
	public function beforeCreate()
	{
		$this->setApiKey(\Nette\Utils\Random::generate(32, '0-9a-zA-Z'));
	}

	/**
	 * Before user save
	 */
	public function beforeSave()
	{
		$this->setPassword(password_hash($this->getPassword(), PASSWORD_BCRYPT, ['cost' => 12]));
	}

	/**
	 * User validation
	 *
	 * @return bool
	 */
	public function validation()
	{
		$validator = new \Phalcon\Validation();

		$validator->add(
			[
				'name',
				'surname',
				'email',
				'password',
			],
			new \Phalcon\Validation\Validator\PresenceOf(
				[
					'message' => [
						'name' => 'The user name is required',
						'surname' => 'The user surname is required',
						'email' => 'The user email is required',
						'password' => 'The user password is required',
					],
				]
			)
		);

		$validator->add(
			'email',
			new \Phalcon\Validation\Validator\Email(
				[
					'message' => 'The user email is not valid',
				]
			)
		);

		$validator->add(
			'email',
			new \Phalcon\Validation\Validator\Uniqueness(
				[
					'message' => 'The user email already exists',
				]
			)
		);

		return $this->validate($validator);
	}
}