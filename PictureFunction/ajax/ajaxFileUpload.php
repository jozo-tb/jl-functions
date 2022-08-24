<?php

/*
    ***************************************************************************************
    FILE NAME: ajaxFileUpload.php
    DATE: August 22, 2022
    CREATED BY: JOHN LEE LORENZO
    DESCRIPTION: 
    Uploading file using ajax
        
    *****************************************************************************************
*/


if(isset($_FILES['txtPicture']['name'])){
   // file name
   $filename = $_POST["id_number"].".".strtotime(now).".jpg";
   // Location
   $location = $_POST['file_path'].$filename;

   // file extension
   $file_extension = pathinfo($location, PATHINFO_EXTENSION);
   $file_extension = strtolower($file_extension);

   // Valid extensions
   $valid_ext = array("jpg","png","jpeg");

   $response = 0;
   if(in_array($file_extension,$valid_ext)){
      // Upload file
      if(move_uploaded_file($_FILES['txtPicture']['tmp_name'],$location)){
         $response = 1;
      }
    }
 
   echo $response;
   exit;
}
?>
