<?php
/**
 * Not-Another Model-Controller Framework
 * 
 * @version b0.1
 * @author The Juan Who Code <caserjan@gmail.com>
 * @package core
 */

define('NICE_URL',true);

define('DOMAIN','http://www.namcf.dev');
 
// Framework Absolute path
define('ABSPATH',dirname(__FILE__).'/');

// System path
define('SYSDIR',ABSPATH.'system/');

// Application path
define('APPDIR',ABSPATH.'application/');

// Load system loader
include(SYSDIR.'namcf.php');
?>