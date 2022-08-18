<?php
/* ---------------------------------------------------------
 * CLASS REQUEST                                           *
 * ---------------------------------------------------------
 * Requests handler                                        *
 * ---------------------------------------------------------
 * @license    MIT licence                                 *
 * @author     Antonio Carlos                              *
 * @copyright  ACFF (C) 2012                               *
 * ---------------------------------------------------------
 * * * * * * * * * * * * * * * * * * * * * * * * * * * * * *
*/
namespace Acffdev\PhpCore;

class Request
{
	/**
	 * METHOD
	 * 
	 * requested http method, GET, POST, PUT, DELETE, etc ...
	 */
	public $method;

	/**
	 * HEADERS
	 * 
	 * requested headers
	 */
	public $headers = array();

	/**
	 * URI
	 * 
	 * parse uri
	 */
	public $uri = array();

	/**
	 * CONTROLLER
	 * 
	 * requested controller
	 */
	public $controller;

	/**
	 * ACTION
	 * 
	 * requested action
	 */
	public $action;

	/**
	 * PARAMS
	 * 
	 * requested params
	 */
	public $params = array();

	/**
	 * CONSTRUCT
	 * 
	 * ...
	 * 
	 * @return void
	 */
	public function __construct()
	{
		// get requested method
		$this->method = $_SERVER['REQUEST_METHOD'] ?: 'GET';

		// get all requested headers
		$this->headers = getallheaders();

		// build URI
		$this->uri = $this->uriSlice($this->getUri(getenv('FOLDER_PREFIX'))) ?: array();
		
		// get controller
		$this->controller = isset($this->uri[0]) ? $this->uri[0] : getenv('DEFAULT_CONTROLLER');

		// get controller method
		$this->action = isset($this->uri[1]) ? $this->uri[1] : getenv('DEFAULT_ACTION');
		
		// get controller params
		$this->params = array_slice($this->uri, ($this->action === getenv('DEFAULT_ACTION')) ? 2 : 1) ?: array();
	}

	/**
	 * URISLICE
	 * 
	 * slices uri string to array 
	 * 
	 * @param string $url
	 * @return array
	 */
	private function uriSlice($url)
	{
		return (isset($url) and $url != '/') ? explode('/', trim($url, '/')) : null;
	}

	/**
	 * GETURI
	 * 
	 * build the uri to be sliced by 
	 * urislice function
	 * 
	 * @param string $prefix
	 * @return string
	 */
	private function getUri($prefix)
	{
		return str_replace($this->uriBase($prefix), '', $this->uriPath($prefix));
	}

	/**
	 * URIBASE
	 * 
	 * ... 
	 * 
	 * @param string $prefix
	 * @return string
	 */
	private function uriBase($prefix)
	{
		return str_replace('/' . $prefix . '/', '', $_SERVER['SCRIPT_NAME']);
	}

	/**
	 * URIPATH
	 * 
	 * ... 
	 * 
	 * @param string $prefix
	 * @return string
	 */
	private function uriPath($prefix)
	{
		return str_replace('/' . $prefix . '/', '', strtok($_SERVER['REQUEST_URI'], '?'));
	}
}