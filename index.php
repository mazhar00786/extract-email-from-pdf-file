<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
</head>

<body>
    <center>
    <div class="card col-md-6 mt-4 align-center p-4">
        <!-- <form action="fetch-email.php" method="post" class="form mt-4" enctype="multipart/form-data">
            <div class="form-input">
                <label for="pdf_file">PDF File</label>
                <input type="file" name="pdf_file" placeholder="Select a PDF file" required="">
            </div>
            <input type="submit" name="submit" class="btn" value="Extract Text">
        </form> -->

        <form action="#" method="post" id="myform" class="xy-4" enctype="multipart/form-data">
            <div class="mb-3">
                <label for="InputPDF" class="form-label">Upload PDF File</label>
                <input type="file" name="pdf_file" class="form-control" id="InputPDF" required/>
                
            </div>
            <button type="submit" id="btn"  name="submit" class="btn btn-outline-primary">Extract Email</button>
            <a type="button" id="btn"  name="submit" class="btn btn-outline-secondary" href="/php-pdf-to-email/">Clear</a>
        </form>
    </div></center>


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

                    // return $emails;

                    //display list of emails
                    foreach ($valid[0] as $email) {

                        // $emailExtract =  '<tr><td>'  . $email . '</td></tr>';
                        echo  '<center><div class="card col-md-3 bordered"><li class="m-4 text-left">' 
                         . $email . '</li></div></center>';
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

        // echo '<div class="align-center col-md-6">
        //             <table class="table table-bordered table-hover align-center">
        //                 <thead>
        //                     <tr>
                              
        //                         <td>Email Address</td>
        //                     </tr>
        //                 </thead>
        //                 <tbody>'
        //                 . $emailExtract .                       
        //                 "</tbody>
        //             </table>
        //         </div>";
    ?>   
</body>

</html>

