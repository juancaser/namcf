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
 * System bootstrap loader
 *
 * @version b0.1
 * @package core
 * @subpackage system
 */

/**
 * registry.php
 * 
 * Global registry, replacement for global variables
 *
 * @since b0.1
 * @author The Juan Who Code <caserjan@gmail.com>
 */
include(SYSDIR.'registry.php');

/**
 * common.php
 * 
 * Independent functions, classes and variables
 *
 * @since b0.1
 * @author The Juan Who Code <caserjan@gmail.com>
 */
include(SYSDIR.'common.php');


/**
 * Loads configuration settinngs
 */
// System config
__inc('system','config');

// Library config
__inc('library','config');

// Router config
__inc('router','config');

/**
 * router.php
 * 
 * Routes and loads controllers
 *
 * @since b0.1
 * @author The Juan Who Code <caserjan@gmail.com>
 */
__inc('router');
?>