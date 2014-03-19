<?php
class MySqlGuestbookTest extends PHPUnit_Extensions_Database_TestCase
{
    /**
     * @return PHPUnit_Extensions_Database_DB_IDatabaseConnection
     */
    public function getConnection()
    {
        $database = 'my_database';
        $pdo = new PDO('mysql:...', $user, $password);
        return $this->createDefaultDBConnection($pdo, $database); 
    }
	
	public function getDataSet(){}
 
    public function testGuestbook()
    {
        $dataSet = $this->getConnection()->createDataSet(); 
        // ...
    }
 
    public function testFilteredGuestbook()
    {
        $tableNames = array('guestbook');
        $dataSet = $this->getConnection()->createDataSet($tableNames); 
        // ...
    }
}