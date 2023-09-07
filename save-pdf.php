<?php
include($_SERVER['DOCUMENT_ROOT'].'/wordpress/wp-load.php');

// Check if the user is logged in and has appropriate permissions
if (!is_user_logged_in() || !current_user_can("upload_files")) {
    die("Access denied.");
}

// Check if the PDF file data has been posted
if (isset($_FILES["pdf"])) {
    $pdf_data = $_FILES["pdf"];

    // Create a unique filename for the PDF
    $upload_dir = wp_upload_dir();
    $filename = sanitize_file_name($pdf_data["name"]);
    $upload_path = $upload_dir["path"] . "/" . $filename;

    // Check if the file already exists and generate a unique filename if needed
    $i = 1;
    while (file_exists($upload_path)) {
        $filename = sanitize_file_name(pathinfo($pdf_data["name"], PATHINFO_FILENAME)) . "_" . $i . "." . pathinfo($pdf_data["name"], PATHINFO_EXTENSION);
        $upload_path = $upload_dir["path"] . "/" . $filename;
        $i++;
    }

    // Move the uploaded PDF to the uploads directory
    if (move_uploaded_file($pdf_data["tmp_name"], $upload_path)) {
        // Create a new attachment post in the WordPress media library
        $attachment = array(
            "post_mime_type" => $pdf_data["type"],
            "post_title" => sanitize_file_name(pathinfo($filename, PATHINFO_FILENAME)),
            "post_content" => "",
            "post_status" => "inherit",
        );

        $attach_id = wp_insert_attachment($attachment, $upload_path);
        require_once(ABSPATH . "wp-admin/includes/image.php");
        $attach_data = wp_generate_attachment_metadata($attach_id, $upload_path);
        wp_update_attachment_metadata($attach_id, $attach_data);

        // Return the attachment ID
        echo $attach_id;
    } else {
        // Error occurred while moving the file
        echo "Error: Unable to save the PDF file.";
    }
} else {
    // No PDF file data received
    echo "Error: PDF file data not received.";
}
