<?php
/* ---------------------------------------------------------
 * CLASS APP                                               *
 * --------------------------------------------------------- 
 * Entry point                                             *
 * --------------------------------------------------------- 
 * @license    MIT licence                                 *
 * @author     Antonio Carlos                              *
 * @copyright  ACFF (C) 2012                               *
 * ---------------------------------------------------------
 * * * * * * * * * * * * * * * * * * * * * * * * * * * * * *
*/ 
namespace Acffdev\PhpCore;

class App
{
	/**
	 * SETTINGS
	 * 
	 * stores all settings globally
	 * 
	 * @return array
	*/
	public static $settings = array();
		
	/**
	 * RUN
	 * 
	 * Starts everything ... 
	 * 
	 * @return void
	 */
	public static function run()
	{
		//root path
		define('ROOT_PATH', dirname(__DIR__, 4) . DIRECTORY_SEPARATOR);

		// load enviroment variables
		self::loadEnviromentVars('.env');

		// app path
		define('APP_PATH', ROOT_PATH . getenv('FOLDER_APP') . DIRECTORY_SEPARATOR);

		// public path
		define('PUBLIC_PATH', ROOT_PATH . getenv('FOLDER_PUBLIC') . DIRECTORY_SEPARATOR);

		// router
		$router = new Router;
		$router->dispatch();
	}

	/**
	 * SET
	 * 
	 * ... 
	 * 
	 * @param string $key
	 * @param mixed $value
	 * @return void
	 */
	public static function set($key, $value)
	{
		self::$settings[$key] = $value;
	}

	/**
	 * LOAD ENVIROMENT VARS
	 * 
	 * ...
	 * 
	 * @param string $file
	 * @return void
	 */
	public static function loadEnviromentVars($file = '.env')
	{
		// check if .env file exists
		if (!file_exists($filename = ROOT_PATH . $file))
			throw new \Exception("Create a .env file in root directory, see .env.example file.");

		// get env vars
		$envs = file($filename, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);

		// put env into app
		foreach ($envs as $env) putenv(trim(str_replace('"', '', $env)));   
	}

	/* forbids instances */
	private function __construct(){}
	private function __clone(){}
}
