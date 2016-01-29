<?php
/**
 * Plugin Name: Custom Juicer - Style Override for Juicer.io plugin
 * Plugin URI: http://nsideas.com
 * Description: overrides Juicer social media feed styling. Requires Juicer.io account and Juicer WP plugin.
 * Version: 0.0.1
 * Author: Michael Miller
 * Author URI: http://nsideas.com
 * License: GPLv2 or later
 */

/*
This program is free software; you can redistribute it and/or
modify it under the terms of the GNU General Public License
as published by the Free Software Foundation; either version 2
of the License, or (at your option) any later version.

This program is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
GNU General Public License for more details.

You should have received a copy of the GNU General Public License
along with this program; if not, write to the Free Software
Foundation, Inc., 51 Franklin Street, Fifth Floor, Boston, MA  02110-1301, USA.
*/


function remove_juicer_scripts() {
    if(class_exists('Juicer_Feed')) {
        remove_action( 'wp_enqueue_scripts', 'juicer_scripts', 0 );
        remove_shortcode('juicer');
        function custom_feed_scripts() {
            wp_enqueue_script('jquery');
            wp_enqueue_script('jquery-masonry');

            wp_enqueue_script(
                'feedembed',
                '//assets.juicer.io/embed-no-jquery.js',
                array('jquery'),
                false,
                false
            );

            wp_enqueue_style(
                'feedstyle',
                plugin_dir_url(__FILE__).'embed.css'
            );
        }
        add_action( 'wp_enqueue_scripts', 'custom_feed_scripts', 0 );

        function custom_juicer_shortcode($args) {
              extract( shortcode_atts( array(
              'name'    => 'error',
          ), $args ) );

          $feed = new Juicer_Feed();

          return $feed->render( $args );
        }

        add_shortcode( 'custom_juicer', 'custom_juicer_shortcode' );
    }
}

add_action('plugins_loaded', 'remove_juicer_scripts');

?>