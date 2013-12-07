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
 * template.php
 *
 * Template helper
 *
 * @version b0.1
 * @package core
 * @subpackage helper
 */

/**-------------------------------------------------------------------------------------
 * Template loader
 -------------------------------------------------------------------------------------*/
/**
 * Get header template
 *
 * @since b0.1
 * @param string $name Custom template name
 */
function get_header($name = ''){
     $tpl = __getVar('template');
     if(!$tpl->load_template('header',$name))
          $tpl->error_page('500');
}

/**
 * Get footer template
 *
 * @since b0.1
 * @param string $name Custom template name
 */
function get_footer($name = ''){
     $tpl = __getVar('template');
     if(!$tpl->load_template('footer',$name))
          $tpl->error_page('500');
}

/**-------------------------------------------------------------------------------------
 * Template hooks
 -------------------------------------------------------------------------------------*/

/**
 * Header hook action
 *
 * @since b0.1
 */
function the_header(){
     do_action(__FUNCTION__);
}

/**
 * Footer hook action
 *
 * @since b0.1
 */
function the_footer(){
     do_action(__FUNCTION__);
}

/**
 * Meta header hook action
 *
 * @since b0.1
 */
function the_meta(){
     do_action(__FUNCTION__);
}

/**-------------------------------------------------------------------------------------
 * Page data
 -------------------------------------------------------------------------------------*/

/**
 * Page title
 *
 * @since b0.1
 * @param mixed $param Title parameter
 * @return string Page title
 */
function title($param){
     
     $tpl = __getVar('template');
     $post = $tpl->post;
     
     if(!is_array($param)) parse_str($param,$param);
     
     extract(array_merge(array(
          'default' => '', // default title
          'format' => '%s', // Arguments to passed to callback
          'format_exclude' => array(), // List of page type to exclude formating
          'callback' => NULL // Callback function to call before displaying title
     ),$param));     
     
     if(!is_array($format_exclude)) $format_exclude = explode(',',$format_exclude);
     
     $title = isset($post->title) ? $post->title : $default;
     
     if($callback!=NULL && is_callable($callback)){
          
          $c = call_user_func_array($callback,array(
                    'default' => $default,
                    'title' => $title,
                    'format' => $format
               )
          );
          
          if(is_array($c)) extract($c);
     
     }
     
     printf($format,$title);
     
}

/**-------------------------------------------------------------------------------------
 * The Post
 -------------------------------------------------------------------------------------*/

/**
 * Post
 *
 * @since b0.1
 * @return array Post dara
 */
function the_post(){
     
     $tpl = __getVar('template');
     return $tpl->post;
}


/**-------------------------------------------------------------------------------------
 * Template Utils
 -------------------------------------------------------------------------------------*/

/**
 * Return  site information
 *
 * @since b0.1
 * @return string Site information
 */
function get_siteinfo($key){
	switch($key){
		case 'name':
			if(get_config('name','site')!= 'NULL')
				return get_config('name','site');
			break;
		case 'description':
			if(get_config('description','site')!= 'NULL')
				return get_config('description','site');
			break;
		case 'keyword':
			if(get_config('keyword','site')!= 'NULL')
				return get_config('keyword','site');
			break;
		case 'charset':
			if(defined('charset')){
				return charset;
			}elseif(get_config('charset','site')!= 'NULL'){
				return get_config('charset','site');
			}				
			break;
		case 'url':
		case 'siteurl':
			return DOMAIN;
			break;
		default:
			return;
			
	}
}

/**
 * Display site information
 *
 * @uses get_siteinfo()
 *
 * @since b0.1
 * @return string Site information
 */
function siteinfo($key){
	echo get_siteinfo($key);
}

?>