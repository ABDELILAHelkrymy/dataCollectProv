<?php

// create a function to download a file based on its path and ajax request
function downloadFile($filePath)
{
    // check if the file exists
    if (file_exists($filePath)) {
        // set the headers
        header('Content-Description: File Transfer');
        header('Content-Type: application/pdf'); // Set Content-Type to PDF
        header('Content-Disposition: attachment; filename="' . basename($filePath) . '"');
        header('Expires: 0');
        header('Cache-Control: must-revalidate');
        header('Pragma: public');
        header('Content-Length: ' . filesize($filePath));
        readfile($filePath);
        exit;
    } else {
        // if the file does not exist, return an error message
        echo "File not found";
    }
}

// get the file path from the request
$filePath = $_POST['filePath'];

// call the downloadFile function
downloadFile($filePath);


