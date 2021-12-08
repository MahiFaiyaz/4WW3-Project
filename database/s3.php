<?php
    // Information for setting up s3 client (accessKey and secretAccessKey are stored in the keyInfo folder (not submitted))
    require '../vendor/autoload.php';
    require 'keyInfo.php';
	
	use Aws\S3\S3Client;
	use Aws\S3\Exception\S3Exception;

    $s3Client = new S3Client([
        'credentials' => [
            'key' => $accessKeyId,
            'secret' => $secretAccessKey
        ],
        'version' => 'latest',
        'region' => 'us-east-2'
    ]);
?>