<?php
    $emailExtract = ''; 
    if(isset($_POST['submit'])){ 
        // If file is selected 
        if(!empty($_FILES["pdf_file"]["name"])){ 
            // File upload path 
            $fileName = basename($_FILES["pdf_file"]["name"]); 
            $fileType = pathinfo($fileName, PATHINFO_EXTENSION); 
            
            // Allow certain file formats 
            $allowTypes = array('pdf'); 
            if(in_array($fileType, $allowTypes)){ 
                // Include autoloader file 
                include 'vendor/autoload.php'; 
                
                # code...
                // Initialize and load PDF Parser library 
                $parser = new \Smalot\PdfParser\Parser(); 

                // Source PDF file to extract text data 
                $pdfObj =  $_FILES["pdf_file"]["tmp_name"]; 
                
                // Parse pdf file using Parser library 
                $pdf = $parser->parseFile($pdfObj); 
                
                // Extract text from PDF 
                $textContent = $pdf->getText();


                //test string for checking email
                $email_patt = "/(?:[a-z0-9!#$%&'*+=?^_`{|}~-]+(?:\.[a-z0-9!#$%&'*+=?^_`{|}~-]+)*|\"(?:[\x01-\x08\x0b\x0c\x0e-\x1f\x21\x23-\x5b\x5d-\x7f]|\\[\x01-\x09\x0b\x0c\x0e-\x7f])*\")@(?:(?:[a-z0-9](?:[a-z0-9-]*[a-z0-9])?\.)+[a-z0-9](?:[a-z0-9-]*[a-z0-9])?|\[(?:(?:25[0-5]|2[0-4][0-9]|[01]?[0-9][0-9]?)\.){3}(?:25[0-5]|2[0-4][0-9]|[01]?[0-9][0-9]?|[a-z0-9-]*[a-z0-9]:(?:[\x01-\x08\x0b\x0c\x0e-\x1f\x21-\x5a\x53-\x7f]|\\[\x01-\x09\x0b\x0c\x0e-\x7f])+)\])/";


                //comapare using preg_match_all() method 
                $emails = preg_match_all($email_patt, $textContent, $valid);
                // print $return;

                return $emails;

                //display list of emails
                foreach ($valid[0] as $email) {

                    $emailExtract =  '<tr><td>' . 0 + 1 . "</td><td>"  . $email . "</td></tr>";
   
                }
                
                // Add line break 
                // $pdfText = nl2br($text); 
            }else{ 
                $statusMsg = '<p>Sorry, only PDF file is allowed to upload.</p>'; 
            } 
        }else{ 
            $statusMsg = '<p>Please select a PDF file to extract text.</p>'; 
        } 
    } 

    echo '<div class="align-center col-md-6">
                <table class="table table-bordered table-hover align-center">
                    <thead>
                        <tr>
                            <td>#Slno</td>
                            <td>Email Address</td>
                        </tr>
                    </thead>
                    <tbody>'
                       . $emailExtract .                       
                    "</tbody>
                </table>
            </div>";
 ?>           
    