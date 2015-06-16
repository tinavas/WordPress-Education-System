<?php
/*
Plugin Name: Education Management Plugin
Plugin URI: http://web-apps.ninja/
Description: An Education Management WordPress plugin for managing schools & colleges
Version: 0.1
Author: Sabbir Ahmed
Author URI: http://sabbirahmed.me/
License: GPL2
*/

/**
 * Copyright (c) YEAR Sabbir Ahmed (email: sabbir.081070@gmail.com). All rights reserved.
 *
 * Released under the GPL license
 * http://www.opensource.org/licenses/gpl-license.php
 *
 * This is an add-on for WordPress
 * http://wordpress.org/
 *
 * **********************************************************************
 * This program is free software; you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation; either version 2 of the License, or
 * (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with this program; if not, write to the Free Software
 * Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA  02110-1301  USA
 * **********************************************************************
 */

// don't call the file directly
if ( !defined( 'ABSPATH' ) ) exit;

/**
 * WP_Education_Management class
 *
 * @class WP_Education_Management The class that holds the entire WP_Education_Management plugin
 */
class WP_Education_Management {

    /**
     * Constructor for the WP_Education_Management class
     *
     * Sets up all the appropriate hooks and actions
     * within our plugin.
     *
     * @uses register_activation_hook()
     * @uses register_deactivation_hook()
     * @uses is_admin()
     * @uses add_action()
     */
    public function __construct() {
        $this->define();
        $this->includes();
        $this->inistantiate();
        $this->actions();
        $this->filters();
    }

    /**
     * Initializes the WP_Education_Management() class
     *
     * Checks for an existing WP_Education_Management() instance
     * and if it doesn't find one, creates it.
     */
    public static function init() {
        static $instance = false;

        if ( ! $instance ) {
            $instance = new WP_Education_Management();
        }

        return $instance;
    }

    /**
     * Placeholder for activation function
     *
     * Nothing being called here yet.
     */
    public function activate() {

    }

    /**
     * Placeholder for deactivation function
     *
     * Nothing being called here yet.
     */
    public function deactivate() {

    }

    /**
     * Define All Constant
     *
     * @since 0.1
     *
     * @return void
     */
    public function define() {

    }

    /**
     * includes All necessary files
     *
     * @since 0.1
     *
     * @return void
     */
    public function includes() {

    }

    /**
     * Initiate All Class files
     *
     * @since 0.1
     *
     * @return void
     */
    public function inistantiate() {

    }

    /**
     * Hooking all actions
     *
     * @since 0.1
     *
     * @return void
     */
    public function actions() {

        add_action( 'init', array( $this, 'localization_setup' ) );
        add_action( 'wp_enqueue_scripts', array( $this, 'enqueue_scripts' ) );

    }

    /**
     * Hooking all filters
     *
     * @since 0.1
     *
     * @return void
     */
    public function filters() {

    }

    /**
     * Initialize plugin for localization
     *
     * @uses load_plugin_textdomain()
     */
    public function localization_setup() {
        load_plugin_textdomain( 'wp-ems', false, dirname( plugin_basename( __FILE__ ) ) . '/languages/' );
    }

    /**
     * Enqueue admin scripts
     *
     * Allows plugin assets to be loaded.
     *
     * @uses wp_enqueue_script()
     * @uses wp_localize_script()
     * @uses wp_enqueue_style
     *
     * @since 0.1
     */
    public function enqueue_scripts() {

        wp_enqueue_style( 'wp-ems-styles', plugins_url( 'assets/css/style.css', __FILE__ ), false, date( 'Ymd' ) );
        wp_enqueue_script( 'wp-ems-scripts', plugins_url( 'assets/js/script.js', __FILE__ ), array( 'jquery' ), false, true );

        /**
         * Example for setting up text strings from Javascript files for localization
         *
         * Uncomment line below and replace with proper localization variables.
         */
        // $translation_array = array( 'some_string' => __( 'Some string to translate', 'wp-ems' ), 'a_value' => '10' );
        // wp_localize_script( 'base-plugin-scripts', 'wp-ems', $translation_array ) );
    }

} // WP_Education_Management

function dokan_load_plugin() {
    $wp_ems = WP_Education_Management::init();
}

add_action( 'plugins_loaded', 'wp_ems_load_plugin', 10 );

register_activation_hook( __FILE__, array( 'WP_Education_Management', 'activate' ) );
register_deactivation_hook( __FILE__, array( 'WP_Education_Management', 'deactivate' ) );
