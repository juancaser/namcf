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
 * Template Library
 *
 * @version b0.1
 * @package core
 * @subpackage system
 */
class Template{
     
     public function __construct(){
          
          $this->template_path = APPDIR.'template/';
          
          $this->post = array();
          __inc('template','helper');
     }

     public function error_page($code,$title = ''){
          
          $http_status_codes = __getVar('http_status_codes');
          
          $title = !empty($title) ? $title : $http_status_codes[$code];
          
          $this->setup_postdata(array(
               'ID' => 'page-'.$code,
               'type' => $code,
               'title' => $title
          ));
          
          if(array_key_exists($code,$http_status_codes) && !$this->load_template($code)){
               
               echo '<!DOCTYPE html><html><head><title>'.$title.'</title></head><body><h1>'.$title.'</h1></body></html>';
               
          }
     }
     
     public function setup_postdata($postdata){
          
          extract(array_merge(array(
                    'id' => 'home',
                    'type' => 'page',
                    'title' => 'Home',
                    'content' => '',
                    'permalink' => '',                    
                    'meta' => array()
               ),$postdata));
          
          $this->post = (object)array(
               'ID' => $id,
               'type' => $type,
               'title' => $title,
               'content' => $content,
               'permalink' => $permalink,
               'meta' => $meta
          );
          
     }
     
     public function display(){
          $this->load_template($this->post->type);
     }
     
     public function load_template($type,$name = ''){
          
          $tpls = array();
          
          $tpls[] = APPDIR.'template/'.$type.'.php';
          if(!empty($name)){
               $tpls[] = APPDIR.'template/'.$type.'-'.$name.'.php';
               $tpls[] = APPDIR.'template/html/'.$type.'/'.$name.'.php';
          }
          
          foreach($tpls as $tpl){
               if(file_exists($tpl)){
                    include($tpl);
                    return true;
               }
          }
          
          return false;
     }
}
?>