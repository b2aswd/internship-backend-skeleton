<?php

namespace SimpleMessenger\User;

/**
 * Router
 */
class Router implements \SimpleMessenger\Core\Application\RouterInterface
{
	/** @inheritDoc */
	public function register(\Phalcon\Mvc\Router $router): void
	{
		$user = new \Phalcon\Mvc\Router\Group([
			'namespace' => 'SimpleMessenger\User',
		]);
		$user->setPrefix('/api/v1/user');

		$user->addGet('', [
			'action' => 'list',
			'controller' => 'Controller\User',
		]);

		$user->addGet('/{id:[0-9]+}', [
			'action' => 'get',
			'controller' => 'Controller\User',
		]);

		$user->addPost('', [
			'action' => 'create',
			'controller' => 'Controller\User',
		]);

		$user->addPut('/{id:[0-9]+}', [
			'action' => 'update',
			'controller' => 'Controller\User',
		]);

		$user->addDelete('/{id:[0-9]+}', [
			'action' => 'delete',
			'controller' => 'Controller\User',
		]);

		$user->addPost('/register', [
			'action' => 'register',
			'controller' => 'Controller\UserUnsecure',
		]);

		$user->addPost('/login', [
			'action' => 'login',
			'controller' => 'Controller\UserUnsecure',
		]);

		$router->mount($user);
	}
}