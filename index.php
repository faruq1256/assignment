<?php

class Database{
		private $host;
		private $user;
		private $pass;
		private $db;
		public $mysqli;

		function __construct() {
			$this->DBConnect();
		}

		function DBConnect(){
		    $this->host = 'localhost';
		    $this->user = 'root';
		    $this->pass = '';
		    $this->db = 'short_url';

		    $this->mysqli = new mysqli($this->host, $this->user, $this->pass, $this->db);
		   // print_r($this->mysqli);
		    return $this->mysqli;
		}

		public function DBInsert($sql) {
			//$this->DBConnect();
			$result = $this->mysqli->query($sql);
			print_r($result);
			if($result) {
            return $result;
			}
			else {
				return $this->mysqli->error;
			}

		}


}



class shortURL extends Database {

  public $maxChars = 4;
  private $keys = "0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz_"; //keys to be chosen from
  public $longURL = '';
  public $shortURL = '';
  public $result;

	function __construct() {
		parent::__construct();

	}

	function shortTags()  {
    $i = 0;
    $keys_length = strlen($this->keys);
    $url  = "";
    while($i<$this->maxChars)
    {
        $rand_num = mt_rand(1, $keys_length-1);
        $this->shortURL .= $this->keys[$rand_num];
        $i++;
    }
    //return $this->shortURL;
  }

  function makeShortCode() {
  	$res = $this->saveData();
  	if(strpos($res, 'Duplicate entry') !== false) {
  		$this->maxChars = 5;
  		$this->saveData();

  	}
  }

	public function saveData() {
		$this->shortTags();
		$this->longURL = 'http://sample.com';
		echo $query = "INSERT INTO  `unique_urls`(full_url, unique_id) VALUES ('" . $this->longURL . "', '" . $this->shortURL . "')";
		return $this->result = $this->DBInsert($query);
	}


}

$Obj = new shortURL();	
$Obj->makeShortCode();
?>