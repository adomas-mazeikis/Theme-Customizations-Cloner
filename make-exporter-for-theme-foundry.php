<?php
/*
Plugin Name: Make Exporter for Theme Foundry
Plugin URI: 
Description: Simple tool to export theme modifications
Version: 0.9
Author: Adomas Mazeikis ( Arrow Root Media )
Text Domain: make-exporter-for-theme-foundry
Author URI: 
License: GPLv2
*/

/*
Copyright 2014 Arrow Root Media (email : jaki@arrowrootmedia.com)

This program is free software; you can redistribute it and/or modify
it under the terms of the GNU General Public License, version 2, as 
published by the Free Software Foundation.

This program is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
GNU General Public License for more details.

You should have received a copy of the GNU General Public License
along with this program; if not, write to the Free Software
Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA  02110-1301  USA
*/

defined('ABSPATH') or die("File not accessible separately");
global $Make_Exporter;
$Make_Exporter = new Make_Exporter();

class Make_Exporter {

	var $version = '0.9';
	var $admin   = null;
	var $errors  = null;

	/**
	 * Constructor
	 */
	function Make_Exporter() {

		$this->errors = new WP_Error();
		register_activation_hook( __FILE__, array( &$this, 'install' ) );
		add_action( 'plugins_loaded', array( $this, 'load_plugin_textdomain' ) );
		if ( is_admin() ) {
			include_once( dirname( __FILE__ ) . '/admin/admin.php' );
			$this->admin = new Make_Exporter_Admin();
		}

	}

	/**
	 * Function performed on install
	 */
	function install() {
		update_option( 'make_exporter_version', $this->version );
	}
	
	/**
	 * Localization
	 */
	function load_plugin_textdomain() {

		//load_plugin_textdomain( 'make-exporter', false, basename( dirname( __FILE__ ) ) . '/languages' );

	}
}
