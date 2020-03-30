<?php

 session_start();
 $_SESSION['use_only_cookies']=0;
 $_SESSION['use_cookies']=0;
 $_SESSION['use_trans_sid']=1;
  
 if(!isset($_SESSION['login_user'])){
header("location: index.php");
}

class Location
{
  protected $column, $row;
 
  function __construct($column, $row){
    $this->column = $column;
    $this->row = $row;
  }
  function create_neighbor($direction){
    $dx = 0; $dy = 0;
    switch ($direction){
      case 0: case 'left':  $dx = -1; break;
      case 1: case 'right': $dx = +1; break;
      case 2: case 'up':    $dy = -1; break;
      case 3: case 'down':  $dy = +1; break;
    }
    return new Location($this->column + $dx, $this->row + $dy);
  }
  function equals($that){
    return $this->column == $that->column && $this->row == $that->row;
  }
  function is_inside_rectangle($left, $top, $right, $bottom){
    return $left <= $this->column && $this->column <= $right
        && $top <= $this->row && $this->row <= $bottom;
  }
  function is_nearest_neighbor($that){
    $s = abs($this->column - $that->column) + abs($this->row - $that->row);
    return $s == 1;
  }
}
 
class Tile
{
  protected $index;
  protected $content;
  protected $target_location;
  protected $current_location;
 
  function __construct($index, $content, $row, $column){
    $this->index = $index;
    $this->content = $content;
    $this->target_location = new Location($row, $column);
    $this->current_location = $this->target_location;
  }
  function get_content(){
    return $this->content;
  }
  function get_index(){
    return $this->index;
  }
  function get_location(){
    return $this->current_location;
  }
  function is_completed(){
    return $this->current_location->equals($this->target_location);
  }
  function is_empty(){
    return $this->content == NULL;
  }
  function is_nearest_neighbor($that){
    $a = $this->current_location;
    $b = $that->current_location;
    return $a->is_nearest_neighbor($b);
  }
  function swap_locations($that){
    $a = $this->current_location;
    $b = $that->current_location;
    $this->current_location = $b;
    $that->current_location = $a;
  }
}
 
class Model
{
  protected $N;
  protected $M;
  protected $tiles;
 
  function __construct($N, $M){
    $this->N = $N;
    $this->M = $M;
    $this->tiles[0] = new Tile(0, NULL, $N, $M);
    for ($k = 1; $k < $N * $M; $k++ ){
      $i = 1 + intdiv($k - 1, $M);
      $j = 1 + ($k - 1) % $M;
      $this->tiles[$k] = new Tile($k, (string)$k, $i, $j);
    }
    $number_of_shuffles = 1000;
    $i = 0;
    while ($i < $number_of_shuffles)
      if ($this->move_in_direction(random_int(0, 3)))
        $i++;
  }
  function get_N(){
    return $this->N;
  }
  function get_M(){
    return $this->M;
  }
  function get_tile_by_index($index){
    return $this->tiles[$index];
  }
  function get_tile_at_location($location){
    foreach($this->tiles as $tile)
      if ($location->equals($tile->get_location()))
        return $tile;
    return NULL;
  }
  function is_completed(){
    foreach($this->tiles as $tile)
      if (!$tile->is_completed())
        return FALSE;
    return TRUE;
  }
  function move($tile){
    if ($tile != NULL)
      foreach($this->tiles as $target){
        if ($target->is_empty() && $target->is_nearest_neighbor($tile)){
          $tile->swap_locations($target);
          break;
        }
      }
  }
  function move_in_direction($direction){
    foreach($this->tiles as $tile)
      if ($tile->is_empty())
        break;   
    $location = $tile->get_location()->create_neighbor($direction);
    if ($location->is_inside_rectangle(0, 0, $this->M, $this->N)){
      $tile = $this->get_tile_at_location($location);
      $this->move($tile);
      return TRUE;
    }
    return FALSE;
  }
}
 
class View
{
  protected $model;
 
  function __construct($model){
      $this->model = $model;
  }
  function show(){
    $N = $this->model->get_N();
    $M = $this->model->get_M();
    echo "<form class='grid'>";
    for ($i = 1; $i <= $N; $i++){
      for ($j = 1; $j <= $M; $j++){
        $tile = $this->model->get_tile_at_location(new Location($i, $j));
        $content = $tile->get_content();
        if ($content != NULL)
          echo "<span class='puzzle'>"
          .    "<input type='submit' class='puzzle' name='index'"
          .    "value='$content'>"
          .    "</span>";
        else
          echo "<span class='puzzle'>"
          .    "<input type='text' class='puzzle' disabled>"
          .   " </span>";
    }
      echo "<br>";
    }
    echo "</form>";
    if ($this->model->is_completed()){
      echo "<p class='end-game'>";
      echo "You win!";
      echo "</p>";
    }
  }
}
 
