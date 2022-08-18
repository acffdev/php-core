<?php
/* ---------------------------------------------------------
 * CLASSE CONTROLLER                                       *
 * ---------------------------------------------------------
 * Controller                                              *
 * ---------------------------------------------------------
 * @license    MIT licence                                 *
 * @author     Antonio Carlos                              *
 * @copyright  ACFF (C) 2012                               *
 * ---------------------------------------------------------
 * * * * * * * * * * * * * * * * * * * * * * * * * * * * * *
*/
namespace Acffdev\PhpCore;

abstract class Controller
{
	/**
	 * DATA 
	 * 
	 * data storage for child controller
	 *
	 * @param array $data
	*/
	protected $data = array();

	/**
	 * CONSTRUCT
	 * 
	 * ...
	 */
	public function __construct()
	{
	}
	
	/**
	 * INTERFACE
	 * 
	 * interface index method
	 * 
	 * @param object $request
	 * @param object $response
	 * @return string
	*/
	abstract public function index($request, $response);

	/**
	 * VIEW
	 * 
	 * calls view's object
	 * 
	 * @param string $file
	 * @return string
	*/
	protected function view($file)
	{
		// view object
		$view = new View($file);
		
		// returns view content
		return $view->content($this->data);		
	}

	/**
	 * CACHE	
	 * 
	 * create cache files of requested uri
	 * 
	 * @param array $uri
	 * @param string $content
	 * @return string $content
	*/
	protected function cache($uri, $content)
	{
		// create cache file
		file_put_contents(Utils::cacheFile($uri), $content);

		// print content
		return $content;
	}
}