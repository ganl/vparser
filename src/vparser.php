<?php
//
define('VPARSER_ROOT', dirname(__FILE__));
define('CURSCRIPT', 'vparser');
define('IN_PARSER', true);

class Vparser{
	/**
	 * 音悦台
	 * @var unknown
	 */
	const MODULE_YINYUETAI = 'yinyuetai';
	
	public static function load($moduleName){
		$moduleFile = VPARSER_ROOT.'/Module/'.$moduleName.'.php';
	
		if(!file_exists($moduleFile)){ return false; }
		
		require_once $moduleFile;
		$className = 'Vparser_'.$moduleName;
		$instance = new $className();
		
		return $instance;
	}
	
	
}