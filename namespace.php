<?php
include('my_class.php');
//$a = new MyClass;
$c = new \my\name\MyClass; // 参考 "全局空间" 小节
$c->getA();