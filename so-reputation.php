<?php
/*
Plugin Name: StackOverflow.com Reputation Widget
Plugin URI: http://picandocodigo.net/programacion/wordpress/stackoverflow-reputation-wordpress-plugin-english/
Description: Plugin to display your StackOverflow.com reputation on your WordPress blog as a sidebar Widget.
Version: 0.2.1
Author: Fernando Briano
Author URI: http://picandocodigo.net/programacion/wordpress/stackoverflow-reputation-wordpress-plugin-english/
*/

/* Copyright 2008  Fernando Briano  (email : fernando@picandocodigo.net)
This program is free software; you can redistribute it and/or modify
it under the terms of the GNU General Public License as published by
the Free Software Foundation; either version 3 of the License, or 
any later version.

This program is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
GNU General Public License for more details.

You should have received a copy of the GNU General Public License
along with this program; if not, write to the Free Software
Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA  02110-1301  USA
*/

//Sidebar Widget file

add_action('plugins_loaded', 'stackoverflow_load_widget');

function stackoverflow_load_widget() {
  if (function_exists('register_sidebar_widget')) {
    register_sidebar_widget('StackOverflow Reputation', 'stackoverflow_rep');
    register_widget_control('StackOverflow Reputation', 'stackoverflow_options', 300, 200 );
  }
}

function stackoverflow_rep(){//Display
  $so_rep_title = get_option("stackoverflow_rep_title");
  $so_rep_username = get_option("stackoverflow_rep_username");
  $so_rep_id = get_option("stackoverflow_rep_id");
	
	echo"<h2 class=\"widget\">".$so_rep_title."</h2>";
  $curlOb = curl_init();
  curl_setopt($curlOb, CURLOPT_URL,"http://stackoverflow.com/users/browser-filter");
  curl_setopt($curlOb, CURLOPT_post, 1);
  curl_setopt($curlOb, CURLOPT_POSTFIELDS, "filter=".$so_rep_username);
  curl_setopt($curlOb, CURLOPT_RETURNTRANSFER, TRUE);
  $so_html = curl_exec ($curlOb);
  curl_close ($curlOb);

    preg_match('#(\<a href=\"\/users\/'.$so_rep_id.'\/'.$so_rep_username.'\"\>)(\<img src\=[a-zA-Z0-9\:\/\.\=\?\&\"\ ]+\ \/\>)#', $so_html, $gregmatch);
    $so_gravatar = $gregmatch[2];
    echo "<div style=\"text-align:right;float:right;\" >".$so_gravatar."</div>";

    if(preg_match('#(\<a href=\"\/users\/'.$so_rep_id.'\/'.$so_rep_username.'\"\>)([a-zA-Z0-9]+)([a-zA-Z0-9\/\<\>\"\ \=\&\;\-\#]+)([\<\/div\>$])#', $so_html, $regmatch)){
      $so_username = $regmatch[2];
      $output="User: <a href=\"http://stackoverflow.com/users/".$so_rep_id."/".$so_rep_username."\"><strong>".$so_username."</strong></a><br/>";
      $so_stuff = $regmatch[3];
      preg_match('#(reputation\ score\"\>)([0-9]+)#',$so_stuff, $regmatch);
      $output.="Reputation: <strong>".$regmatch[2]."</strong><br/>";
      if(preg_match('#([0-9]+)\ silver\ badges#', $so_stuff, $regmatch)){
	$output.="<img src=\"".get_option('siteurl')."/wp-content/plugins/stackoverflowcom-reputation-wordpress-plugin/img/sbadge.png\" alt=\"Silver badges\" /> ".$regmatch[1]." ";
      }
      if(preg_match('#([0-9]+)\ bronze\ badges#', $so_stuff, $regmatch)){
	$output.="<img src=\"".get_option('siteurl')."/wp-content/plugins/stackoverflowcom-reputation-wordpress-plugin/img/bbadge.png\" alt=\"Bronze badges\" /> ".$regmatch[1]." ";
      }
      if(preg_match('#([0-9]+)\ gold\ badges#', $so_stuff, $regmatch)){
	$output.="<img src=\"".get_option('siteurl')."/wp-content/plugins/stackoverflowcom-reputation-wordpress-plugin/img/gbadge.png\" alt=\"Gold badges\" /> ".$regmatch[1]." ";
      }
    }
    echo $output;
}

function stackoverflow_options(){
  include('stackoverflow_rep_form.php');
} 

?>
