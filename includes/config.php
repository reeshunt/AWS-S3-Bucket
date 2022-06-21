<?php 
ini_set ( 'display_errors',1 );
// // require the AWS SDK for PHP librar
 require 'aws/aws-autoloader.php';
 use Aws\S3\S3Client;
// try{
    define('AWS_KEY', 'XXXXXXXXXXXXXXXXXXXX');
    define('AWS_SECRET_KEY', 'XXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXX');
    define('HOST', 'https://s3.ap-south-1.amazonaws.com');
    define('REGION', 'ap-south-1');
    define('BUCKET', 'animal-drawing');
    // // Establish connection with DreamObjects with an S3 client.
    $s3Client = new Aws\S3\S3Client([
    'version'     => '2006-03-01',
    'region'      => REGION,
    'endpoint'    => HOST,
        'credentials' => [
        'key'      => AWS_KEY,
        'secret'   => AWS_SECRET_KEY,
    ],
    ]);
    
    $contents = $s3Client->listObjects([
        'Bucket' => BUCKET,
    ]);
    ?>