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
 * router.php
 *
 * Router config
 *
 * @version b0.1
 * @package application
 * @subpackage config
 */
set_config('router:default','welcome');

// Route help to welcome controller
set_config('alias:help','welcome');
set_config('alias:test','welcome');

set_config('redirect:help2','welcome');
?>