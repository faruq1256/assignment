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
		    return $this->mysqli;
		}

		public function DBQuery($sql) {
			//$this->DBConnect();
			$result = $this->mysqli->query($sql);
			if($result) {
            return $result;
			}
			else {
				return $this->mysqli->error;
			}

		}

		public function SelectQuery($sql) { 
			$result = $this->mysqli->query($sql);
      $resultSet = $result->fetch_array(MYSQLI_ASSOC);
			return $resultSet;
		}

}



class shortURL extends Database {

  public $maxChars = 4;
  private $keys = "0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz_"; //keys to be chosen from
  public $longURL = '';
  public $shortURL = '';
  public $result;
  protected $fullURL;
  public $basePath;

	function __construct() {
		parent::__construct();
		$this->fullURL  = "http://$_SERVER[HTTP_HOST]$_SERVER[PHP_SELF]";
		$this->basePath = "http://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
		
		//echo $_SERVER['QUERY_STRING'];
		if(strlen($this->basePath) > strlen($this->fullURL)) {
			$this->redirectOriginalURL();
		}
		else {
			$this->index();
		}

		

	}

	function index() {
		if($_POST) {
       $this->longURL = $_POST['longURL'];
       $this->makeShortCode();
       $output = $this->fullURL .'/?'. $this->shortURL;

		}
		include_once("index.tpl.php");
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
  		$this->maxChars = $this->maxChars +1;
  		$this->makeShortCode();

  	}
  }

	public function saveData() {
		$this->shortTags();
		// $this->longURL = 'http://sample.com';
		$query = "INSERT INTO  `unique_urls`(full_url, unique_id) VALUES ('" . $this->longURL . "', '" . $this->shortURL . "')";
		return $this->result = $this->DBQuery($query);
	}

	function redirectOriginalURL() {
		$queryString = $_SERVER["QUERY_STRING"];
		$query = "SELECT full_url FROM unique_urls WHERE unique_id = '" .$queryString. "'";
		$this->result = $this->SelectQuery($query);
		if(isset($this->result) && $this->result != '') {
       header('Location: ' . $this->result['full_url']);
		}
		else {
			print "Invalid Short Code Supplied";
		}
	}


}

$Obj = new shortURL();	

?>