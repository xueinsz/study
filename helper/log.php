<?php
function do_post_synclog($post_data ,$timeout = 30) {
    $url = 'http://localhost/test/write';
	
    $urls = parse_url($url);

    $urls["path"] = (empty($urls["path"]) ? "/" : $urls["path"]);
    $urls["port"] = (empty($urls["port"]) ? 80 : $urls["port"]);
    $host_ip = @gethostbyname($urls["host"]);
	
    $fsock_timeout = $timeout; //超时时间


    if(($fsock = fsockopen($host_ip, $urls['port'], $errno, $errstr, $fsock_timeout)) < 0){
        return false;
    }

    $request =  $urls["path"].(!empty($urls["query"]) ? "?" . $urls["query"] : "");

    $post_data2 = http_build_query($post_data);

    $in  = "POST " . $request . " HTTP/1.1\r\n";
    $in .= "Accept: */*\r\n";
    $in .= "Host: " . $urls["host"] . "\r\n";
    //$in .= "User-Agent: Lowell-Agent\r\n";
    $in .= "Content-type: application/x-www-form-urlencoded\r\n";
    $in .= "Content-Length: " . strlen($post_data2) . "\r\n";
    $in .= "Connection: Close\r\n\r\n";
    $in .= $post_data2 . "\r\n\r\n";
    unset($post_data2);

    if(!@fwrite($fsock, $in, strlen($in))){
        @fclose($fsock);
        return false;
    }
	
	return true;
}
/**
 * 写文件日志
 * @param string $folder 日志文件目录名（名字即可，会自动转化至log目录）
 * @param string $log 日志内容
 * @param string $fname 日志文件（如不传，则使用YYYYMMDD.log)
 */
function write_log($folder ,$log ,$fname='') {
    $data = array(
            'folder'=>$folder
            ,'log'=>$log
            ,'fname'=>$fname
    );

    return do_post_synclog($data);
}

/**
 * 按指定数据生成指定格式的log
 * $data = array(
 *         @param string payType 支付类型
 *	       @param int  propId 道具Id
 *	       @param date date 日期     
 *	       @param date_time time 时间    
 *	       @param string IP    
 *	       @param string mobileuserId 用户伪码
 *	       @param int userid 我们用户ID
 *	       @param string CpserviceID 系列代码
 *	       @param string consumeCode 道具代码
 *	       @param tinyint hRet 是否成功状态
 *	       @param tinyint status 返回状态码
 *	       @param string transIDO 外部订单号
 *	       @param string cpParam 内部订单号
 * )
 * @param string folder 日志目录
 * 
 */
function write_format_log($data = array(),$folder = '') {
    require  CONFIG . 'log.php';
    $log = '';
	
	//$log .= date('Y-m-d') . "\t";
	
	//$log .= date('H:i:s') . "\t";
	
	foreach($data as $key => $value) {
	    $log .= in_array($key,$_fields[$folder]) ? $value . "\t" : "";
	}
	
	/*$log .= isset($data['payType']) ? $data['payType'] . "\t" : "\t";
	
	$log .= isset($data['propId']) ? $data['propId'] . "\t" : "\t";
	
	$log .= isset($data['ip']) ? $data['ip'] . "\t" : "\t";
	
	$log .= isset($data['mobileuserId']) ? $data['mobileuserId'] . "\t" : "\t";
	
	$log .= isset($data['userid']) ? $data['userid'] . "\t" : "\t";
	
	$log .= isset($data['cpserviceID']) ? $data['cpserviceID'] . "\t" : "\t";
	
	$log .= isset($data['consumeCode']) ? $data['consumeCode'] . "\t" : "\t";
	
	$log .= isset($data['hRet']) ? $data['hRet'] . "\t" : "\t";
	
	$log .= isset($data['status']) ? $data['status'] . "\t" : "\t";
	
	$log .= isset($data['transIDO']) ? $data['transIDO'] . "\t" : "\t";
	
	$log .= isset($data['cpParam']) ? $data['cpParam'] . "\t" : "\t";
	
	$log .= isset($data['txt']) ? $data['txt'] . "\t" : "\t";*/

	$folder = $folder ? $folder : date('Y-m');

	return write_log($folder, $log);
}


