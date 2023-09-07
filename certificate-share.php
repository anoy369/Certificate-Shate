<?php
/*
Plugin Name: Certificate Share
Description: Adds a Share button with social sharing options.
Version: 1.0
Author: anoy369
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



// function custom_certificate_shortcode() {
//     $current_user_id = get_current_user_id();
//     $completed = stm_lms_get_user_completed_courses($current_user_id, array('user_course_id', 'course_id'), -1);
    
//     $output = ''; // Initialize an empty string to store the HTML output
    
//     if (!empty($completed)) {
//         foreach ($completed as $course) {
//             $code = STM_LMS_Certificates::stm_lms_certificate_code($course['user_course_id'], $course['course_id']);
            
//             if (class_exists('STM_LMS_Certificate_Builder')) {
//                 $certificate_link = esc_url(STM_LMS_Course::certificates_page_url($course['course_id']));
//                 $output .= '<a href="' . $certificate_link . '" target="_blank" class="certificate_share_button">';
//                 $output .= esc_html__('Share', 'masterstudy-lms-learning-management-system');
//                 $output .= '</a>';
//             }
//         }
//     }
    
//     return $output;
// }
// add_shortcode('certificate_shortcode', 'custom_certificate_shortcode');

$pluginUrl = plugins_url();
wp_localize_script( 'custom-social-icons-popup-script', 'object_name', $pluginUrl );

