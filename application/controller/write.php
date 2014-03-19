<?php
class write {
    public function index(){
	    /**
		* 公用写日志接口，三个参数,成功返加True，失败false
		* @param string $folder  存储日志的文件夹名称（日志的根目录为/log/）
		* @param string $log	 日志内容
		* @param string $file  文件名
		* @var unknown_type
		*/

		date_default_timezone_set('Asia/Shanghai');
		
		$folder = isset($_POST['folder']) ? $_POST['folder'] : '';
		$log    = isset($_POST['log']) ? $_POST['log'] : '';
		$file   = isset($_POST['fname']) ? $_POST['fname'] : '';

		if(empty($folder)) {
			return false;
		}

		$path = DATA . 'log/'.$folder;
		
		if (!file_exists($path)){
			mkdir($path,0777);
		}
		
		$fileName = empty($file) ? $path.'/'.date('Y-m-d').'.log' : $file;

		$fp = fopen($fileName, 'a+');
		
		//判断创建或打开文件是否  创建或打开文件失败，请检查权限或者服务器忙;
		if($fp===false) {
			//file_put_contents('d:\wamp\www\out.interface\data\log\xxx.txt','tttttt');
			return false;
		} else {
			if(fwrite($fp,date("Y-m-d H:i:s")."\t".$log."\r\n")) {
				fclose($fp);
				return true;
			} else {
				return false;
			}
		}
	}
}

