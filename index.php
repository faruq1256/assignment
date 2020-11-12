<?php

error_reporting(E_ALL);
ini_set("display_errors", 1);

class TicTocToe {

	var $winstate = 0;
	var $values = array();

	function __construct() {
		$this->index();
	}

	function index() {

		if(empty($_GET['values'])){
		    //initializing the board
		    $this->values = array_fill(0,9,0);
		    //determine who begins at random
		    if(mt_rand(0,1)){
		        $this->values = $this->playerTurn($this->values);
		    }
		}else{
		    //get the board
		    $this->values = explode(',',$_GET['values']);
		    //Check if a player X won, if not, player 0 plays its turn.
		    $this->winstate = $this->isWinState($this->values);
		    if($this->winstate==0){
		        $this->values = $this->playerTurn($this->values);
		    }
		    //Check if a player 0 won
		    $this->winstate = $this->isWinState($this->values);    
		}	
		
		 include_once("index.tpl.php");


	}

	//Player O plays its turn at random
function playerTurn($board){
    if(in_array(0,$board)){
        $i = mt_rand(0,8);
        while($board[$i]!=0){
            $i = mt_rand(0,8);
        }
        $board[$i]=-1;
    }
    return $board;
}

function isWinState($board){
    $winning_sequences = '012345678036147258048642';
    for($i=0;$i<=21;$i+=3){
        $player = $board[$winning_sequences[$i]];
        if($player == $board[$winning_sequences[$i+1]]){
            if($player == $board[$winning_sequences[$i+2]]){
                if($player!=0){
                    return $player;
                }
            } 
        }   
    }
    return 0;
}	

}

$Obj = new TicTocToe();
?>