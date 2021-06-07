<?php
require(__DIR__ . '/../vendor/autoload.php');

define('BASE_PATH', dirname(__DIR__));
define('APP_PATH', BASE_PATH . '/app');

// Preflight
if (isset($_SERVER['HTTP_ORIGIN'])) {
	if ($_SERVER['REQUEST_METHOD'] == 'OPTIONS') {
		echo '1';
		exit;
	}
}

$loader = new \Phalcon\Loader();

$loader->registerNamespaces(
	[
		'SimpleMessenger\Core' => APP_PATH . '/Core/',
		'SimpleMessenger\User' => APP_PATH . '/User/',
	]
);

$loader->register();

$container = (new \SimpleMessenger\Core\Application\Container())->getDefault();

$application = new \SimpleMessenger\Core\Application\Application($container);
$application->useImplicitView(false);
$application->registerRoutes();

$application->handle($_SERVER["REQUEST_URI"]);