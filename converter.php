<?php

/**
 * @file
 * Docx to JSON converter example
 */

class Converter {

      protected $ouputText = '';
      public $fileName;
      protected $content = '';

      function __construct($filename) {
         $this->fileName = $filename;
         $this->checkFileExists();
      }

      protected function readDocX() {
          //https://stackoverflow.com/questions/19503653/how-to-extract-text-from-word-file-doc-docx-xlsx-pptx-php
          $zip = zip_open($this->fileName);  
          if (!$zip || is_numeric($zip)) return false;  
          while ($zip_entry = zip_read($zip)) {  
            if (zip_entry_open($zip, $zip_entry) == FALSE) continue;  
            if (zip_entry_name($zip_entry) != "word/document.xml") continue;  
            $this->content .= zip_entry_read($zip_entry, zip_entry_filesize($zip_entry));  
            zip_entry_close($zip_entry);  
          }// end while
          zip_close($zip);
          $this->content = str_replace('</w:r></w:p></w:tc><w:tc>', " ", $this->content);  
          $this->content = str_replace('</w:r></w:p>', "\r\n", $this->content);  
          $striped_content = strip_tags($this->content);  
          return $striped_content;
      }

      function docToJSON() {            
        $this->ouputText = $this->readDocX();
        $StringToArray = explode("\r\n", $this->ouputText);
        $this->ouputText = json_encode($StringToArray);
        return $this->ouputText;

      }

      protected function checkFileExists() {
        try {
          if(!file_exists($this->fileName)) {
                  throw new Exception('File Does Not Exists');
          }
          else  {
            return true;
          }
        } catch(Exception $e) {
          print_r($e->getMessage());
        }

      }
}

$docsfile = 'Faruq_Shaik_CV.docx';

$Obj = new Converter($docsfile);
$content = $Obj->docToJSON();
require_once("template.tpl.php");

?>