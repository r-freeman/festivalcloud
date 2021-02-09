<?php
require $_SERVER['DOCUMENT_ROOT'] . '/vendor/autoload.php';

if (isset($_SERVER['ENVIRONMENT']) && $_SERVER['ENVIRONMENT'] === 'production') {
    // read aws credentials from environment variables
    $s3_config = array(
        'key' => $_SERVER['AWS_ACCESS_KEY_ID'],
        'secret' => $_SERVER['AWS_SECRET_KEY'],
        'region' => 'us-east-1',
        'version' => '2006-03-01',
    );
} else {
    // read aws credentials from ~/.aws/credentials
    $s3_config = array(
        'profile' => 'default',
        'region' => 'us-east-1',
        'version' => '2006-03-01',
    );
}

define('S3_BUCKET', 'elasticbeanstalk-us-east-1-596313505871');

use Aws\S3\S3Client;
use Aws\S3\Exception\S3Exception;

function is_logged_in()
{
    start_session();
    return (isset($_SESSION['user']));
}

function start_session()
{
    $id = session_id();
    if ($id === "") {
        session_start();
    }
}

function old($index, $default = null)
{
    if (isset($_POST) && is_array($_POST) && array_key_exists($index, $_POST)) {
        echo $_POST[$index];
    } else if ($default !== null) {
        echo $default;
    }
}

function error($index)
{
    global $errors;

    if (isset($errors) && is_array($errors) && array_key_exists($index, $errors)) {
        echo $errors[$index];
    }
}

function dd($value)
{
    echo '<pre>';
    print_r($value);
    echo '</pre>';
    exit();
}

function imageFileUpload($name, $required, $maxSize, $allowedTypes, $fileName)
{
    global $s3_config;
    $objectUrl = 'uploads/default.png';

    if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_FILES[$name]) && $_FILES[$name]['error'] == UPLOAD_ERR_OK && is_uploaded_file($_FILES[$name]['tmp_name'])) {
        $imageFileType = pathinfo($_FILES[$name]['name'], PATHINFO_EXTENSION);

        // validate that the file extension belongs to one of the allowed types
        if (in_array($imageFileType, $allowedTypes)) {
            // check file is an image
            $imageInfo = getimagesize($_FILES[$name]['tmp_name']);
            if ($imageInfo === false) {
                throw new Exception("File is not an image.");
            }
            // file is an image with valid extension, append it to the file name
            $fileName = $fileName . '.' . $imageFileType;
        } else {
            throw new Exception("Sorry, only " . implode(',', $allowedTypes) . " files are allowed.");
        }

        // check that the file does not exceed the max size
        if ($_FILES[$name]["size"] > $maxSize) {
            throw new Exception("Sorry, your file is too large.");
        }

        try {
            // initialise the s3 client
            $s3 = new S3Client($s3_config);

            // upload to s3 and get the object url
            $upload = $s3->upload(S3_BUCKET, $fileName, fopen($_FILES[$name]['tmp_name'], 'rb'), 'public-read');
            $objectUrl = htmlspecialchars($upload->get('ObjectURL'));
        } catch (Exception $e) {
            echo $e->getMessage() . "\n";
        }
    }

    // return the object url to store in db
    return $objectUrl;
}
