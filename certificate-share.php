<?php
/*
Plugin Name: Musterstudy LMS Certificate Shate
Description: Adds a Share button with social sharing options.
Version: 1.0
Author: anoy369
web: http://anoy369.com/
*/

// Enqueue necessary scripts and styles
function certificate_share_script() {
    // Enqueue jsPDF library
    wp_enqueue_script('jspdf', 'https://cdnjs.cloudflare.com/ajax/libs/jspdf/1.5.3/jspdf.debug.js', array(), '1.5.3', true);

    // Enqueue your JavaScript and CSS files here
    wp_enqueue_script('custom-social-icons-popup-script', plugins_url('js/script.js', __FILE__), array('jquery'), '1.0', true);
    wp_enqueue_style('custom-social-icons-popup-style', plugins_url('css/style.css', __FILE__), array(), '1.0', 'all');
    wp_enqueue_style('font-awesome', 'https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css');

    // Pass the plugin URL to JavaScript using wp_localize_script
    wp_localize_script('custom-social-icons-popup-script', 'pluginData', array(
        'pluginUrl' => plugin_dir_url(__FILE__)
    ));
}
add_action('wp_enqueue_scripts', 'certificate_share_script');


