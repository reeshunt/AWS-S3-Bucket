<?php 
try{
    include("includes/config.php");
    //global arrays declared for being used later while sending json as response
    $Materialdata= Array();
    $GIFdata= Array();
    $Videodata= Array();
    
//Data for MaterialData starts
   foreach ($contents['Contents'] as $content) {
       //looping through all the items in s3 bucket
        $cmd = $s3Client->getCommand('GetObject',[
        'Bucket' => BUCKET,
        'Key'=>$content['Key']
        ]);
        $request = $s3Client->createPresignedRequest($cmd, '+20 minutes');
        $presignedUrl = (string)$request->getUri();
        if(explode("?",substr($presignedUrl,51,53))[0]!="GifImg_dir/"&&explode("?",substr($presignedUrl,51,53))[0]!="Video_dir/"&&explode("?",substr($presignedUrl,51,53))[0]!="Img_dir/"){ 
            //for removing the directories in response as we want only files
            if(explode("/",explode("?", substr($presignedUrl,51,53))[0])[0]=="Img_dir"){
                //filtering the response as we want only the images here which are present in Img_dir
                $MaterialSubdata = array(
                "MaterialPreviewImageURL"=>$presignedUrl,
                "ArtBoardImgURL"=>$presignedUrl,
                "AnimalName"=> str_replace(".png","",explode("/",explode("?", substr($presignedUrl,51,53))[0])[1])
            );
            //pushing the array into the global array so that we can forward the data in the header as json
            array_push($Materialdata,$MaterialSubdata);    
            }
        }
    } 
    
//Data for MaterialData Ends

//Data for GIFdata starts

$data = array();

    foreach ($contents['Contents'] as $content) {
        $cmd = $s3Client->getCommand('GetObject',[
        'Bucket' => BUCKET,
        'Key'=>$content['Key']
        ]);
        $request = $s3Client->createPresignedRequest($cmd, '+20 minutes');
        $presignedUrl = (string)$request->getUri(); 
        if(explode("?",substr($presignedUrl,51,53))[0]!="GifImg_dir/"&&explode("?",substr($presignedUrl,51,53))[0]!="Video_dir/"&&explode("?",substr($presignedUrl,51,53))[0]!="Img_dir/")
        { 
            if(explode("/",explode("?", substr($presignedUrl,51,53))[0])[0]=="GifImg_dir"){
                array_push($data,array("GIF"=>$presignedUrl));
            }
            
        }        
    }
    $GIFSubdata = array(
            "AnimalName"=>"cat",
            "AnimalList"=>$data
        );
    array_push($GIFdata,$GIFSubdata);

//Data for GIFdata ends
//Data for Videodata starts
    foreach ($contents['Contents'] as $content) {
        $cmd = $s3Client->getCommand('GetObject',[
        'Bucket' => BUCKET,
        'Key'=>$content['Key']
        ]);
        $request = $s3Client->createPresignedRequest($cmd, '+20 minutes');
        $presignedUrl = (string)$request->getUri();
        if(explode("?",substr($presignedUrl,51,53))[0]!="GifImg_dir/"&&explode("?",substr($presignedUrl,51,53))[0]!="Video_dir/"&&explode("?",substr($presignedUrl,51,53))[0]!="Img_dir/"){ 
            if(explode("/",explode("?", substr($presignedUrl,51,53))[0])[0]=="Video_dir"){
                $VideoSubdata = array(
                    "AnimalName"=>str_replace(".mp4","",explode("/",explode("?", substr($presignedUrl,51,53))[0])[1]),
                    "PreviewImageURL"=> $presignedUrl,
                    "YTB_VideoURL"=> $presignedUrl
                );
                array_push($Videodata,$VideoSubdata);  
            }
        }
    }
//Data for Videodata ends


//sending response with json content type
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
