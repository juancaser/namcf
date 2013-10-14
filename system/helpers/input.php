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
class Input{
	
	private function __loader($class, $args = array()){
		
		$name = $class;
		
          if(is_array($class)) $name = $class[0];
		
		Base_Controller::getInstance()->$name = __class($class,'libraries',$args);
		
	}
	
	public function get($class, $args = array()){          
		$this->__loader($class, $args);
	}
	
	public function post($class, $args = array()){		
		$this->__loader($class, $args);
	}
	
	public function server($class, $args = array()){		
		$this->__loader($class, $args);
	}
	
	public function cookie($class, $args = array()){		
		$this->__loader($class, $args);
	}
}
?>