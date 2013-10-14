<?php
if(!defined('ABSPATH')) exit(/* Silence is golden*/);
/**
 * Not-Another Model-Controller Framework
 * 
 * @version b0.1
 * @author The Juan Who Code <caserjan@gmail.com>
 * @package core
 */

/**
 * loader.php
 *
 * Base Controller class
 *
 * @version b0.1
 * @package core
 * @subpackage system
 */
class Loader{
	public function __construct(){
		return $this;
	}
	
	private function __loader($class,$type, $args = array()){
		
		$name = $class;
		
          if(is_array($class)) $name = $class[0];

		Base_Controller::getInstance()->{strtolower($name)} = __class($class,$type,$args);
		
	}
	
	public function library($class, $args = array()){          
		$this->__loader($class, __FUNCTION__, $args);
	}
	
	public function model($class, $args = array()){		
		$this->__loader($class, __FUNCTION__, $args);
	}
	
	public function helper($class, $args = array()){		
		$this->__loader($class, __FUNCTION__, $args);
	}
}
?>