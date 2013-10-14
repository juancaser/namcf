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
 * common.php
 *
 * Common Functions and Classes
 *
 * @version b0.1
 * @package core
 * @subpackage system
 */

/**
 * HTTP Status codes
 *
 * @since b0.1
 */
__setVar('http_status_codes',array(
          // Informational 1xx
          '100' => 'Continue',
          '101' => 'Switching Protocols',
          // Success 2xx
          '200' => 'OK',
          '201' => 'Created',
          '202' => 'Accepted',
          '203' => 'Non-Authorative Information',
          '204' => 'No Content',
          '205' => 'Reset Content',
          '206' => 'Partial Content',
          // Redirection 3xx
          '300' => 'Multiple Choices',
          '301' => 'Moved Permanently',
          '302' => 'Found',
          '303' => 'See Other',
          '304' => 'Not Modified',
          '305' => 'Use Proxy',     
          '307' => 'Temporary Redirect',
          // Client Error 4xx
          '400' => 'Bad Request',
          '401' => 'Unauthorized',
          '403' => 'Forbidden',
          '404' => 'Not Found',
          '405' => 'Method Not Allowed',
          '406' => 'Not Acceptable',
          '407' => 'Proxy Authentication Required',
          '408' => 'Request Timeout',
          '409' => 'Conflict',
          '410' => 'Gone',
          '411' => 'Length Required',
          '412' => 'Precondition Failed',
          '413' => 'Request Entity Too Large',
          '414' => 'Request-URI Too Long',
          '415' => 'Unsupported Media Type',
          '416' => 'Requested Range Not Satisfiable',
          '417' => 'Expectation Failed',
          // Server Error 5xx
          '500' => 'Internal Server Error',
          '501' => 'Not Implemented',
          '502' => 'Bad Gateway',
          '503' => 'Service Unavailable',
          '504' => 'Gateway Timeout',
          '505' => 'HTTP Version Not Supported'
     )
);
 
 
/**
 * Add function callback hook
 *
 * @uses Registry Class (registry.php)
 * @param array $param Hook parameters
 * @return bool Return true if success, false if not
 */
function addHook($param){
     
     $hooks = array();
     
     if(!is_array($param)) parse_str($param,$param);     
     
     extract(array_merge(array(
          'name' => '', // Hook name
          'func' => '', // Callbackfunction
          'priority' => 'normal'
     ),$param));
     
     if(Registry::getInstance()->callback_hooks == NULL){
          Registry::getInstance()->callback_hooks = array();
     }else{
          $hooks = Registry::getInstance()->callback_hooks;
     }
     
     $priority = in_array($priority,array('high','normal','low')) ? $priority : 'normal';
     
     if(!empty($name) && (!empty($func) && function_exists($func))){
          
          $hooks[$name][$priority][] = $name;
          
          Registry::getInstance()->hook = $hooks;
          
          return true;
     }else{
          return false;
     }
}

/**
 * Call function callback hook
 *
 * @uses Registry Class (registry.php)
 * @param array $param Hook parameters
 * @return mixed Return whatever the callback returns
 */
function doHook($param){
     
     $hooks = array();
     
     if(!is_array($param)) parse_str($param,$param);
     
     extract(array_merge(array(
          'name' => '', // Hook name
          'args' => array() // Arguments to passed to callback          
     ),$param));
     
     if(Registry::getInstance()->callback_hooks == NULL){
          Registry::getInstance()->callback_hooks = array();
     }else{
          $hooks = Registry::getInstance()->callback_hooks;
     }
     
     if(isset($hooks[$name])){          
          
          foreach($hooks[$name] as $priorities){
               foreach($priorities as $hook){
                    $args = call_user_func_array($hook,$args);
               }
          }
          
          return $args;
     
     }else{
          return false;
     }
}

/**
 * Alias of addHook()
 *
 * @param string $name Action name
 * @param string $callback_function Function callback
 * @return bool Return true if success, false if not
 */
function add_action($name,$callback_function){     
     return addHook(array('name' => $name,'func' => $callback_function));
}

/**
 * Alias of doHook()
 *
 * @param string $name Action name
 * @param array $args Arguments to pass in Array
 */
function do_action($name,$args = array()){
     addHook(array('name' => $name,'args' => $args));
}

/**
 * Add filter hook
 * 
 * Alias of add_action()
 *
 * @param string $name Action name
 * @param string $callback_function Function callback
 * @return bool Return true if success, false if not
 */
