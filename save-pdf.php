<?php
//include wp-load.php file. check the route
include($_SERVER['DOCUMENT_ROOT'].'/wp-load.php');


// Check if the user is logged in and has appropriate permissions
if (!is_user_logged_in() || !current_user_can("upload_files")) {
    die("Access denied.");
}

// Check if the PDF file data has been posted
if (isset($_FILES["pdf"])) {
    $pdf_data = $_FILES["pdf"];

    // Get the current user's ID
    $user_id = get_current_user_id();

    // Get the course ID from the request
    $course_id = sanitize_text_field($_POST["course_id"]);

    // Define the folder where you want to save the PDF files
    $upload_dir = wp_upload_dir();
    $certificate_folder = $upload_dir["basedir"] . "/certificates/";

    // Create the certificates folder if it doesn't exist
    if (!file_exists($certificate_folder)) {
        mkdir($certificate_folder, 0755, true);
    }

    // Create a unique filename for the PDF inside the certificates folder
    $filename = "Certificate-{$user_id}-{$course_id}.pdf";
    $certificate_path = $certificate_folder . $filename;

    // Check if the old certificate file exists and remove it
    if (file_exists($certificate_path)) {
        unlink($certificate_path);
    }

    // Upload and save the new PDF file
    if (move_uploaded_file($pdf_data["tmp_name"], $certificate_path)) {
        // Add the uploaded file to the media library
        $attachment = array(
            'post_title' => $filename,
            'post_content' => '',
            'post_status' => 'inherit',
            'post_mime_type' => 'application/pdf'
        );

        $attach_id = wp_insert_attachment($attachment, $certificate_path);

        // Generate attachment metadata and update the attachment
        require_once ABSPATH . 'wp-admin/includes/image.php';
        $attach_data = wp_generate_attachment_metadata($attach_id, $certificate_path);
        wp_update_attachment_metadata($attach_id, $attach_data);

        // Get the permalink of the uploaded file
        $file_permalink = wp_get_attachment_url($attach_id);        
       
        // Return the path to the saved certificate
        echo $file_permalink;
    } else {
        // Error occurred while moving the file
        echo "Error: Unable to save the PDF file.";
    }
} else {
    // No PDF file data received
    echo "Error: PDF file data not received.";
}
?>
