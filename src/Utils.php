<?php
/* ---------------------------------------------------------
 * CLASSE UTILS                                            *
 * ---------------------------------------------------------
 * generic helper functions                                *
 * ---------------------------------------------------------
 * @license    MIT licence                                 *
 * @author     Antonio Carlos                              *
 * @copyright  ACFF (C) 2012                               *
 * ---------------------------------------------------------
 * * * * * * * * * * * * * * * * * * * * * * * * * * * * * *
*/
namespace Acffdev\PhpCore;

class Utils
{
	/**
	 * CONSTRUCT
	 * 
	 * ...
	 */
	public function __construct()
	{
		throw new \Exception(__CLASS__ . ' can not be instanciated.');
	}

	/**
	 * HTTP PROTOCOL
	 * 
	 * ...
	 * 
	 * @return string
	 */
	public static function httpProtocol()
	{
		return (isset($_SERVER['HTTPS']) and $_SERVER['HTTPS'] == 'on') ? 'https://' : 'http://';
	}

	/**
	 * HTTP ADDRESS
	 * 
	 * ...
	 * 
	 * @return string
	 */
	public static function httpAddress()
	{
		return self::httpProtocol() . $_SERVER['HTTP_HOST'] . str_replace(basename($_SERVER['SCRIPT_NAME']), '', $_SERVER['SCRIPT_NAME']);
	}

	/**
	 * SLUG
	 * 
	 * transliteral slug of a string,
	 * ps: supports only latin characters.
	 * 
	 * @param string $string
	 * @param string $sep
	 * @return string
	 */
	public static function slug($string, $sep = '-') 
	{
		return strtolower(trim(preg_replace('~[^0-9a-z]+~i', $sep, html_entity_decode(preg_replace('~&([a-z]{1,2})(?:acute|cedil|circ|grave|lig|orn|ring|slash|th|tilde|uml);~i', '$1', htmlentities(str_replace('&', 'e', $string), ENT_QUOTES, 'UTF-8')), ENT_QUOTES, 'UTF-8')), $sep));
	}

	/**
	 * DATE
	 * 
	 * ...
	 * 
	 * @param string $format
	 * @return string
	 */
	public static function now($format = "Y-m-d H:i:s") 
	{
		return date($format);
	}

	/**
	 * HASH
	 * 
	 * ...
	 * 
	 * @param mixed $data
	 * @param string $cost
	 * @return string
	 */
	public static function hash($data, $cost = '08') 
	{
		return crypt($data, '$2a$'.$cost.'$'.substr(str_shuffle('./0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVQXYZ'), 0, 22).'$');
	}

	/**
	 * DEBUG
	 * 
	 * dump variables information
	 * 
	 * @param mixed $var
	 * @return mixed
	 */
	public static function debug($var) 
	{
		echo '<pre>'; var_dump($var); exit;
	}

	/**
	 * CACHE FILE
	 * 
	 * get static file absolute path
	 * 
	 * @param object $request
	 * @param string $ext
	 * @param string $sep
	 * @return string
	 */
	public static function cacheFile($uri, $ext = '.html', $sep = '_')
	{
		return  PUBLIC_PATH . (count($uri) > 0 ? implode($sep, $uri) : getenv('DEFAULT_CONTROLLER')) . $ext;
	}
}
