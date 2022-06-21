<?php 
try{
    include("includes/config.php");
    $Materialdata= Array();
    $GIFdata= Array();
    $Videodata= Array();
//Pushing Data for MaterialData starts
    foreach ($contents['Contents'] as $content) {
        $cmd = $s3Client->getCommand('GetObject',[
        'Bucket' => BUCKET,
        'Key'=>$content['Key']
        ]);
        $request = $s3Client->createPresignedRequest($cmd, '+20 minutes');
        $presignedUrl = (string)$request->getUri();
        $MaterialSubdata = array(
            "MaterialPreviewImageURL"=>$presignedUrl,
            "ArtBoardImgURL"=>$presignedUrl,
            "AnimalName"=> explode("?", substr($presignedUrl,51,53))[0] 
        );
        array_push($Materialdata,$MaterialSubdata);
    }
//Pushing Data for MaterialData Ends
//Pushing Data for GIFdata starts

$data = array();

array_push($data,array("GIF"=>"https://www.youtube.com/watch?v=ZcGRNqGVaLY&t=2s"));
array_push($data,array("GIF"=>"https://www.youtube.com/watch?v=ZcGRNqGVaLY&t=2s"));
// array_push($data,$subArray);
// $test['GIF'] = $GIFList;
    foreach ($contents['Contents'] as $content) {
        $cmd = $s3Client->getCommand('GetObject',[
        'Bucket' => BUCKET,
        'Key'=>$content['Key']
        ]);
        $request = $s3Client->createPresignedRequest($cmd, '+20 minutes');
        $presignedUrl = (string)$request->getUri();
        
    }
    $GIFSubdata = array(
            "AnimalName"=>"",
            "AnimalList"=>$data
        );
//array_push($GIFList,"123");


    array_push($GIFdata,$GIFSubdata);

//Pushing Data for GIFdata ends
//Pushing Data for Videodata starts
    foreach ($contents['Contents'] as $content) {
        $cmd = $s3Client->getCommand('GetObject',[
        'Bucket' => BUCKET,
        'Key'=>$content['Key']
        ]);
        $request = $s3Client->createPresignedRequest($cmd, '+20 minutes');
        $presignedUrl = (string)$request->getUri();
        $VideoSubdata = array(
            "AnimalName"=>explode("?", substr($presignedUrl,51,53))[0] ,
            "PreviewImageURL"=> $presignedUrl,
            "YTB_VideoURL"=> "https://www.youtube.com/watch?v=ZcGRNqGVaLY&t=2s"
        );
        array_push($Videodata,$VideoSubdata);
    }
//Pushing Data for Videodata ends

    header('Content-Type: application/json; charset=utf-8');
    echo json_encode(array('MaterialListPreviewScreen'=>$Materialdata,
        'GIFScreen'=>$GIFdata,
        'VideoPreviewScreen'=>$Videodata)
    );
}
catch(Exception $Ex){
    echo $Ex;
}
    
?>
