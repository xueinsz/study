<?php
class logDBTest extends PHPUnit_Extensions_Database_TestCase {
    
	// 只实例化 pdo 一次，供测试的清理和基境读取使用。
    static private $pdo = null;
 
    // 对于每个测试，只实例化 PHPUnit_Extensions_Database_DB_IDatabaseConnection 一次。
    private $conn = null;
 
    final public function getConnection()
    {
        if ($this->conn === null) { 
            if (self::$pdo == null) {
                self::$pdo = new PDO( $GLOBALS['DB_DSN'], $GLOBALS['DB_USER'], $GLOBALS['DB_PASSWD'] );
            }
           $this->conn = $this->createDefaultDBConnection(self::$pdo, $GLOBALS['DB_DBNAME']); 
        }
 
        return $this->conn; 
    }
	
	final public function getDataSet(){
	    $ds = new PHPUnit_Extensions_Database_DataSet_QueryDataSet($this->getConnection());
        $ds->addTable('OrderLogging1');
		return $ds;
	}
	
    public function testAddEntry()
    {
        $this->assertEquals(99, $this->getConnection()->getRowCount('OrderLogging1'), "Pre-Condition");
		
		$returnCode = 0;
		$amount = '';
		
		$param = array(
					  array(&$data['payType'],1),
					  array(&$data['propId'],1),
					  array(&$data['mobileuserId'],1),
					  array(&$data['userid'],1),
					  array(&$data['cpserviceID'],1),
					  array(&$data['consumeCode'],1),
					  array(&$data['hRet'],1),
					  array(&$data['status'],1),
					  array(&$data['transIDO'],1),
					  array(&$data['cpParam'],1),
					  array(&$data['ip'],1),
					  array(&$data['date'],1),
					  array(&$data['time'],1),
					  array(&$amount,1),
					  array(&$returnCode,2)
		);

		$sql='{call sp_insert_OrderLogging1(';
		if($param&&is_array($param)){
			$sql.=('?'.str_repeat(',?',count($param)-1));
		}
		$sql.=')}';

		$stmt=sqlsrv_query($conn,$sql,$param);
    }
}
