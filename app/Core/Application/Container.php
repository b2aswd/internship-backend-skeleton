<?php

namespace SimpleMessenger\Core\Application;

/**
 * Container
 */
class Container
{
	/**
	 * @return \Phalcon\Di
	 */
	public function getDefault(): \Phalcon\Di
	{
		$container = new \Phalcon\Di\FactoryDefault();

		$container->setShared('url', function () {
			$url = new \Phalcon\Url();
			$url->setBaseUri('/');

			return $url;
		});

		$container->setShared(
			'dispatcher',
			function () {
				$dispatcher = new \Phalcon\Mvc\Dispatcher();
				$dispatcher->setEventsManager(new \Phalcon\Events\Manager());
				return $dispatcher;
			}
		);

		$container->setShared(
			'router',
			function () {
				return new \Phalcon\Mvc\Router(false);
			}
		);

		$container->setShared(
			'response',
			function () {
				$response = new \Phalcon\Http\Response();
				$response->setContentType('application/json', 'utf-8');

				return $response;
			}
		);

		$container->setShared(
			'db',
			function () {
				return new \Phalcon\Db\Adapter\Pdo\Postgresql(
					[
						'host'     => getenv('POSTGRES_HOST'),
						'username' => getenv('POSTGRES_USER'),
						'password' => getenv('POSTGRES_PASSWORD'),
						'dbname'   => getenv('POSTGRES_DB'),
					]
				);
			}
		);

		$container->setShared(
			\SimpleMessenger\Core\Service\MqttService::class,
			function () {
				return new \SimpleMessenger\Core\Service\MqttService(
					getenv('EMQX_HOST'),
					getenv('EMQX_TCP_PORT')
				);
			}
		);

		return $container;
	}
}