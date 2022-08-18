<?php 
/* ---------------------------------------------------------
 * CLASSE ROUTER                                           *
 * ---------------------------------------------------------
 * Route manager                                           *
 * ---------------------------------------------------------
 * @license    MIT licence                                 *
 * @author     Antonio Carlos                              *
 * @copyright  ACFF (C) 2012                               *
 * ---------------------------------------------------------
 * * * * * * * * * * * * * * * * * * * * * * * * * * * * * *
*/
namespace Acffdev\PhpCore;

class Router
{
	/**
	 * REQUEST
	 *
	 * stores request object
	 */
	private $request;

	/**
	 * RESPONSE
	 *
	 * stores response object
	 */
	private $response;

	/**
	 * CONSTRUCT
	 *
	 * instantiates request and response objects
	 */
	public function __construct()
	{
		$this->request = new Request;
		$this->response = new Response;		
	}

	/**
	 * DISPATCH
	 *
	 * dispatches routes
	 * 
	 * @return void;
	 */
	public function dispatch()
	{
		// get controller namespace
		$controller = $this->namespace($this->request->controller);

		// check if controller exists
		if (!class_exists($controller))
			$this->response->send(404, "404 | Page not found.");
			
		// cache handler
		if ($cache = $this->cacheHandler(Utils::cacheFile($this->request->uri)))
			$this->response->send(200, $cache);
		
		// call user controller
		$this->controllerHandler($controller, $this->request->action);
	}

	/**
	 * NAMESPACE
	 *
	 * generates a controller namespace studlycase
	 * replacing dashes.
	 * EX: http://localhost/user-profile will generate UserProfile 
	 * 
	 * @param string $controller
	 * @return string
	 */
	private function namespace($controller)
	{
		return getenv('CONTROLLER_NAMESPACE') . str_replace('-', '', ucwords($controller,'-'));
	}

	/**
	 * CONTROLLER HANDLER
	 *
	 * ...
	 * 
	 * @param string $controller
	 * @param string $action
	 * @return void
	 */
	private function controllerHandler($controller, $action)
	{
		//default action
		$default_action = getenv('DEFAULT_ACTION');

		// reorder controller params
		if (method_exists($controller, $action) && $action != $default_action) 
			array_shift($this->request->params);
		else 
			$action = $default_action;
		
		// call controller
		return call_user_func_array(
			array(new $controller, $action), 
			array($this->request, $this->response)
		);
	}

	/**
	 * CACHE HANDLER
	 *
	 * ...
	 * 
	 * @param string $cache
	 * @return void
	 */
	private function cacheHandler($cache)
	{
		//check if cache exists
		if (!file_exists($cache))
			return false;

		// expired status
		$expired = (filectime($cache) <= (time() - getenv('CACHE_TIME'))) ? true : false;

		// check if file is expired
		return (!$expired) ? file_get_contents($cache) : false;	
	}
}
