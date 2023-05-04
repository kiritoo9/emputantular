<?php

namespace Core;

use Core\Core;

class Routes extends Core
{

	private array $routes = [];
	private string $group = '';
	private $notFoundHandler = null;
	public static array $ENV = [];

	public function __construct()
	{
		self::$ENV = $_ENV;
	}

	public function group(string $path, ...$params)
	{
		$callback = array_pop($params);
		$this->group .= $path;

		if (is_callable($callback)) 
			$callback($this);

		$this->last();
	}

	public function get(string $path, ...$params): void
	{
		$this->addCallback('GET', $path, $params);
	}

	public function notFoundHandler($handler): void
	{
		$this->notFoundHandler = $handler;
	}

	private function addCallback(string $method, string $path, $params): void
	{
		$callback = array_pop($params);
		$this->routes[$method . $this->group . $path] = [
			'path' => $this->group . $path,
			'method' => $method,
			'middlewares' => $params,
			'callback' => $callback
		];
	}

	private function last(): void
	{
		$group = $this->group;
		$group = explode('/', $group);
		$_group = '';
		for($i = 0; $i < (count($group)-1); $i++) {
			if($group[$i]) $_group .= "/{$group[$i]}";
		}

		$this->group = $_group;
	}

	public function run(): void
	{
		$uri = parse_url($_SERVER['REQUEST_URI']);
		$path = $uri['path'];
		$method = $_SERVER['REQUEST_METHOD'];

		$pageHandler = null;
		foreach ($this->routes as $route) {
			if($route['path'] === $path && $route['method'] === $method) {
				$pageHandler = $route['callback'];
			}
		}

		if(!$pageHandler) {
			header("HTTP/1.0 404 Not Found");
			if($this->notFoundHandler) {
				$pageHandler = $this->notFoundHandler;
			} else {
				echo "page is not found!";
				return;
			}
		}

		call_user_func_array($pageHandler, [
			array_merge($_GET, $_POST)
		]);
	}

}