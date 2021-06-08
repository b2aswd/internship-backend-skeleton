<?php

namespace SimpleMessenger\Core\Controller;

/**
 * AbstractSecureController
 */
abstract class AbstractController extends \Phalcon\Mvc\Controller
{
	/** @var \SimpleMessenger\User\Model\User|null $user */
	protected ?\SimpleMessenger\User\Model\User $user = null;


	/**
	 * @param \Phalcon\Mvc\Dispatcher $dispatcher
	 */
	public function beforeExecuteRoute(\Phalcon\Mvc\Dispatcher $dispatcher)
	{
		$this->authenticate();
	}

	/**
	 * @param \Phalcon\Mvc\Dispatcher $dispatcher
	 */
	public function afterExecuteRoute(\Phalcon\Mvc\Dispatcher $dispatcher)
	{
		$this->response->setStatusCode(200);
		$this->response->setJsonContent([
			'version' => \SimpleMessenger\Core\Application\Application::VERSION,
			'error' => false,
			'data' => $dispatcher->getReturnedValue(),
		])->send();
	}

	/**
	 * Authenticate user by api key
	 */
	public function authenticate()
	{
		$headers = getallheaders();

		if (!isset($headers['Authorization']) && !isset($headers['authorization'])) {
			throw new \SimpleMessenger\Core\Exception\BaseException("Authorization header missing", 400);
		}

		$authorizationHeader = (isset($headers['Authorization'])) ? $headers['Authorization'] : $headers['authorization'];

		$apiKey = '';
		$matches = [];
		if (preg_match("/Basic ([0-9a-zA-Z]*)/", $authorizationHeader, $matches)) {
			$apiKey = $matches[1];
		}

		if (empty($apiKey)) {
			throw new \SimpleMessenger\Core\Exception\BaseException("ApiKey is missing from request headers", 401);
		}

		$user = \SimpleMessenger\User\Model\User::findByApiKey($apiKey);

		if (!($user instanceof \SimpleMessenger\User\Model\User)) {
			throw new \SimpleMessenger\Core\Exception\BaseException("Authenticating failed", 401);
		}

		$this->user = $user;
	}
}