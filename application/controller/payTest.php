<?php
require('/config.php');
class payTest extends PHPUnit_Framework_TestCase
{
    /*public function begin() {
	    
		require_once(HELPER . 'log.php');
		
		$data = array(
			'payType' => isset($_POST['payType'])?$_POST['payType']:'',
			'ip'      => isset($_POST['ip'])?$_POST['ip']:'',
			'txt'     => isset($_POST['txt'])?$_POST['txt']:'',
			'date'    => date('Y-m-d'),
			'time'    => date('H:i:s')
		);
		
		write_format_log($data,'pay_begin');
		
	}*/
	
	public function testBegin() 
	{
	    require_once(HELPER . 'log.php');
		
		$data = array(
			'payType' => 'paypal',
			'ip'      => '127.0.0.1',
			'txt'     => 'paypal for order successful!',
			'date'    => date('Y-m-d'),
			'time'    => date('H:i:s')
		);
		
		write_format_log($data,'pay_begin');
	}
}