<?php
/*
Plugin Name: Formidable Entry X
Description: Adds [entry_x] shortcode. Content of shortcode will appear in x-th entries. 
Version: 0.2.0 
Plugin URI: 
Author URI: 
Author: 1844144@gmail.com
Text domain: 
*/
// Instansiate Controllers
include_once(dirname( __FILE__ ) . '/controllers/EntryxController.php');
$obj = new EntryxController();
unset($obj);



