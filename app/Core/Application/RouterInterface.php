<?php

namespace SimpleMessenger\Core\Application;

/**
 * RouterInterface
 */
interface RouterInterface
{
	/**
	 * Register routes
	 * @param \Phalcon\Mvc\Router $router
	 */
	public function register(\Phalcon\Mvc\Router $router);
}