<?php

namespace Core;

class Routes
{

	private array $routes = [];
	private $notFoundHandler = null;

	public function get(string $path, $callback): void
	{
		$this->addCallback('GET', $path, $callback);
	}

	private function addCallback(string $method, string $path, $callback): void
	{
		$this->routes[$method . $path] = [
			'path' => $path,
			'method' => $method,
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
}