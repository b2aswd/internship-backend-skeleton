<?php

namespace SimpleMessenger\Core\Exception;

use Throwable;

/**
 * BaseException
 */
class BaseException extends \Exception
{
	/** @var string[] $messages */
	protected array $messages = [];


	/**
	 * ControllerException constructor.
	 * @param string[]|string $messages
	 * @param int $code
	 * @param Throwable|null $previous
	 */
	public function __construct($messages = null, $code = 0, Throwable $previous = null)
	{
		if (is_string($messages)) {
			$this->messages[] = $messages;
		} elseif (is_array($messages)) {
			$this->messages = $messages;
		}

		parent::__construct('', $code, $previous);
	}

	/**
	 * @return string[]
	 */
	public function getMessages(): array
	{
		return $this->messages;
	}

	/**
	 * Convert exception to HTTP response
	 *
	 * @return \Phalcon\Http\Response
	 */
	public function toResponse(): \Phalcon\Http\Response
	{
		$response = new \Phalcon\Http\Response();

		$response->setStatusCode($this->getCode());
		$response->setJsonContent([
			'version' => \SimpleMessenger\Core\Application\Application::VERSION,
			'error' => true,
			'messages' => $this->getMessages(),
		]);

		return $response;
	}
}