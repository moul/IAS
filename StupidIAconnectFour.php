<?php
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET, POST'); 
header('Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type, Accept');

/*
* stupid IA for battle ship
* choose by random a free column
*/
$in=file_get_contents('php://input');
$params=json_decode($in, TRUE);
switch($params['action']){
	case "init":
		echo '{"name":"Stupid AI"}';
		break;
	case "play-turn":

		$grid=$params['board'];
		$colAvailable=array();
		//dont play on full colomns
		for($i=0;$i<7;$i++){
  			if($grid[5][$i] == ""){
    				$colAvailable[]=$i;
  			}
		}
		//ia am stupid, just random
		shuffle($colAvailable);
		echo '{"play":"'.$colAvailable[0].'"}';
		break;
	default:
		break;
}
