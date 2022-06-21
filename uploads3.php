<?php
include("includes/config.php");

// Check if the form was submitted
if($_SERVER["REQUEST_METHOD"] == "POST"){

    // Check if file was uploaded without errors
    if(isset($_FILES["uploadfile"]) && $_FILES["uploadfile"]["error"] == 0){
    $allowed = array("jpg" => "image/jpg", "jpeg" => "image/jpeg", "gif" => "image/gif", "png" => "image/png", "mp4"=> "video/mp4");
    $renamefile = $_POST["rename_file"];
    if($renamefile != null){
        $tmp = rand(1,9);
      $filename =   $renamefile.''.$tmp.''. $_FILES["uploadfile"]["name"];
    }else{
        $filename = $_FILES["uploadfile"]["name"];
        
    }
    $filetype = $_FILES["uploadfile"]["type"];
    $filesize = $_FILES["uploadfile"]["size"];


    // Validate file extension
    $ext = pathinfo($filename, PATHINFO_EXTENSION);

   
if ($ext !== 'gif' || $ext !== 'png' || $ext !== 'jpg' || $ext == 'mp4') {
    echo 'error';
}

    if(!array_key_exists($ext, $allowed)) die("Error: Please select a valid file format.");
    // Validate file size - 10MB maximum
    $maxsize = 10 * 1024 * 1024;
    if($filesize > $maxsize) die("Error: File size is larger than the allowed limit.");
        // Validate type of the file
        if(in_array($filetype, $allowed)){
            // echo "$ext.$filetype";

            // Check whether file exists before uploading it
            // if(file_exists("upload/GifImg_dir/" . $filename)){
            //     echo $filename . " is already exists.";
            // } else{

                if($ext == 'gif'){
                    //echo "gifffffffffffffffffffffffffffffffffff";
                    $path = 'GifImg_dir';
                    // $uploadfile = move_uploaded_file($_FILES["uploadfile"]["tmp_name"], "upload/GifImg_dir/" . $filename);
            //    exit;
                }else if($ext == 'jpg' || $ext == 'png'|| $ext == 'jpeg'){
                    echo "image";
                    $path = 'Img_dir';
                    // $uploadfile = move_uploaded_file($_FILES["uploadfile"]["tmp_name"], "upload/imageupload/" . $filename);
                    
                }else{
                    echo "video";
                    $path = 'Video_dir';
                    // $uploadfile = move_uploaded_file($_FILES["uploadfile"]["tmp_name"], "upload/videoupload/" . $filename);
                }
                if(move_uploaded_file($_FILES["uploadfile"]["tmp_name"], "upload/" . $filename)){
                $bucket = 'animal-drawing';
                //$file_Path = _DIR_ . '/upload/'. $filename;
                $file_Path = 'upload/'. $filename;
                
                $key = basename($file_Path);

                try {
                    $result = $s3Client->putObject([
                    'Bucket' => $bucket,
                    'Key'    => $path. '/' .$key,
                    'Body'   => fopen($file_Path, 'r'),
                    'ACL'    => 'public-read', // make file 'public'
                    ]);
                    //echo $file_Path;
                    // exit;
                    // echo "Image uploaded successfully. Image path is: ". $result->get('ObjectURL');
                } catch (Aws\S3\Exception\S3Exception $e) {
                    echo "There was an error uploading the file.\n";
                    echo $e->getMessage();
                }
                //header("Location: list.php");
                     echo "Your file was uploaded successfully.";
                }else{
                    echo "File is not uploaded";
                }
            // } 
        } else{
        echo "Error: There was a problem uploading your file. Please try again."; 
        }
    } else{
    echo "Error: " . $_FILES["uploadfile"]["error"];
}
}
?>