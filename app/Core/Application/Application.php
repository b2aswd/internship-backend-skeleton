<?php

namespace SimpleMessenger\Core\Application;

/**
 * Application
 */
class Application extends \Phalcon\Mvc\Application
{
	/** @var string Application version */
	public const VERSION = '1.0';


	/** @inheritDoc */
	public function __construct(\Phalcon\Di\DiInterface $container = null)
	{
		parent::__construct($container);

		\Phalcon\Mvc\Model::setup([
			'notNullValidations' => false
		]);
	}

	/** @inheritDoc */
	public function handle(string $uri)
	{
		try {
			return parent::handle($uri);
		} catch (\Throwable $exception) {
			if (
				$exception instanceof \Phalcon\Mvc\Dispatcher\Exception
				&& $exception->getCode() === \Phalcon\Dispatcher\Exception::EXCEPTION_HANDLER_NOT_FOUND
			) {
				$exception = new \SimpleMessenger\Core\Exception\BaseException('Handler not found', 404, $exception);
			} elseif (
				$exception instanceof \Phalcon\Mvc\Dispatcher\Exception
				&& $exception->getCode() === \Phalcon\Dispatcher\Exception::EXCEPTION_ACTION_NOT_FOUND
			) {
				$exception = new \SimpleMessenger\Core\Exception\BaseException('Action not found', 404, $exception);
			} elseif (!($exception instanceof \SimpleMessenger\Core\Exception\BaseException)) {
				$exception = new \SimpleMessenger\Core\Exception\BaseException($exception->getMessage(), 500, $exception);
			}

			return $exception->toResponse()->send();
		}
	}

	/**
	 * Register routes in all modules
	 */
	public function registerRoutes()
	{
		$routerGlobPath = APP_PATH . '/*/Router.php';
		foreach (glob($routerGlobPath) as $routerPath) {
			require_once($routerPath);
		}

		foreach (get_declared_classes() as $routerClass) {
			$reflectionClass = new \ReflectionClass($routerClass);
			if ($reflectionClass->implementsInterface(RouterInterface::class)) {
				$routerInstance = $reflectionClass->newInstance();
				$routerInstance->register($this->router);
			}
		}
	}
}