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
 * controller.php
 *
 * Base Controller class
 *
 * @version b0.1
 * @package core
 * @subpackage system
 */
abstract class Base_Controller{
	
	// Base controller instnace
	private static $instance;
	
	public function __construct(){
		
		self::$instance =& $this;
		
		$this->load = __class('Loader','helper');
		
		$this->input = __class('Input','helper');
		
	}
	
     abstract public function index();
	
     public static function &getInstance(){
		
          if(!isset(self::$instance) && !self::$instance instanceof Base_Controller) self::$instance = new Base_Controller;
		
		return self::$instance;     
     }
}
?>