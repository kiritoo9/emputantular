<?php

namespace Core;

use Core\Core;

class Routes extends Core
{

	private array $routes = [];
	private string $group = '';
	private $notFoundHandler = null;
	public array $ENV = [];

	public function __construct()
	{
		$this->ENV = $_ENV;
	}

	public function group(string $path, ...$params)
	{
		$callback = array_pop($params);
		$this->group = $path;

		if (is_callable($callback)) 
			$callback($this);

		$this->group = '';
	}

	public function get(string $path, ...$params): void
	{
		$this->addCallback('GET', $path, $params);
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

	public function run(): void
	{
		$uri = parse_url($_SERVER['REQUEST_URI']);
		$path = $uri['path'];
		$method = $_SERVER['REQUEST_METHOD'];

		$activeRoute = null;
		foreach ($this->routes as $route) {
			if($route['path'] === $path && $route['method'] === $method) {
				$activeRoute = $route['callback'];
			}
		}

		if(!$activeRoute) {
			echo "page is not found!";
			return;
		}

		call_user_func_array($activeRoute, [
			array_merge($_GET, $_POST)
		]);
	}

	/**
	 * Small function for routes
	 * 
	*/
	public function response(array $callback = []): void
	{

	}
}