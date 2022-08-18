<?php
/* ---------------------------------------------------------
 * CLASS RESPONSE                                          *
 * ---------------------------------------------------------
 * Response handler                                        *
 * ---------------------------------------------------------
 * @license    MIT licence                                 *
 * @author     Antonio Carlos                              *
 * @copyright  ACFF (C) 2012                               *
 * ---------------------------------------------------------
 * * * * * * * * * * * * * * * * * * * * * * * * * * * * * *
*/
namespace Acffdev\PhpCore;

class Response
{
	/**
	 * HEADERS
	 * 
	 * http headers storage
	 */
	public $headers = array();

	/**
	 * BODY
	 * 
	 * http body response
	 */
	public $body;

	/**
	 * CONSTRUCT
	 * 
	 * sets default headers
	 */
	public function __construct()
	{
		$this->headers = array(
			"content-type" => "text/html"
		);
	}

	/**
	 * SEND
	 * 
	 * http response to be sent to user
	 * 
	 * @param int $code
	 * @param string $body
	 * @param array $headers
	 * @return string $body
	*/
	public function send($code, $body, $headers = array())
	{   
		// sets http response code
		http_response_code($code);
		
		// merge headers if there is any
		if (count($headers) > 0)
			$this->headers = array_merge($this->headers, $headers);
		
		// sets headers to http response
		foreach($this->headers as $key => $value)
			header($key . ': ' . $value);
		
		// kill script with body response
		exit($body);
	}
}