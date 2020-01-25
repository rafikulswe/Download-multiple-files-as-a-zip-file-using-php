<?php  
 $error = ""; //error holder  
 if(isset($_POST['createpdf']))  
 {  
      $post = $_POST;   
      $file_folder = "files/"; // folder to load files  
      if(extension_loaded('zip'))  
      {   
           // Checking ZIP extension is available  
           if(isset($post['files']) and count($post['files']) > 0)  
           {   
                // Checking files are selected  
                $zip = new ZipArchive(); // Load zip library   
                $zip_name = time().".zip";           // Zip name  
                if($zip->open($zip_name, ZIPARCHIVE::CREATE)!==TRUE)  
                {   
                     // Opening zip file to load files  
                     $error .= "* Sorry ZIP creation failed at this time";  
                }  
                foreach($post['files'] as $file)  
                {   
                     $zip->addFile($file_folder.$file); // Adding files into zip  
                }  
                $zip->close();  
                if(file_exists($zip_name))  
                {  
                     // push to download the zip  
                     header('Content-type: application/zip');  
                     header('Content-Disposition: attachment; filename="'.$zip_name.'"');  
                     readfile($zip_name);  
                     // remove zip file is exists in temp path  
                     unlink($zip_name);  
                }  
           }  
           else  
           {  
                $error .= "* Please select file to zip ";  
           }  
      }  
      else  
      {  
           $error .= "* You dont have ZIP extension";  
      }  
 }  
 ?>  
 <html>  
      <head>  
           <title>Webslesson Tutorial</title>  
           <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" />  
           <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>  
           <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.0/jquery.min.js"></script>  
      </head>  
      <body>  
           <div class="container">  
                <br />  
                <br />  
                <br />  
                <form name="zips" method="post">  
                     <?php echo $error; ?>  
                     <table class="table table-bordered">  
                          <tr>  
                               <th>*</th>  
                               <th>File Name</th>  
                          </tr>  
                          <tr>  
                               <td><input type="checkbox" name="files[]" value="image1.jpg" /></td>  
                               <td>image1.jpg</td>  
                          </tr>  
                          <tr>  
                               <td><input type="checkbox" name="files[]" value="image2.jpg" /></td>  
                               <td>image2.jpg</td>  
                          </tr>  
                          <tr>  
                               <td><input type="checkbox" name="files[]" value="image3.jpg" /></td>  
                               <td>image3.jpg</td>  
                          </tr>  
                          <tr>  
                               <td><input type="checkbox" name="files[]" value="1.xlsx" /></td>  
                               <td>1.xlsx</td>  
                          </tr>  
                          <tr>  
                               <td><input type="checkbox" name="files[]" value="2.docx" /></td>  
                               <td>2.docx</td>  
                          </tr>  
                          <tr>  
                               <td><input type="checkbox" name="files[]" value="3.pdf" /></td>  
                               <td>3.pdf</td>  
                          </tr>  
                          <tr>  
                               <td colspan="2"><input type="submit" name="createpdf" value="Download as ZIP" />&nbsp;  
                               <input type="reset" name="reset" value="Reset" /></td>  
                          </tr>  
                     </table>  
                </form>  
           </div>  
      </body>  
 </html>