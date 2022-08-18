<?php 
/* ---------------------------------------------------------
 * CLASSE VIEW                                             *
 * ---------------------------------------------------------
 * Views handler                                           *
 * ---------------------------------------------------------
 * @license    MIT licence                                 *
 * @author     Antonio Carlos                              *
 * @copyright  ACFF (C) 2012                               *
 * ---------------------------------------------------------
 * * * * * * * * * * * * * * * * * * * * * * * * * * * * * *
*/
namespace Acffdev\PhpCore;

class View
{
	/**
	 * CONTENT
	 * 
	 * stores content view file
	 */
	public $file;

	/**
	 * CONSTRUCTOR
	 * 
	 * ...
	 * 
	 * @param string $file
	 */
	public function __construct($file)
	{
		$this->file = APP_PATH . 'views/' . $file . '.php';
	}

	/**
	 * GET CONTENT
	 * 
	 * ... 
	 * 
	 * @param array $data
	 * @return string
	 */
	public function content($data = array())
	{
		// check if view file exists
		if (!file_exists($this->file))
			throw new \Exception("View {$this->file} does not exists.");

		// extract $data variable name
		extract($data);

		// buffer output
		ob_start();
		require_once $this->file;
		$content = ob_get_contents();
		ob_end_clean();
		
		// return content
		return $content;
	}
}