class Controller
{
  protected $model;
  protected $view;
 
  function __construct($model, $view){
    $this->model = $model;
    $this->view = $view;
  }
  function run(){
    if (isset($_GET['index'])){
      $index = $_GET['index'];
      $this->model->move($this->model->get_tile_by_index($index));
    }
    $this->view->show();
  }
}
?>
 
<!DOCTYPE html>
<html lang="en"><meta charset="UTF-8">
<head>
  <title>15 Tiles game</title>
  <style>
    .grid {
      background: #bbada0;
            border-radius: 6px;
           width: 410px;
           height: 400px;
      margin-left:50px;
      box-shadow: -1px 2px 3px 1px #a9a9a9;
      padding: 12px;
    
      float:left;
    }
    .puzzle{ display: inline-block; margin: 0; padding: 0.25ch;width: 97.5px;
      height: 97.5px;
      font-size:25px;
      border-radius: 3px;
            background: rgba(238,228,218,.35);
            font-family: clear sans,helvetica neue,Arial,sans-serif;
            font-size: 18px;}
    span.puzzle{display: inline-block; margin: 0; padding: 0.25ch;width: 97.5px;
      height: 97.5px;
      font-size:25px;
      border-radius: 3px;
            background: rgba(238,228,218,.35);
            font-family: clear sans,helvetica neue,Arial,sans-serif;
            font-size: 18px;}
    .end-game{font-size: 400%; color: red;}
  </style>
  <link rel="stylesheet" href="2048.css">
</head>

<script>
  function start() {
  document.getElementById("start").style.display = "none";
}
</script>
<body>
  <?php
  if ($_SESSION['start1']==1) {
    $_SESSION['start1']=2;
  
  ?>
  <div id="start">
    <div id="text">
        <h2>15 Tiles</h2><br><br>
        <h4>How to play</h4>
        <p>
            15 Tiles is Sliding tile game.
            <br/><br/>
            Click one of the four tiles next to the empty title to slide to it into the empty space.
            <br/>
            Rearrange the tiles until they go from 1 through 15 in left to right order.
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
    <header class="sub">
      <br/>
      <span class="title">
        <strong>
          15 Tiles
        </strong>
      </span>
      <span class="score">
        score :
        <?php 
        $date=time();
        $diff=$date-$_SESSION["starttime"];
        if (!isset($_SESSION['model'])){
          $diff=0;
    }
        echo $diff." Seconds";

  if (file_exists('scores1.txt')) {
          $fn = fopen("scores1.txt","r");
            $result = fgets($fn);
            fclose($fn);
            $str=explode("\t",$result);
            if ($str[0]==$_SESSION['login_user']) {
              $arr = file('scores1.txt');
$data=$_SESSION['login_user']."\t".$diff." Seconds"."\n";
// edit first line
$arr[0] = $data;

// write back to file
file_put_contents('scores1.txt', implode($arr));
            }
            else {
              $fileContents = file('scores1.txt');
              $data=$_SESSION['login_user']."\t".$diff." Seconds"."\n";
              array_unshift($fileContents, $data);
              $newContent = implode($fileContents);
            $fp = fopen('scores1.txt', "w+");   // w+ means create new or replace the old file-content
            fputs($fp, $newContent);
            fclose($fp);
            }
          }
          else
          {
      $data=$_SESSION['login_user']."\t".$diff." Seconds";
      file_put_contents('scores1.txt', $data,FILE_USE_INCLUDE_PATH | FILE_APPEND);
    }

         ?>
      </span>
      <span class="new">
        <a href="home.php">Home Page</a>
      </span>
      <span class="logout">
      <a href="logout.php" class="button7" >Logout</a>
    </span>
    </header>
    <br/>
    <div class="grid1" >
      <p ><?php
    if (!isset($_SESSION['model'])){
      $_SESSION['starttime']= time();
      $width = 4; $height = 4;
      $model = new Model($width, $height);
    }
    else
      $model = unserialize($_SESSION['model']);
    $view = new View($model);
    $controller = new Controller($model, $view);
    $controller->run();
    $_SESSION['model'] = serialize($model);
  ?></p>
    </div>
    <div class="scoreboard1"><h3 >Score board</h3>
      <?php
      $fileoutput=file_get_contents('scores1.txt',FILE_SKIP_EMPTY_LINES);
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


</body>
</html>