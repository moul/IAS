<?php
//headers for permit CORS, 
//This  permit me to test this bot,  using this web page
//https://botsarena.tinad.fr/testBotScripts/tictactoe.html
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET, POST'); 
header('Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type, Accept');

//get the query onto $message 
$message=json_decode(file_get_contents('php://input'), TRUE);

if($message['action'] == "init"){
  //It's the init message
  echo '{"name":"stupidAI"}';
  die;
}

$cellsKeys=array("0-0","0-1","0-2","1-0","1-1","1-2","2-0","2-1","2-2");

//list the free cells
$freeCells=array();
foreach($cellsKeys as $key){
	if (!isset($message['board'][$key])){
		echo "wrong parameters ".$case; die;
	}
	if($message['board'][$key] == ""){
		$freeCells[] = $key;
	}
}

if (count($freeCells) == 0){
	echo "error. Board is full i can't play";
	die;
}
//Stupid IA, juste random
shuffle($freeCells);
echo '{"play":"'.$freeCells[0].'"}';
