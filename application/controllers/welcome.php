<?php
if(!defined('ABSPATH')) exit(/* Silence is golden*/);
/**
 * Not-Another Model-Controller Framework
 * 
 * @version b0.1
 * @author The Juan Who Code <caserjan@gmail.com>
 * @package core
 */

class welcome extends Base_Controller{
     function __construct(){
          
          parent::__construct();
          
          $this->load->library('template');
     }
     
     function index(){
          
          /*$this->template->setup_postdata(array(
               'ID' => __FUNCTION__,
               'type' => 'page',
               'title' => 'Welcome',
               'content' => 'Not-Another Model-Controller Framework',
          ));
          
          $this->template->display();*/
     }
     
     public function __call($name,$arguments){
          print_r($arguments);
     }
}
?>