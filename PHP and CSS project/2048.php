
<?php /*-----Functions-----*/
session_start();
if(!isset($_SESSION['login_user'])){
header("location: index.php");
}

function html_tile($tileid){
	$string = "";
	$tilevalue = $_GET[$tileid];
	if($tilevalue==0){
		return $string;
	}else{
		if($tilevalue <= 2048){
			$string = '<div class="tile_'.$tilevalue.'"><br/>'.$tilevalue.'</div>';
			return $string;
		}
		else{
			$string = '<div class="tile_max"><br/>'.$tilevalue.'</div>';
			return $string;
		}
	}
}
/* gettiles : returns the GET values of tiles in a get string
(void) -> (String) */
function gettiles(){
	$string = "c11=".$_GET["c11"]."&c12=".$_GET["c12"]."&c13=".$_GET["c13"]."&c14=".$_GET["c14"]."&c21=".$_GET["c21"]."&c22=".$_GET["c22"]."&c23=".$_GET["c23"]."&c24=".$_GET["c24"]."&c31=".$_GET["c31"]."&c32=".$_GET["c32"]."&c33=".$_GET["c33"]."&c34=".$_GET["c34"]."&c41=".$_GET["c41"]."&c42=".$_GET["c42"]."&c43=".$_GET["c43"]."&c44=".$_GET["c44"]."" ;
	return $string;
}
/* line_move : takes four values and return them moved to the right.
(int,int,int,int) -> array(1,2,3,4) */
function line_move($v1,$v2,$v3,$v4){
	if( $v4 == 0 ){
		$v4=$v3;
		$v3=0;
	}
	if( $v3 == 0 ){
		$v3=$v2;
		$v2=0;
	}
	if( $v4 == 0 ){
		$v4=$v3;
		$v3=0;
	}
	if( $v2 == 0 ){
		$v2=$v1;
		$v1=0;
	}
	if( $v3 == 0 ){
		$v3=$v2;
		$v2=0;
	}
	if( $v4 == 0 ){
		$v4=$v3;
		$v3=0;
	}
	//Merge 3 and 4
	if( $v4 == $v3 ){
		$v4 = $v4 * 2 ;
		$v3 = 0 ;
	}
	if( $v3 == 0 ){
		$v3=$v2;
		$v2=0;
	}
	if( $v2 == 0 ){
		$v2=$v1;
		$v1=0;
	}
	//Merge 2 and 3
	if( $v3 == $v2 ){
		$v3 = $v3 * 2 ;
		$v2 = 0 ;
	}
	if( $v2 == 0 ){
		$v2=$v1;
		$v1=0;
	}
	//Merge 1 and 2
	if( $v2 == $v1 ){
		$v2 = $v2 * 2 ;
		$v1 = 0 ;
	}
	$ret = [ 1 => $v1 , 2 => $v2 , 3 => $v3 , 4 => $v4 ] ;
	return $ret ;
}
/* getmoveresult : Return the GET values using the existing ones moved to a set direction.
1 up - 2 right - 3 down - 4 left
This doesn't generate any new tiles.
Keep in mind that doesn't increases the score.
(int) -> (String) */
function getmoveresult($direction){
	$result = "";
	if($direction == 1){
		$a1 = line_move($_GET["c41"],$_GET["c31"],$_GET["c21"],$_GET["c11"]) ;
		$a2 = line_move($_GET["c42"],$_GET["c32"],$_GET["c22"],$_GET["c12"]) ;
		$a3 = line_move($_GET["c43"],$_GET["c33"],$_GET["c23"],$_GET["c13"]) ;
		$a4 = line_move($_GET["c44"],$_GET["c34"],$_GET["c24"],$_GET["c14"]) ;
		$result = "c11=".$a1[4]."&c12=".$a2[4]."&c13=".$a3[4]."&c14=".$a4[4]."&c21=".$a1[3]."&c22=".$a2[3]."&c23=".$a3[3]."&c24=".$a4[3]."&c31=".$a1[2]."&c32=".$a2[2]."&c33=".$a3[2]."&c34=".$a4[2]."&c41=".$a1[1]."&c42=".$a2[1]."&c43=".$a3[1]."&c44=".$a4[1] ;
		return $result ;
	}
	if($direction == 2){
		$a1 = line_move($_GET["c11"],$_GET["c12"],$_GET["c13"],$_GET["c14"]) ;
		$a2 = line_move($_GET["c21"],$_GET["c22"],$_GET["c23"],$_GET["c24"]) ;
		$a3 = line_move($_GET["c31"],$_GET["c32"],$_GET["c33"],$_GET["c34"]) ;
		$a4 = line_move($_GET["c41"],$_GET["c42"],$_GET["c43"],$_GET["c44"]) ;
		$result = "c11=".$a1[1]."&c12=".$a1[2]."&c13=".$a1[3]."&c14=".$a1[4]."&c21=".$a2[1]."&c22=".$a2[2]."&c23=".$a2[3]."&c24=".$a2[4]."&c31=".$a3[1]."&c32=".$a3[2]."&c33=".$a3[3]."&c34=".$a3[4]."&c41=".$a4[1]."&c42=".$a4[2]."&c43=".$a4[3]."&c44=".$a4[4] ;
		return $result ;
	}
	if($direction == 3){
		$a1 = line_move($_GET["c11"],$_GET["c21"],$_GET["c31"],$_GET["c41"]) ;
		$a2 = line_move($_GET["c12"],$_GET["c22"],$_GET["c32"],$_GET["c42"]) ;
		$a3 = line_move($_GET["c13"],$_GET["c23"],$_GET["c33"],$_GET["c43"]) ;
		$a4 = line_move($_GET["c14"],$_GET["c24"],$_GET["c34"],$_GET["c44"]) ;
		$result = "c11=".$a1[1]."&c12=".$a2[1]."&c13=".$a3[1]."&c14=".$a4[1]."&c21=".$a1[2]."&c22=".$a2[2]."&c23=".$a3[2]."&c24=".$a4[2]."&c31=".$a1[3]."&c32=".$a2[3]."&c33=".$a3[3]."&c34=".$a4[3]."&c41=".$a1[4]."&c42=".$a2[4]."&c43=".$a3[4]."&c44=".$a4[4] ;
		return $result ;
	}
	if($direction == 4){
		$a1 = line_move($_GET["c14"],$_GET["c13"],$_GET["c12"],$_GET["c11"]) ;
		$a2 = line_move($_GET["c24"],$_GET["c23"],$_GET["c22"],$_GET["c21"]) ;
		$a3 = line_move($_GET["c34"],$_GET["c33"],$_GET["c32"],$_GET["c31"]) ;
		$a4 = line_move($_GET["c44"],$_GET["c43"],$_GET["c42"],$_GET["c41"]) ;
		$result = "c11=".$a1[4]."&c12=".$a1[3]."&c13=".$a1[2]."&c14=".$a1[1]."&c21=".$a2[4]."&c22=".$a2[3]."&c23=".$a2[2]."&c24=".$a2[1]."&c31=".$a3[4]."&c32=".$a3[3]."&c33=".$a3[2]."&c34=".$a3[1]."&c41=".$a4[4]."&c42=".$a4[3]."&c43=".$a4[2]."&c44=".$a4[1] ;
		return $result ;
	}
	return $result;
}
/* addrandtile : generates a GET url with a new tile at a random location
(void) -> (string)*/
function addrandtile(){
	$test = hasvoid() ;
	while($test){
		$x = rand(1,4) ;
		$y = rand(1,4) ;
		if ($_GET["c".$x.$y] == 0) {
			$newtilevalue = 2 * rand(1,2) ;
			$test = false;
			$returnurl = gentileget($newtilevalue,$x,$y,11)."&".gentileget($newtilevalue,$x,$y,12)."&".gentileget($newtilevalue,$x,$y,13)."&".gentileget($newtilevalue,$x,$y,14)."&" ;
			$returnurl = $returnurl.gentileget($newtilevalue,$x,$y,21)."&".gentileget($newtilevalue,$x,$y,22)."&".gentileget($newtilevalue,$x,$y,23)."&".gentileget($newtilevalue,$x,$y,24)."&" ;
			$returnurl = $returnurl.gentileget($newtilevalue,$x,$y,31)."&".gentileget($newtilevalue,$x,$y,32)."&".gentileget($newtilevalue,$x,$y,33)."&".gentileget($newtilevalue,$x,$y,34)."&" ;
			$returnurl = $returnurl.gentileget($newtilevalue,$x,$y,41)."&".gentileget($newtilevalue,$x,$y,42)."&".gentileget($newtilevalue,$x,$y,43)."&".gentileget($newtilevalue,$x,$y,44) ;
			return $returnurl ;
		}
	}
	return (gettiles());
}
/* gentileget : Usual function for addrandtile() .
(int,int,int,int) -> (string)
*/
function gentileget ($tv,$sx,$sy,$tile_sid) {
	if("c".$sx.$sy == "c".$tile_sid){
				return "c".$tile_sid."=".$tv ;
			} else {
				return "c".$tile_sid."=".$_GET["c".$tile_sid] ;
			}
}
/* canplay (predicate): returns if the user can play using curent GET values
(void) -> (boolean)*/
function canplay(){
	for($for_1=1;$for_1<=4;$for_1++){
		for($for_2=1;$for_2<=4;$for_2++){
			if ($_GET["c".$for_1.$for_2] == 0){
				return true;
			}
		}
	}
	for($for_1=1;$for_1<=4;$for_1++){
		for($for_2=1;$for_2<=3;$for_2++){
			if($_GET["c".$for_1.$for_2] == $_GET["c".$for_1.($for_2 + 1)]){
				return true ;
			}
		}
	}
	for($for_1=1;$for_1<=3;$for_1++){
		for($for_2=1;$for_2<=4;$for_2++){
			if($_GET["c".$for_1.$for_2] == $_GET["c".($for_1 + 1).$for_2]){
				return true ;
			}
		}
	}
	return false;
}
/* randomstart : returns a random GET url to start the game on 10 templates (Cuz i'm lazy...)
(void) -> (String) */
function randomstart(){
	$randomstart = rand(1,10) ;
	if( $randomstart == 1 ){
		return "Location:2048.php?score=0&c11=0&c12=0&c13=0&c14=0&c21=2&c22=0&c23=0&c24=0&c31=0&c32=0&c33=2&c34=0&c41=0&c42=0&c43=0&c44=0" ;
	}
	if( $randomstart == 2 ){
		return "Location:2048.php?score=0&c11=2&c12=0&c13=0&c14=0&c21=0&c22=2&c23=0&c24=0&c31=0&c32=0&c33=0&c34=0&c41=0&c42=0&c43=0&c44=0" ;
	}
	if( $randomstart == 3 ){
		return "Location:2048.php?score=0&c11=0&c12=0&c13=0&c14=0&c21=0&c22=0&c23=0&c24=0&c31=0&c32=0&c33=0&c34=0&c41=0&c42=2&c43=0&c44=4" ;
	}
	if( $randomstart == 4 ){
		return "Location:2048.php?score=0&c11=0&c12=0&c13=0&c14=0&c21=0&c22=2&c23=4&c24=0&c31=0&c32=0&c33=0&c34=0&c41=0&c42=0&c43=0&c44=0" ;
	}
	if( $randomstart == 5 ){
		return "Location:2048.php?score=0&c11=0&c12=0&c13=0&c14=2&c21=0&c22=0&c23=0&c24=0&c31=0&c32=0&c33=4&c34=0&c41=0&c42=0&c43=0&c44=0" ;
	}
	if( $randomstart == 6 ){
		return "Location:2048.php?score=0&c11=0&c12=0&c13=2&c14=0&c21=0&c22=0&c23=2&c24=0&c31=0&c32=0&c33=0&c34=0&c41=0&c42=0&c43=0&c44=0" ;
	}
	if( $randomstart == 7 ){
		return "Location:2048.php?score=0&c11=0&c12=0&c13=0&c14=0&c21=0&c22=0&c23=4&c24=0&c31=0&c32=0&c33=0&c34=0&c41=0&c42=4&c43=0&c44=0" ;
	}
	if( $randomstart == 8 ){
		return "Location:2048.php?score=0&c11=2&c12=0&c13=0&c14=0&c21=0&c22=2&c23=0&c24=4&c31=0&c32=0&c33=0&c34=0&c41=0&c42=0&c43=2&c44=0" ;
	}
	if( $randomstart == 9 ){
		return "Location:2048.php?score=0&c11=0&c12=0&c13=0&c14=2&c21=0&c22=0&c23=0&c24=2&c31=0&c32=2&c33=0&c34=0&c41=0&c42=0&c43=0&c44=0" ;
	}
	if( $randomstart == 10 ){
		return "Location:2048.php?score=0&c11=0&c12=0&c13=0&c14=0&c21=0&c22=0&c23=0&c24=0&c31=0&c32=0&c33=2&c34=2&c41=0&c42=0&c43=0&c44=0" ;
	}
}
/* haswon (predicate): returns if the user won using curent GET values
(void) -> (boolean)*/
function haswon(){
	for($for_1=1;$for_1<=4;$for_1++){
		for($for_2=1;$for_2<=4;$for_2++){
			if ($_GET["c".$for_1.$for_2] >= 2048 ){
				return true;
			}
		}
	}
	return false;
}
/* hasvoid (predicate): returns if the current grid has at least 1 empty space.
(void) -> (boolean)*/
function hasvoid(){
	for($for_1=1;$for_1<=4;$for_1++){
		for($for_2=1;$for_2<=4;$for_2++){
			if ($_GET["c".$for_1.$for_2] == 0){
				return true;
			}
		}
	}
	return false;
}
/* getmovedscore : Get the new score of the moved direction using the current get one.
Uses the direction in parametters.
(integer) -> (integer)*/
function getmovedscore( $direction ){ // #TODO
	if($direction == 1){
		$a1 = lm_score($_GET["c41"],$_GET["c31"],$_GET["c21"],$_GET["c11"]) ;
		$a2 = lm_score($_GET["c42"],$_GET["c32"],$_GET["c22"],$_GET["c12"]) ;
		$a3 = lm_score($_GET["c43"],$_GET["c33"],$_GET["c23"],$_GET["c13"]) ;
		$a4 = lm_score($_GET["c44"],$_GET["c34"],$_GET["c24"],$_GET["c14"]) ;
		return $_GET["score"] + $a1 + $a2 + $a3 + $a4 ;
	}
	if($direction == 2){
		$a1 = lm_score($_GET["c11"],$_GET["c12"],$_GET["c13"],$_GET["c14"]) ;
		$a2 = lm_score($_GET["c21"],$_GET["c22"],$_GET["c23"],$_GET["c24"]) ;
		$a3 = lm_score($_GET["c31"],$_GET["c32"],$_GET["c33"],$_GET["c34"]) ;
		$a4 = lm_score($_GET["c41"],$_GET["c42"],$_GET["c43"],$_GET["c44"]) ;
		return $_GET["score"] + $a1 + $a2 + $a3 + $a4 ;
	}
	if($direction == 3){
		$a1 = lm_score($_GET["c11"],$_GET["c21"],$_GET["c31"],$_GET["c41"]) ;
		$a2 = lm_score($_GET["c12"],$_GET["c22"],$_GET["c32"],$_GET["c42"]) ;
		$a3 = lm_score($_GET["c13"],$_GET["c23"],$_GET["c33"],$_GET["c43"]) ;
		$a4 = lm_score($_GET["c14"],$_GET["c24"],$_GET["c34"],$_GET["c44"]) ;
		return $_GET["score"] + $a1 + $a2 + $a3 + $a4 ;
	}
	if($direction == 4){
		$a1 = lm_score($_GET["c14"],$_GET["c13"],$_GET["c12"],$_GET["c11"]) ;
		$a2 = lm_score($_GET["c24"],$_GET["c23"],$_GET["c22"],$_GET["c21"]) ;
		$a3 = lm_score($_GET["c34"],$_GET["c33"],$_GET["c32"],$_GET["c31"]) ;
		$a4 = lm_score($_GET["c44"],$_GET["c43"],$_GET["c42"],$_GET["c41"]) ;
		return $_GET["score"] + $a1 + $a2 + $a3 + $a4 ;
	}
	return 0;
}
/* lm_score : Get the earned score by moving the 4 tiles in the parametters
(int,int,int,int) -> (integer)*/
function lm_score($v1,$v2,$v3,$v4){
	$newlinescore = 0 ;
	if( $v4 == 0 ){
		$v4=$v3;
		$v3=0;
	}
	if( $v3 == 0 ){
		$v3=$v2;
		$v2=0;
	}
	if( $v4 == 0 ){
		$v4=$v3;
		$v3=0;
	}
	if( $v2 == 0 ){
		$v2=$v1;
		$v1=0;
	}
	if( $v3 == 0 ){
		$v3=$v2;
		$v2=0;
	}
	if( $v4 == 0 ){
		$v4=$v3;
		$v3=0;
	}
	//Merge 3 and 4
	if( $v4 == $v3 ){
		$v4 = $v4 * 2 ;
		$v3 = 0 ;
		$newlinescore = $newlinescore + $v4 ;
	}
	if( $v3 == 0 ){
		$v3=$v2;
		$v2=0;
	}
	if( $v2 == 0 ){
		$v2=$v1;
		$v1=0;
	}
	//Merge 2 and 3
	if( $v3 == $v2 ){
		$v3 = $v3 * 2 ;
		$v2 = 0 ;
		$newlinescore = $newlinescore + $v3 ;
	}
	if( $v2 == 0 ){
		$v2=$v1;
		$v1=0;
	}
	//Merge 1 and 2
	if( $v2 == $v1 ){
		$v2 = $v2 * 2 ;
		$v1 = 0 ;
		$newlinescore = $newlinescore + $v2 ;
	}
	return $newlinescore ;
}



