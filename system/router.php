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
 * Routes and loads controller
 *
 * @version b0.1
 * @package core
 * @subpackage system
 */
 
// Load Base Controller
__inc('controller');
 
$http_status_codes = __getVar('http_status_codes');
$controller = get_config('default','router');
$model = 'index';
$args = array();

if(defined('NICE_URL') && NICE_URL == true){
     
     $uri = array();
      
     // Get URI     
     $raw_uri = rtrim(ltrim($_SERVER['REQUEST_URI'],'/'),'/');
     
     $raw_uri = parse_url($raw_uri);
     
     if(isset($raw_uri['query'])){
          
          $query = array();
          
          parse_str($raw_uri['query'],$query);
          
          if($_SERVER['REQUEST_METHOD'] == 'POST'){
               
               __setVar('url_query',$query);
               
          }elseif($_SERVER['REQUEST_METHOD'] == 'GET'){
               
               __setVar('url_query',$query);
               
          }
     }
     
     if(!empty($raw_uri['path'])){ // Main index
          
          $uri = explode('/',$raw_uri['path']);
          
          if(count($uri) == 1){ // Controller index
               
               $controller = $raw_uri['path'];
               
          }else{
               
               $controller = array_shift($uri);
               
               $model = array_shift($uri);
               
          }
          
          if(count($uri) > 0) $args = $uri;         
          
     }
}


$redirect = get_config_group('redirect');
$alias = get_config_group('alias');

if(array_key_exists($controller,$redirect)){ // Redirect
     http_status('301');        
     header('Location: '.rtrim(DOMAIN,'/').'/'.$redirect[$controller].'/');
     exit();
}

if(array_key_exists($controller,$alias)){ // Alias
     $controller = $alias[$controller];
}

if(file_exists(APPDIR.'controllers/'.$controller.'.php')){     
     if(is_readable(APPDIR.'controllers/'.$controller.'.php')){
          
          $cntl_class = __class($controller,'controllers');

          if(method_exists($cntl_class,$model) || method_exists($cntl_class,'__call')){
               
               http_status('200');
               call_user_func_array(array($cntl_class,$model),$args);
               
          }else{
               
               http_status('404');
               $template = __class('Template','library');
               $template->error_page('404');
               
          }
          
     }else{
          
               http_status('500');
               $template = __class('Template','library');
               $template->error_page('500');
          
     }
     
}else{
          
          http_status('404');
          $template = __class('Template','library');
          $template->error_page('404');
     
}

?>