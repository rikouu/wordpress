<?php
/*
Plugin Name: WP Clean Up
Plugin URI: http://boliquan.com/wp-clean-up/
Description: WP Clean Up can help us to clean up the wordpress database by removing "revision" "draft" "auto draft" "moderated comments" "spam comments" "trash comments" "orphan postmeta" "orphan commentmeta" "orphan relationships" "dashboard transient feed". It allows you to optimize your WordPress database without phpMyAdmin.
Version: 1.2.3
Author: BoLiQuan
Author URI: http://boliquan.com/
Text Domain: WP-Clean-Up
Domain Path: /lang
*/

function load_wp_clean_up_lang(){
	$currentLocale = get_locale();
	if(!empty($currentLocale)){
		$moFile = dirname(__FILE__) . "/lang/wp-clean-up-" . $currentLocale . ".mo";
		if(@file_exists($moFile) && is_readable($moFile)) load_textdomain('WP-Clean-Up',$moFile);
	}
}
add_filter('init','load_wp_clean_up_lang');

function wp_clean_up_settings_link($action_links,$plugin_file){
	if($plugin_file==plugin_basename(__FILE__)){
		$wcu_settings_link = '<a href="options-general.php?page=' . dirname(plugin_basename(__FILE__)) . '/wp_clean_up_admin.php">' . __("Settings") . '</a>';
		array_unshift($action_links,$wcu_settings_link);
	}
	return $action_links;
}
add_filter('plugin_action_links','wp_clean_up_settings_link',10,2);

if(is_admin()){require_once('wp_clean_up_admin.php');}
?>