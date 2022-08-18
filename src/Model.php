<?php
/* ---------------------------------------------------------
 * CLASSE MODEL                                            *
 * ---------------------------------------------------------
 * Database connection                                     *
 * ---------------------------------------------------------
 * @license    MIT licence                                 *
 * @author     Antonio Carlos Webmaster                    *
 * @copyright  ACWEBMASTER (C) 2012                        *
 * ---------------------------------------------------------
 * * * * * * * * * * * * * * * * * * * * * * * * * * * * * *
*/
namespace Acffdev\PhpCore;

abstract class Model
{
	/**
	 * DATABASE
	 *
	 * stores database connection object
	 *
	 * @param array $db
	 */
	protected $db;
	
	/**
	 * EXTENSION
	 *
	 * set choosen database extension
	 * PDO or MYSQLI
	 *
	 * @param string $extension
	 */
	private $extension;

	/**
	 * CONSTRUCT
	 *
	 * connects to database
	 */
	public function __construct()
	{
		$this->extension = strtolower(getenv('DB_EXTENSION'));

		if ($this->extension === 'pdo')
			$this->pdoConnection();
		else
			$this->mysqliConnection();
	}

	/**
	 * MYSQLI CONNECTION
	 *
	 * connects to dabase using mysqli
	 */
	private function mysqliConnection()
	{
		if (!extension_loaded('mysqli')) 
			throw new \Exception('MySQLi extension is disabled.');

		$this->db = new \mysqli(
			getenv('DB_HOST'),
			getenv('DB_USER'),
			getenv('DB_PASS'),
			getenv('DB_NAME')
		);

		if (!$this->db->connect_errno)
			$this->db->set_charset('utf8');
		else
			throw new \Exception('Error: ' . $this->db->connect_error);
	}

	/**
	 * PDO CONNECTION
	 *
	 * connects to database using PDO
	 */
	private function pdoConnection()
	{
		if (!extension_loaded('pdo')) 
			throw new \Exception('Your PDO extension is disabled.');

		try {
			$this->db = new \PDO(
				getenv('DB_DRIVER') . ":dbname=".
				getenv('DB_NAME').";host=".
				getenv('DB_HOST')."",
				getenv('DB_USER'),
				getenv('DB_PASS'),
				array(\PDO::ATTR_ERRMODE => \PDO::ERRMODE_EXCEPTION)
			);
		} catch (\PDOException $e) {
			throw new \Exception('Error: ' . $e->getMessage());
		}
	}

	/**
	 * DESTRUCT
	 *
	 * close connection to database
	 */
	public function __destruct()
	{
		if ($this->extension === 'pdo') {
			$this->db = null;
		} else {
			$thread = $this->db->thread_id;
			$this->db->kill($thread);
			$this->db->close();
		}
	}
}
