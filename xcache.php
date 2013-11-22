<?php  
//if (!defined('IS_INITPHP')) exit('Access Denied!');  
/********************************************************************************* 
 * InitPHP 2.0 ����PHP�������  Dao-XCACHE���� 
 *------------------------------------------------------------------------------- 
 * ��Ȩ����: CopyRight By initphp.com 
 * ����������ʹ�ø�Դ�룬������ʹ�ù����У��뱣��������Ϣ�����������Ͷ��ɹ����������Լ� 
 *------------------------------------------------------------------------------- 
 * $Author:zhuli 
 * $Dtime:2011-10-09  
***********************************************************************************/  
class xcacheInit {  
      
    /** 
     * Xcache����-���û��� 
     * ���û���key��value�ͻ���ʱ�� 
     * @param  string $key   KEYֵ 
     * @param  string $value ֵ 
     * @param  string $time  ����ʱ�� 
     */  
    public function set_cache($key, $value, $time = 0) {   
        return xcache_set($key, $value, $time);;  
    }  
      
    /** 
     * Xcache����-��ȡ���� 
     * ͨ��KEY��ȡ�������� 
     * @param  string $key   KEYֵ 
     */  
    public function get_cache($key) {  
        return xcache_get($key);  
    }  
      
    /** 
     * Xcache����-���һ������ 
     * ��memcache��ɾ��һ������ 
     * @param  string $key   KEYֵ 
     */  
    public function clear($key) {  
        return xcache_unset($key);  
    }  
      
    /** 
     * Xcache����-������л��� 
     * ������ʹ�øù��� 
     * @return 
     */  
    public function clear_all() {  
        $tmp['user'] = isset($_SERVER['PHP_AUTH_USER']) ? null : $_SERVER['PHP_AUTH_USER'];  
        $tmp['pwd'] = isset($_SERVER['PHP_AUTH_PW']) ? null : $_SERVER['PHP_AUTH_PW'];  
        $_SERVER['PHP_AUTH_USER'] = $this->authUser;  
        $_SERVER['PHP_AUTH_PW'] = $this->authPwd;  
        $max = xcache_count(XC_TYPE_VAR);  
        for ($i = 0; $i < $max; $i++) {  
            xcache_clear_cache(XC_TYPE_VAR, $i);  
        }  
        $_SERVER['PHP_AUTH_USER'] = $tmp['user'];  
        $_SERVER['PHP_AUTH_PW'] = $tmp['pwd'];  
        return true;  
    }  
      
    /** 
     * Xcache��֤�Ƿ���� 
     * @param  string $key   KEYֵ 
     */  
    public function exists($key) {  
        return xcache_isset($key);  
    }  
}