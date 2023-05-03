<?php

namespace Core;

class Libs
{

	public static function response(array $res = []): void
	{
		header('Content-Type: application/json; charset=utf-8');
		echo json_encode($res);
		return;
	}

}