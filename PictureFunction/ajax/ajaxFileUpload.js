/*
 * 
 ****************************************************************************************
 * FILE NAME: ajaxFileUpload.js
 * DATE: August 22, 2022
 * CREATED BY: JOHN LEE LORENZO
 * DESCRIPTION: 
 * Uploading file using ajax
 *     
 *****************************************************************************************
 * 
 */

function AjaxUploadFile(path,files,idNumber) {
    console.log("John Lee: Pogi");
    console.log("Path: "+ path);
    console.log("ID Number: "+ idNumber);
   if(files.length > 0 ){

      var formData = new FormData();
      formData.append("txtPicture", files[0]);
      formData.append("file_path", path);
      formData.append("id_number", idNumber);
      var xhttp = new XMLHttpRequest();
        
      // Set POST method and ajax file path
//       xhttp.open("POST", "../PictureFunction/pictureFunctions.php", true);
      xhttp.open("POST", "../PictureFunction/ajax/ajaxFileUpload.php", true);

      // call on request changes state
      xhttp.onreadystatechange = function() {
         if (this.readyState == 4 && this.status == 200) {
             
           var response = this.responseText;
           if(response == 1){
              result = "Upload successfully.";
           }else{
              result = "File not uploaded.";
           }
           
                console.log("Ready state: "+ this.readyState);
                console.log("Status: "+this.status);
                console.log("Response: "+ this.responseText);
                console.log("Result: "+ result);
         }
                
         
      };

      // Send request with data
      xhttp.send(formData);

   }else{
      alert("Please select a file");
   }

}
