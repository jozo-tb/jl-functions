<?php
/*
    ***************************************************************************************
    FILE NAME: pictureFunctions.php
    DATE: August 16, 2022
    CREATED BY: JOHN LEE LORENZO
    DESCRIPTION: 
        ProcessFetchers()
        BATCH UPLOADING OF PICTURES
        NAMING CONVENTION OF FILE
                STUDENTNO.DATE.JPG
                EX: S1000.1660635631.JPG
                StudentNo       =>  S1000
                strtotime(now)  =>  1660635631
                file type       =>  jpg
                
                Syntax used: 
                    strtotime(now) Return the date now in Integer form to create unique naming
        fetchPicture()
        FETCHING OF PICTURES BASE ON LAST MODIFIED FILE
        
        
        UploadPicture()
        NOTE: 
        Download updated file from github: https://github.com/jozo-tb/jl-functions.git
        use default naming on input file to txtPicture
        
        
    *****************************************************************************************
*/

if(strlen($_POST["id_number"])>0){
    $response = 0.99;
    if(isset($_FILES['txtPicture']['tmp_name'])){
        UploadPicture($_POST["path"],$postValue,$_POST["id_number"]);
    }
    echo $response;
}

function UploadPicture($target_dir,$postValue,$IDNumber,$isLimitFile=FALSE){
    if($target_dir==$_SESSION["gMCStudentPictDir"] || $target_dir==$_SESSION["gMCPictDir"]){
//                 $target_dir = explode("/",$target_dir)[5]."/";
    }
    $target_file = $target_dir . $IDNumber.".".strtotime(now).".jpg";
    $response = 1;
    $imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));
    
    //Check if file is set
    if(!empty($_FILES['txtPicture']['tmp_name']) || is_uploaded_file($_FILES['txtPicture']['tmp_name'])){
        // Check if image file is a actual image or fake image
        if(isset($postValue)) {
            $check = getimagesize($_FILES["txtPicture"]["tmp_name"]);
            if($check !== false) {
                $response = 1.1;
            } else {
                $response = 0.1;
            }
        }
        // Check if file already exists
        if (file_exists($target_file)) {
            $message = "Sorry, file already exists.";
            $response = 0.2;
        }
        if($isLimitFile==TRUE){
        // Check file size
        if ($_FILES["txtPicture"]["size"] > 500000) {
            $message = "Sorry, your file is too large.";
            $response = 0.3;
        }
        }
        // Allow certain file formats
        if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg" && $imageFileType != "gif" ) {
          $message =   "Sorry, only JPG, JPEG";
            $response = 0.4;
        }

        // Check if $uploadOk is set to 0 by an error
        if ($response == 0) {
            $message = "Sorry, your file was not uploaded.";
            // if everything is ok, try to upload file
        } else {
            if (move_uploaded_file($_FILES["txtPicture"]["tmp_name"], $target_file)) {
                 $message =  "The file ". htmlspecialchars( basename($target_file)). " has been uploaded.";
                 $response = 1.2;
            } else {
                 $message = "Sorry, there was an error uploading your file.";
                 $response = 0.5;
            }
        }
        echo $target_dir;
        
    }
}
function ProcessFetchers($target_dir){
    $DateNow = date("Y-m-d", strtotime(now));
    $j=0;
    $k=0;
    $l=0;
    $x =0;
    $tempDIR = $target_dir."tmp/";

    $zip = new ZipArchive;
    $txtFilename =  $_FILES['myfile']['name'][0];
    $res = $zip->open($target_dir.$txtFilename);

    exec(" rm $target_dir".$txtFilename);

    if ($res === TRUE) {
    $zip->extractTo($tempDIR);
    $zip->close();

    }

    $files = array_diff(scandir($tempDIR,1), array('..', '.','index.html'));
    for($i=0; $i<count($files); $i++){
    $old_Name= $files[$i];
    $new_Name=  explode(".",$old_Name)[0].".".strtotime(now).".".explode(".",$old_Name)[1];
    $rename = " mv $tempDIR".$old_Name." ".$target_dir.$new_Name;
    exec($rename);
    $remove = " rmdir $tempDIR";
    exec($remove);
    }
    $process .= "Upload Successful!";
    $txtBGColor =  "background-color:#57f75c;";
    $txtBGColor .= "text-align:center;";
    $txtBGColor .= "padding:2%;";
    $txtBGColor .= "font-size: 15px;";
    $txtBGColor .= "border-radius: 5px;";

    closedir($handle);

    return "$process|$txtBGColor";
}
function fetchPicture($IDNumber, $target_dir){
            if($target_dir==$_SESSION["gMCStudentPictDir"] || $target_dir==$_SESSION["gMCPictDir"]){
                $target_dir = explode("/",$target_dir)[5]."/";
            }
            $files = array_diff(scandir($target_dir,1), array('.', '..', 'index.html'));
            $arrLast = array();
            for($i = 0,$y=0; $i<count($files)+3; $i++){
                if (file_exists($target_dir.$files[$i])) {
                    if(!empty($files[$i])){
                        if(explode(".", $files[$i])[0]==strtoupper($IDNumber)){
                            $arrLast[$y]=$files[$i];
                            $y++;
                        }
                    }
                }
            }
            if(count($arrLast)>1){
                if(count(explode(".",$arrLast[0]))==2){
                
                array_splice($arrLast,0,2);
                }
                
            }
            if($_SESSION["gSessionUser"]=="bmackay"){
//                 echo "<pre>";
//                 print_r($arrLast);
//                 exit;
            }
            $path = $target_dir.$arrLast[0]; 
            return $path;
}
?>