/*-----End of functions-----*/
?>
<?php
/*Redirects the user with the appropriate GET values if needed.*/
if(!isset($_GET["score"])){
	header(randomstart());
	exit();
}
/*Spawns a tile if the user moved*/
if(isset($_GET["move"])){
	header("Location:2048.php?score=".$_GET["score"]."&".addrandtile()) ;
	exit();
}
/*Takes you to the end page if you can't play.*/
if( ! isset($_GET["page"]) || $_GET["page"] == 0){
	if( ! canplay() ) {
		header("Location:2048.php?score=".$_GET["score"]."&page=1") ;
		exit() ;
	}	
}
/*Sets up the id of the page to display in the $page variable*/
if(isset($_GET["page"])){
	$page = $_GET["page"] ;
} else {
	$page = 0 ;
}
?>
<!Doctype html>
<html>
<head>
	
	<meta charset="UTF-8"/>
	<title>
		2048
	</title>
	<link href='http://fonts.googleapis.com/css?family=Roboto:300' rel='stylesheet' type='text/css'>
	<link rel="stylesheet" href="2048.css">
</head>
<script>
	function start() {
  document.getElementById("start").style.display = "none";
}
</script>
<body>
	<?php
	if ($_SESSION['start']==1) {
		$_SESSION['start']=2;
	
	?>
	<div id="start">
		<div id="text">
				<h2>2048</h2><br>
				<h4>How to play</h4>
				<p>
						2048 is a puzzle game that got popular on smartphones devices.
						<br/><br/>
						It consist in merging similar tiles that appears on a grid to form bigger ones.
						<br/>
						Tiles that are going to appear are 2 and 4 , and you can slide them in a direction
						using the Dpad on the right. Each time you move a new tile will appear at a random location.
						<br/>
						You will lose if you can't make any move at all.
						<br/>
						Your score increases each time you merge two tiles together, by the value of the merged tile.
						<br/>
						Your goal is to form a 2048 tile.
						<br/><br/>
						Good luck!
						<br/>
						You will need it...
					</p>
             <button onclick="start()">Start</button>
			</div>
		</div>
		<?php

	}
		?>
	<div class="page">
		<?php
		if($page == 0) {
		//Displays the normal page.
		?>
		<header class="sub">
			<br/>
			<span class="title">
				<strong>
					2048
				</strong>
			</span>
			<span class="new">
				<a href="home.php">Home</a>
			</span>
			<span class="score">
				score :
				<?php echo($_GET["score"]) ; 
				if (file_exists('scores.txt')) {
					$fn = fopen("scores.txt","r");
  					$result = fgets($fn);
  					fclose($fn);
  					$str=explode("\t",$result);
  					if ($str[0]==$_SESSION['login_user']) {
  						/*$fileContents = file('scores.txt');
  						array_shift($fileContents);
  						$data=$_SESSION['login_user']."\t".$_GET["score"];
  						array_unshift($fileContents, $data);
  						$newContent = implode("\n", $fileContents);
						$fp = fopen('scores.txt', "w+");   // w+ means create new or replace the old file-content
						fputs($fp, $newContent);
						fclose($fp);*/
  						$arr = file('scores.txt');
$data=$_SESSION['login_user']."\t".$_GET["score"]."\n";
// edit first line
$arr[0] = $data;

// write back to file
file_put_contents('scores.txt', implode($arr));
  					}
  					else {
  						$fileContents = file('scores.txt');
  						$data=$_SESSION['login_user']."\t".$_GET["score"]."\n";
  						array_unshift($fileContents, $data);
  						$newContent = implode($fileContents);
						$fp = fopen('scores.txt', "w+");   // w+ means create new or replace the old file-content
						fputs($fp, $newContent);
						fclose($fp);
  					}
  				}
  				else
  				{
			$data=$_SESSION['login_user']."\t".$_GET["score"];
			file_put_contents('scores.txt', $data,FILE_USE_INCLUDE_PATH | FILE_APPEND);
		}
			?>
			</span>
			<span class="new">
				<a href="2048.php">New game</a>
			</span>
			<span class="logout">
			<a href="logout.php" class="button7" >Logout</a>
		</span>
		</header>
		<br/>
		<div class="grid">
			<table>
				<tr>
					<th class="g"><?php echo(html_tile("c11")) ;?></th>
					<th class="g"><?php echo(html_tile("c12")) ;?></th>
					<th class="g"><?php echo(html_tile("c13")) ;?></th>
					<th class="g"><?php echo(html_tile("c14")) ;?></th>
				</tr>
				<tr>
					<th class="g"><?php echo(html_tile("c21")) ;?></th>
					<th class="g"><?php echo(html_tile("c22")) ;?></th>
					<th class="g"><?php echo(html_tile("c23")) ;?></th>
					<th class="g"><?php echo(html_tile("c24")) ;?></th>
				</tr>
				<tr>
					<th class="g"><?php echo(html_tile("c31")) ;?></th>
					<th class="g"><?php echo(html_tile("c32")) ;?></th>
					<th class="g"><?php echo(html_tile("c33")) ;?></th>
					<th class="g"><?php echo(html_tile("c34")) ;?></th>
				</tr>
				<tr>
					<th class="g"><?php echo(html_tile("c41")) ;?></th>
					<th class="g"><?php echo(html_tile("c42")) ;?></th>
					<th class="g"><?php echo(html_tile("c43")) ;?></th>
					<th class="g"><?php echo(html_tile("c44")) ;?></th>
				</tr>
			</table>
		</div>
		<div class="dpad">
			<table>
			<tr>
				<th style="width: 53px; height:55px"></th>
				<th class="key"><a href="<?php echo("2048.php?score=".getmovedscore(1)."&move=1&".getmoveresult(1)) ; ?>"><img src="uparrow.png" style="width:36px;height:36px"/></a></th>
				<th></th>
			</tr>
			<tr>
				<th class="key"><a href="<?php echo("2048.php?score=".getmovedscore(4)."&move=1&".getmoveresult(4)) ; ?>"><img src="leftarrow.png" style="width:36px;height:36px"/></a></th>
				<th></th>
				<th class="key"><a href="<?php echo("2048.php?score=".getmovedscore(2)."&move=1&".getmoveresult(2)) ; ?>"><img src="rightarrow.png" style="width:36px;height:36px"/></a></th>
			</tr>
			<tr>
				<th></th>
				<th class="key"><a href="<?php echo("2048.php?score=".getmovedscore(3)."&move=1&".getmoveresult(3)) ; ?>"><img src="downarrow.png" style="width:36px;height:36px"/></a></th>
				<th></th>
			</tr>
			</table>
		</div>
		<div class="scoreboard"><h3 >Score board</h3>
			<?php
			$fileoutput=file_get_contents('scores.txt',FILE_SKIP_EMPTY_LINES);
			$var=explode("\n", $fileoutput);
			 foreach ($var as $line) {
			 	$data=explode("\t", $line);
			 	
			 	$score=$data[0]."\t".$data[1];
			?>
			<p><?php
				
			echo $data[0]."&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;".$data[1]."\n"; ?>
			</p>
		<?php }?>
			
		</div>
		<br/>
		
		<footer class="sub">
			<?php
			//Displays an article if you have a 2048 or higher tile on the grid.
			if(haswon()){
			?>
			<article class="hbox">
				<header>
					<h1>
						Because you won
					</h1>
				</header>
				<div class="article_body">
					<p>
						Hum... It seems like you indeed won the game.
						<br/><br/>
						Congratulations!
						<br/>
						I was not expecting this... But maybe you are better than expected!
						But you achieved nothing. Do you feel happy about it? You shouldn't.
						You lost your time here... But are you going to continue wasting it?
						<br/>
						Thanks for playing anyways!
					</p>
				</div>
				<div class="hidden"><br/></div>
			</article>
			
			<?php
			}
			?>
		</footer>
		
		<?php
		} //end of $page=0
		?>
	</div>
	
</body>

</html>