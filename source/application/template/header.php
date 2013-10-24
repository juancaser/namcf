<?php
if(!defined('ABSPATH')) exit(/* Silence is golden*/);
/**
 * NAMCF Template Header
 * 
 * @version b0.1
 * @author The Juan Who Code <caserjan@gmail.com>
 * @package views
 */
?>
<!DOCTYPE html>
<html>
<head>
    <?php the_meta();?>
    <title><?php title('default=Home&format=%s - Not Another Model-Controller Framework&callback=title_callback');?></title>
    <?php the_header();?>
</head>
<body>