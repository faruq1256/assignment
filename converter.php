<?php
error_reporting(E_ALL);
ini_set("display_errors", 1);

class Converter {

      protected $ouputText = '';
      public $fileName = '';

      function __construct($filename) {
           $this->fileName = $filename;

      }

      protected function readDocX() {
            $content = '';
            if($this->checkFileExists()) {

                  $zip = zip_open($this->fileName);  
                  if (!$zip || is_numeric($zip)) return false;  
                  while ($zip_entry = zip_read($zip)) {  
                    if (zip_entry_open($zip, $zip_entry) == FALSE) continue;  
                    if (zip_entry_name($zip_entry) != "word/document.xml") continue;  
                    $content .= zip_entry_read($zip_entry, zip_entry_filesize($zip_entry));  
                    zip_entry_close($zip_entry);  
                  }// end while
                  zip_close($zip);
                  $content = str_replace('</w:r></w:p></w:tc><w:tc>', " ", $content);  
                  $content = str_replace('</w:r></w:p>', "\r\n", $content);  
                  $striped_content = strip_tags($content);  
                  return $striped_content;
            }
      }

      function docToJSON() {            
            $this->ouputText = $this->readDocX($this->fileName);
            $StringToArray = explode("\r\n", $this->ouputText);
            $JSONString = json_encode($StringToArray);
            return $JSONString;

      }

      protected function checkFileExists() {
            if(!file_exists($this->fileName)) {
                  return false;
            }
            else {
                  return true;
            }
      }
}

$docsfile = 'Faruq_Shaik_CV.docx';

$Obj = new Converter($docsfile);
$content = $Obj->docToJSON();
require_once("template.tpl.php");

?>