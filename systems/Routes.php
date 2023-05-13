<?php

namespace Empu;

/**
 * Empu-Route Module
 * -------
 * Routes
 * Handle routes from modules/routes.php
 * Method supports: [GET, POST, PUT, DELETE]
 * 
 * @package Emputantular Core
 * @author kiritoo9
 * @version 2.0.0
*/

use Empu\Core;
use Middlewares;

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

	public function post(string $path, ...$params): void
	{
		$this->addCallback('POST', $path, $params);
	}

	public function put(string $path, ...$params): void
	{
		$this->addCallback('PUT', $path, $params);
	}

	public function delete(string $path, ...$params): void
	{
		$this->addCallback('DELETE', $path, $params);
	}

	public function notFoundHandler($handler): void
	{
		$this->notFoundHandler = $handler;
	}

	private function addCallback(string $method, string $path, $params): void
	{
		$uri = parse_url($_SERVER['REQUEST_URI']);
		$callback = array_pop($params);

		$_path = $path;
		$_path = explode("/", $path);
		$cleanPath = '';
		$parameters = [];
		foreach ($_path as $urlparam) {
			if(str_contains($urlparam, '$')) {
				$urlparam = str_replace('{', '', str_replace('}', '', str_replace('$', '', $urlparam)));
				$parameters[] = [
					'name' => $urlparam,
					'value' => null
				];
			} elseif($urlparam) {
				$cleanPath .= "/{$urlparam}";
			}
		}

		if(count($parameters) > 0) {
			$path_array = explode('/', $uri['path']);
			$skip = (count($path_array)-count($parameters))-1;
			$index = 0;
			for($i = 0; $i < count($path_array); $i++) {
				if($i > $skip) {
					$parameters[$index]['value'] = $path_array[$i];
					$index++;
				}
			}
		}

		$this->routes[$method . $this->group . $path] = [
			'path' => $this->group . $cleanPath,
			'method' => $method,
			'middlewares' => $params,
			'callback' => $callback,
			'parameters' => $parameters
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

		$pageHandler = [];
		$paramHandler = [];
		$middlewareHandler = [];
		foreach ($this->routes as $route) {
			if(str_contains(strtolower($path), strtolower($route['path'])) && $route['method'] === $method) {
				$pageHandler[] = $route;
			}
		}

		if(count($pageHandler) === 1) {
			if(strtolower($pageHandler[0]['path']) === strtolower(($path == '/' ? '' : $path))) {
				$pageHandler = $pageHandler[0]['callback'];
			} else {
				$pageHandler = null;
			}
		} else if(count($pageHandler) < 1) {
			$pageHandler = null;
		} else {
			$exists = false;
			foreach ($pageHandler as $handler) {
				$totalParams = count($handler['parameters']);
				$path_array = explode('/', $path);
				for($i = 0; $i < $totalParams; $i++) {
					$handler['path'] .= "/{$i}";
				}

				if(count(explode('/', $handler['path'])) === count($path_array)) {
					if($totalParams <= 0) {
						if(strtolower($path) !== strtolower($handler['path'])) break;
					}
					$exists = true;
					$pageHandler = $handler['callback'];
					$middlewareHandler = $handler['middlewares'][0] ?? [];
					foreach ($handler['parameters'] as $param) {
						$paramHandler[$param['name']] = $param['value'];
					}
					break;
				}
			}
			if(!$exists)
				$pageHandler = null;
		}

		if(!$pageHandler) {
			header("HTTP/1.0 404 Not Found");
			if($this->notFoundHandler) {
				$pageHandler = $this->notFoundHandler;
			} else {
				require_once __DIR__ . '/errors/html/404.php';
				return;
			}
		}

		if (is_string($pageHandler)) {
			$parts = explode('::', $pageHandler);
			if (is_array($parts)) {
				$className = array_shift($parts);
				$handler = new $className;

				$method = array_shift($parts);
				$pageHandler = [$handler, $method];
			}
		}

		/**
		 * Handler middlewares
		*/

		if (is_array($middlewareHandler)) {
			foreach ($middlewareHandler as $mware) {
				$mware_arr = explode('::', $mware);
				if(count($mware_arr) <= 0) 
					break 1;

				$clsname = "\Middlewares\\{$mware_arr[0]}";
				$middleware_init = new $clsname();
				$response = $middleware_init->init($_SERVER, $mware_arr[1] ?? null);
				if($response) {
					header("HTTP/1.0 501 Unauthorized");
					require_once __DIR__ . '/errors/html/501.php';
					return;
				}
			}
		}

		call_user_func_array($pageHandler, [
			array_merge($_GET, $_POST, $paramHandler)
		]);
	}

}