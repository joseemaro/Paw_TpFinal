<?php

namespace App\Core;

use Monolog\Logger as MonologLogger;
use Monolog\Handler\StreamHandler;

final class Logger
{
	/**
	 * Implementa Singleton del Logger
	 * @return Logger La instancia del Logger
	 */
	public static function getLogger($level)
	{
		static $instancia = null;
		if ( is_null($instancia) ) {
			$instancia = new MonologLogger('mvc_logger');
			$instancia->pushHandler(new StreamHandler('logs/mvc.log', $level));
		}
		return $instancia;
	}

	/**
	 * Evitamos que pueda ser instanciado desde afuera
	 */
	private function __construct()
	{

	}
}