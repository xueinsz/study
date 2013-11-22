<?php

/**
 * DB
 *
 * @package DB
 * @version $Id$
 * @copyright 2007
 * @author Cristian Rodriguez <judas.iscariote@flyspray.org>
 * @license BSD {@link http://www.opensource.org/licenses/bsd-license.php}
 */

class DB {
    private static $dbobj;
    private $db;
    
    private function __construct() {

		$this->db = new mysqli('localhost','root','','test');

		if(!$this->db) {
			die("数据库连接失败！" . $this->db->connect_error);
		}

		$this->db->query("set names utf8");
    }

    public final function __clone() {
        throw new BadMethodCallException("Clone is not allowed");
    } 
    
    /**
     * getInstance 
     * 
     * @static
     * @access public
     * @return object DB instance
     */
    public static function getInstance() {
        if (!(self::$dbobj instanceof DB)) {
            self::$dbobj = new DB;
        }
        return self::$dbobj;
    }

    public function query($query) {
       $res = $this->db->query($query) or die("数据查询失败".$this->db->error);
       return $res;
    }
	
	public function select($result) {
		$row = $result->fetch_array(MYSQLI_NUM);
		return $row;
	}
	
}
