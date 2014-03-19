<?php
require('../config.php');
require_once('../helper/log.php');

class LogWriterTest extends PHPUnit_Framework_TestCase
{
    /**
	 * 测试支付开始写日志
	 */
    public function testLogBeginWrite() {
        $data = array(
			'payType' => 'PHPUnit Test',
			'ip'      => '127.0.0.1',
			'txt'     => 'For PHPUnit Test Paypal Feedback, Over!',
			'date'    => date('Y-m-d'),
			'time'    => date('H:i:s')
		);
		
		$this->assertTrue(write_format_log($data,'pay_begin'));
    }
	
	/**
	 * 测试支付完成后写日志
	 */
	public function testLogResultWrite() {
        $data = array(
			'payType'        => 'PHPUnit Test',
			'propId'         => 12345,
			'mobileuserId'   => 123,
			'userid'         => 1234,
			'cpserviceID'    => 'PHPUnit cp ID',
			'consumeCode'    => 'PHPUnit cs Code',
			'hRet'           => 123,
			'status'         => 0,
			'transIDO'       => 'PHPUnit transIDO',
			'cpParam'        => 'PHPUnit cpParam',
			'ip'             => '127.0.0.1',
			'date'           => date('Y-m-d'),
			'time'           => date('H:i:s')
		);
		
		$this->assertTrue(write_format_log($data,'pay_result'));
    }
	
	
	
}
