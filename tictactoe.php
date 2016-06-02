<?php
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET, POST'); 
header('Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type, Accept');
/*
* Tic Tac Toe gnieark's IA V2
* Gnieark 2016
* licensed under the Do What the Fuck You Want to Public License http://www.wtfpl.net/
*/

//get the query
$message=json_decode(file_get_contents('php://input'), TRUE);

if($message['action'] == "init"){
  //juste le petit message d'init
  echo '{"name":"gnieark"}';
  die;
}


function score_case($map,$me,$him,$case,$depth=0){
  //test si la case est gagnante
  $newMap=$map;
  $newMap[$case] = $me;
  
    if(
            (($newMap['0-0']==$newMap['0-1'])&&($newMap['0-1']==$newMap['0-2'])&&($newMap['0-2']!==""))
        OR  (($newMap['1-0']==$newMap['1-1'])&&($newMap['1-1']==$newMap['1-2'])&&($newMap['1-2']!==""))
        OR  (($newMap['2-0']==$newMap['2-1'])&&($newMap['2-1']==$newMap['2-2'])&&($newMap['2-2']!==""))
        OR  (($newMap['0-0']==$newMap['1-0'])&&($newMap['1-0']==$newMap['2-0'])&&($newMap['2-0']!==""))
        OR  (($newMap['0-1']==$newMap['1-1'])&&($newMap['1-1']==$newMap['2-1'])&&($newMap['2-1']!==""))
        OR  (($newMap['0-2']==$newMap['1-2'])&&($newMap['1-2']==$newMap['2-2'])&&($newMap['2-2']!==""))
        OR  (($newMap['0-0']==$newMap['1-1'])&&($newMap['1-1']==$newMap['2-2'])&&($newMap['2-2']!==""))
        OR  (($newMap['0-2']==$newMap['1-1'])&&($newMap['1-1']==$newMap['2-0'])&&($newMap['2-0']!==""))
    ){
        return 10 - $depth;
    }else{
      if($depth == 9){
	return 0;
      }else{
	$sc=choose_better_cell($newMap,$him,$me,$depth + 1);
	return -$depth + $sc[1];
      }
    }
}
function choose_better_cell($map,$me,$him,$depth=0){
    $betterCell="";
    $betterScore=-100;
    static $arrCells= array('0-0','0-1','0-2','1-0','1-1','1-2','2-0','2-1','2-2');
    foreach($arrCells as $cellKey){
      if($map[$cellKey] == ""){
	  $sc = score_case($map, $me,$him,$cellKey,$depth);
	  if( $sc > $betterScore ){
	    $betterCell = $cellKey;
	    $betterScore= $sc;
	  }
      }
    }
    return array($betterCell,$betterScore);
}

//count free cases
$freeCells=0;
for($x = 0; $x < 3; $x++){
  for($y = 0; $y < 3; $y++){
    if($message['board'][$x."-".$y] == ""){
      $freeCells ++;
    }elseif($message['board'][$x."-".$y] !== $message['you']){
      $hisSymbol=$message['board'][$x."-".$y];
    }
  }
}

if(!isset($hisSymbol)){
  if($message['you'] == 'X'){
    $hisSymbol='O';
  }else{
    $hisSymbol="X";
  }
}


echo '{"play":"'.choose_better_cell($message['board'],$message['you'], $hisSymbol,9 - $freeCells)[0].'"}';
