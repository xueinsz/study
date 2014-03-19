<?php

/**
 *
 * 支付日志流水记录
 
 * @version 1.0 2013-12-16
 * @author xuehaitao
 */
class pay {

    public function index(){
	    echo 'Hello World!';
	}
	
	/*
	 * 支付开始时写日志
	 */
	public function begin() {    
		
		$data = array(
			'payType' => isset($_POST['payType'])?$_POST['payType']:'',
			'ip'      => isset($_POST['ip'])?$_POST['ip']:'',
			'txt'     => isset($_POST['txt'])?$_POST['txt']:'',
			'date'    => date('Y-m-d'),
			'time'    => date('H:i:s')
		);
		
		$this->_write($data,'pay_begin');
	}
	
	/**
	 * 支付结束时写日志
	 */
	public function result() {		
	    /*$_POST['payType'] = '1';
		$_POST['propId'] = '1';
		$_POST['mobileuserId'] = 'mobileuserId';
		$_POST['userid'] = '123';
		$_POST['cpserviceID'] = 'cpserviceID';
		$_POST['consumeCode'] = 'consumeCode';
		$_POST['hRet'] = '1';
		$_POST['status'] = '1234';
		$_POST['transIDO'] = 'transIDO';
		$_POST['cpParam'] = 'cpParam';
		$_POST['ip'] = '58.147.125.100';*/

		$data = array(
			'payType'        => isset($_POST['payType']) ? $_POST['payType'] : '',
			'propId'         => isset($_POST['propId']) ? $_POST['propId'] : '',
			'mobileuserId'   => isset($_POST['mobileuserId']) ? $_POST['mobileuserId'] : '',
			'userid'         => isset($_POST['userid']) ? $_POST['userid'] : '',
			'cpserviceID'    => isset($_POST['cpserviceID']) ? $_POST['cpserviceID'] : '',
			'consumeCode'    => isset($_POST['consumeCode']) ? $_POST['consumeCode'] : '',
			'hRet'           => isset($_POST['hRet']) ? $_POST['hRet'] : '',
			'status'         => isset($_POST['status']) ? $_POST['status'] : '',
			'transIDO'       => isset($_POST['transIDO']) ? $_POST['transIDO'] : '',
			'cpParam'        => isset($_POST['cpParam']) ? $_POST['cpParam'] : '',
			'ip'             => isset($_POST['ip']) ? $_POST['ip'] : '',
			'date'           => date('Y-m-d'),
			'time'           => date('H:i:s')
		);
		
		$this->_write($data,'pay_result');
		
		//$serverName = DB_HOST;
		$serverName = '192.168.1.242';
		//$connectionInfo = array( "Database"=>DB_DATABASE, "UID"=>DB_USER, "PWD"=>DB_PASSWORD);
		$connectionInfo = array( "Database"=>'logging', "UID"=>'sa', "PWD"=>'123456');
		$conn = sqlsrv_connect( $serverName, $connectionInfo);
		
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

		 if(!$stmt) {
			 die( print_r( sqlsrv_errors(), true));
		 }
		//$result = $link->execute('sp_insert_ClientCpservice', $data);
		
		echo json_encode(array('status' => 1,'feedback' => 'Log Write Success!'));
		exit;
	}
	
	/*
	 * 写日志
	 * @param $data array 数据
	 * @param $type string 日志类型
	 */
	private function _write($data,$type) {
		global $plugin;
		
		// 根据后台的配置设置插件的值
		$__plugin_name = 'demo';
		$__plugin_action = '';

		require(HELPER . 'log.php');
		
		write_format_log($data,$type);
		
		$plugin->trigger($__plugin_name,$__plugin_action);
	}

}

// EOF