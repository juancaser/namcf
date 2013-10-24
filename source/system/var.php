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
 * Variable
 *
 * Sanitize, filters and pre-processed all server and user
 * variables
 *
 * @version b0.1
 * @package core
 * @subpackage system
 */

// Unset $_GLOBAL, since we have our own registry
unset($_GLOBAL);

// Unset $_REQUEST, too dangerous to keep
unset($_REQUEST);
?>