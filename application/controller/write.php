<?php
class write {
    public function index(){
	    /**
		* ����д��־�ӿڣ���������,�ɹ�����True��ʧ��false
		* @param string $folder  �洢��־���ļ������ƣ���־�ĸ�Ŀ¼Ϊ/log/��
		* @param string $log	 ��־����
		* @param string $file  �ļ���
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
		
		//�жϴ�������ļ��Ƿ�  ��������ļ�ʧ�ܣ�����Ȩ�޻��߷�����æ;
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