function add_filter($name,$callback_function){     
     return add_action($name,$callback_function);
}

/**
 * Apply filter hook
 *
 * Alias of doHook()
 *
 * @param string $name Action name
 * @param string $default Default value incase NULL is return
 * @param array $args Arguments to pass in Array
 */
function apply_filters($name,$default = '',$args = array()){
     
     $ret = addHook(array('name' => $name,'args' => $args));
     
     $ret = empty($ret) ? $default : $ret;
     
     return $ret;
}


/**
 * Load script
 *
 * @param string $filename File name
 * @param string Type of class where it will be loaded
 * @param mixed
 */
function __inc($filename,$type = ''){     
     
     $type_alias = array(
          'library' => 'libraries',
          'model' => 'models',
          'helper' => 'helpers',
          'config' => 'configs'
     );
     
     $type = array_key_exists($type,$type_alias) ? $type_alias[$type] : $type;
     
     $paths = array();
     
     if(!empty($type)){
          $paths[] = APPDIR.$type.'/'.$filename.'/'.$filename.'.php';
          $paths[] = SYSDIR.$type.'/'.$filename.'/'.$filename.'.php';
          $paths[] = APPDIR.$type.'/'.$filename.'.php';          
          $paths[] = SYSDIR.$type.'/'.$filename.'.php';
          
     }else{
          $paths[] = APPDIR.$filename.'/'.$filename.'.php';
          $paths[] = SYSDIR.$filename.'/'.$filename.'.php';     
          $paths[] = APPDIR.$filename.'.php';
          $paths[] = SYSDIR.$filename.'.php';          
     }
     foreach($paths as $path){
          
          if(is_readable($path) && file_exists($path)){
               
               if(!in_array($path,get_included_files())) require_once($path);
               
               return true;
          
          }
     }
     
     return false;

}

/**
 * Load class
 *
 * @uses __inc()
 * @param string $filename File name
 * @param array $args Passed arguments
 * @param string $type Type of class where it will be loaded
 * @param mixed
 */
function __class($name,$type = '',$args = array()){
     
     $class_name = $name;
     $filename = strtolower($name);
     
     if(is_array($name)){
          $filename = strtolower($name[0]);
          $class_name = $name[1];
     }
     
     if(__inc($filename,$type) && class_exists($class_name)){
          
          $obj = new $class_name($args);
          
          Registry::getInstance()->$filename = $obj;
          
          return $obj;
     
     }else{
          return false;
     }

}

/**
 * Set config variables
 *
 * @uses Registry Class (registry.php)
 * @param string $name Config name
 * @param mixed $value Config variable
 */
function set_config($name,$value = ''){
     
     $config = array();
     
     if(Registry::getInstance()->config == NULL){
          Registry::getInstance()->config = array();
     }else{
          $config = Registry::getInstance()->config;
     }
     
     $group = 'general';
     
     // Check if name is assigned to a config group
     $e = explode(':',strtolower($name));     
     if(count($e) == 2){
          $group = $e[0];
          $name = $e[1];
     }
     
     $config[$group][$name] = $value;
     
     Registry::getInstance()->config = $config;
}

/**
 * Get config variable
 *
 * @uses Registry Class (registry.php)
 * @param string $name Config name
 * @param string $group Config group
 * @return string Return config variable, else return NULL
 */
function get_config($name,$group = 'general'){
     
     $config = array();
     
     if(Registry::getInstance()->config == NULL){
          Registry::getInstance()->config = array();
     }else{
          $config = Registry::getInstance()->config;
     }
     
     if($group == 'get_config_group' && function_exists('get_config_group')){
          if(isset($config[$name])){
               return $config[$name];
          }else{
               return array();
          }
     }else{
          if(isset($config[$group][$name])){
               return $config[$group][$name];
          }else{
               return NULL;
          }
     }
}

/**
 * Get config group
 *
 * Alias to get_config()
 *
 * @uses get_config()
 * @param string $group Config group
 * @return bool Return config variable, else return NULL
 */
function get_config_group($group){     
     return get_config($group,__FUNCTION__);
}

/**
 * Return HTTP status code
 *
 * @param string $code Status code
 * @param string $custom_message Custom message
 */
function http_status($code,$custom_message = ''){
     
     $http_status_codes = __getVar('http_status_codes');
     
     if(array_key_exists($code,$http_status_codes)){
          header($_SERVER['SERVER_PROTOCOL'].' '.$code.' ' .(!empty($custom_message) ? $custom_message : $http_status_codes[$code]));
     }
}
?>