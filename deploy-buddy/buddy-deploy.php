<?php
/**
 * Plugin Name: Deploy Buddy
 * Description: Seamlessly trigger Buddy.works deploys from WordPress
 * Author: Maciek Palmowski
 * Version: 0.1.5
 * Author URI: https://wpowls.co/
 * Text-domain: buddy_deploy
 * GitHub Plugin URI: palmiak/deploy-buddy
 */

namespace BuddyIntegration;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

require_once __DIR__ . '/vendor/autoload.php';

Config::init(
	array(
		'version'       => '0.1.5',
		'file_path'     => __FILE__,
		'dir'           => __DIR__,
		'base_name'     => plugin_basename( __FILE__ ),
		'plugin_url'    => plugin_dir_url( __FILE__ ),
		'slug'          => 'deploy-buddy',
		'language_slug' => 'deploy-buddy',
		'name'          => 'Deploy Buddy',
		'shortname'     => 'Deploy Buddy',
		'utm'           => 'https://buddy.works/?utm_medium=referral&utm_campaign=deploy_buddy_plugin',
		'webhook'       => defined( 'buddy_webhook' ) ? buddy_webhook : false,
		'add_to_topbar' => defined( 'buddy_topbar' ) ? buddy_topbar : true,
		'capabilities'  => defined( 'buddy_capabilities' ) ? buddy_capabilities : 'manage_options',
		'manual_deploy' => defined( 'buddy_manual_deploy' ) ? buddy_manual_deploy : true,
	)
);



add_action( 'init', __NAMESPACE__ . '\\load_text_domain', 10, 0 );

if ( ! requirements_met() ) {
	add_action( 'admin_notices', __NAMESPACE__ . '\\print_requirements_notice', 0, 0 );
}
register_activation_hook( __FILE__, __NAMESPACE__ . '\\activate' );
register_deactivation_hook( __FILE__, __NAMESPACE__ . '\\deactivate' );
register_uninstall_hook( __FILE__, __NAMESPACE__ . '\\uninstall' );
add_action( 'plugins_loaded', __NAMESPACE__ . '\\boot', 10, 0 );
