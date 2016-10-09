<?php
session_start();
 ?>
<style>
@import url(//spoqa.github.io/spoqa-han-sans/css/SpoqaHanSans-kr.css);
@import url(//spoqa.github.io/spoqa-han-sans/css/SpoqaHanSans-jp.css);
.sendbutton {
	background:-webkit-gradient( linear, left top, left bottom, color-stop(0.05, #ededed), color-stop(1, #dfdfdf) );
	background:-moz-linear-gradient( center top, #ededed 5%, #dfdfdf 100% );
	filter:progid:DXImageTransform.Microsoft.gradient(startColorstr='#ededed', endColorstr='#dfdfdf');
	background-color:#ededed;
	-webkit-border-top-left-radius:0px;
	-moz-border-radius-topleft:0px;
	border-top-left-radius:0px;
	-webkit-border-top-right-radius:0px;
	-moz-border-radius-topright:0px;
	border-top-right-radius:0px;
	-webkit-border-bottom-right-radius:0px;
	-moz-border-radius-bottomright:0px;
	border-bottom-right-radius:0px;
	-webkit-border-bottom-left-radius:0px;
	-moz-border-radius-bottomleft:0px;
	border-bottom-left-radius:0px;
	text-indent:0px;
	border:1px solid #dcdcdc;
	display:inline-block;
	color:#000000;
  font-size:15px;
  font-family: 'Spoqa Han Sans', arial, sans-serif;
  font-weight: lighter;
	font-style:normal;
	height:40px;
	line-height:40px;
	width:100px;
	text-decoration:none;
	text-align:center;
}
.sendbutton:hover {
	background:-webkit-gradient( linear, left top, left bottom, color-stop(0.05, #dfdfdf), color-stop(1, #ededed) );
	background:-moz-linear-gradient( center top, #dfdfdf 5%, #ededed 100% );
	filter:progid:DXImageTransform.Microsoft.gradient(startColorstr='#dfdfdf', endColorstr='#ededed');
	background-color:#dfdfdf;
}.sendbutton:active {
	position:relative;
	top:1px;
}

table {
    color: #000000;
		font-size:15px;
    font-family: 'Spoqa Han Sans', arial, sans-serif;
    font-weight: lighter;
    border-collapse: collapse;
    width: 100%;
}
td, th {
    border:none;
    text-align: left;
    padding: 5px;
}

tr:nth-child(even) {
    background-color: #f2f2f2;
}
 </style>
 <?php
$configh = fopen('d/config.txt', 'r');
$configh1 = fread($configh, filesize('d/config.txt'));
$config = explode('<config>', $configh1);
$sitename = $config[0];
$siteaddress = $config[1];
$indexperchat = $config[2];
fclose($configh);
?>
<html>
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <title><?php echo $sitename ?></title>
</head>
<body>
  <?php
#First Setup(Permission care)
if(isset($siteaddress) == false)
{
  $configh = fopen('d/config.txt', 'x');
  fwrite($configh, "Chatlast<config>http://localhost<config>10<config>");
  fclose($configh);
  $configh = fopen('d/c.txt', 'x');
  fwrite($configh, "");
  fclose($configh);
}
function chatidmax()
{
	$chath = fopen('d/c.txt', 'r');
	$chath1 = fread($chath, filesize('d/c.txt'));
	$chat = explode('/chatdidlast!#%&/', $chath1);
	fclose($chath);
	$chatidmax=0;
	for($i=0;isset($chat[$i]);$i+=5){
		if($chatidmax < $chat[$i]){
			$chatidmax = $chat[$i];
		}
	}
	return $chatidmax;
}
function setnickname()
{
  echo "<form action='?nr' method='post'><input type='text' name='nickname' maxlength='15' autofocus placeholder='Set your nickname' required style='border: 1px solid #ff5bb0; width:75%; height: 85%'>
  <input type='submit' class='sendbutton' value='Set Nickname' style ='border: 0px; width:23%; height: 85%'>
  </form>";
}
function setnicknamer()
{
  $_SESSION['nicknames'] = $_POST['nickname'];
	echo "<meta http-equiv='refresh' content='0;url=?i=' />";
}
function getinput()
{
  echo "<form action='?ir' method='post'><input type='text' name='chat' maxlength='50' autofocus required style='border: 1px solid #ff5bb0; width:75%; height: 85%'>
  <input type='submit' class='sendbutton' value='send' style ='border: 0px; width:23%; height: 85%'>
  </form>";
}
function getinputr()
{
  $ip=$_SERVER['REMOTE_ADDR'];
  $date = date("d H:i:s");
	$chatidmax = chatidmax();
	$chatidmax++;
	#Important!
	#Avoid errors for data.
	$error = 0;
	if(strpos($_SESSION['nicknames'], '<') !== false) {
		$error++;
		echo "<script>alert('Write failed.')</script>";
		echo "<meta http-equiv='refresh' content='0;url=?i='/>";
	}
	if(strpos($_POST['chat'], '<') !== false) {
		$error++;
		echo "<script>alert('Write failed.')</script>";
		echo "<meta http-equiv='refresh' content='0;url=?i='/>";
	}
	if(strpos($_SESSION['nicknames'], '/chatdidlast!#%&/') !== false) {
		$error++;
		echo "<script>alert('Write failed.')</script>";
		echo "<meta http-equiv='refresh' content='0;url=?i='/>";
	}
	if(strpos($_POST['chat'], '/chatdidlast!#%&/') !== false) {
		$error++;
		echo "<script>alert('Write failed.')</script>";
		echo "<meta http-equiv='refresh' content='0;url=?i='/>";
	}
	if($error == 0) {
					$chath=fopen('d/c.txt', "a+");
					fwrite($chath, $chatidmax.'/chatdidlast!#%&/'.$date.'/chatdidlast!#%&/'.$_SESSION["nicknames"].'/chatdidlast!#%&/'.$ip.'/chatdidlast!#%&/'.$_POST["chat"].'/chatdidlast!#%&/');
					fclose($chath);
					echo "<meta http-equiv='refresh' content='0;url=?i'/>";
	}
}
function getoutput($getoutput, $indexperchat)
{
	#ChatIndex
	$chatidmax = chatidmax();
	$chatidmaxi = $chatidmax - $indexperchat * $getoutput;
	if($chatidmaxi < 0){
 	 $chatmax = $indexperpost;
 	 $chatidmaxi = 1;
  }
	$chath = fopen('d/c.txt', 'r');
	$chath1 = fread($chath, filesize('d/c.txt'));
	$chat = explode('/chatdidlast!#%&/', $chath1);
	fclose($chath);
  if($getoutput == 1){
    $getoutput1 = $getoutput + 1;
    echo "<a href='?o=$getoutput1' class='sendbutton' style='width: 100%;'>more</a>";
  }
  if($getoutput != 1){
    $getoutput1 = $getoutput + 1;
    echo "<a href='?o=$getoutput1' class='sendbutton' style='width: 100%;'>more</a>";
  }
  else {
    #AutoRefresh
      echo "<meta http-equiv='refresh' content='4;url=?o=1'/>";
  }
  echo "<table>";
	for(;$chatidmaxi<=$chatidmax;$chatidmaxi++) {
	for($i=0;isset($chat[$i]);$i+=5) {
	 if($chat[$i] == $chatidmaxi) {
		 $chatid = $chat[$i];
		 $date = $chat[$i+1];
		 $nickname = $chat[$i+2];
		 $ip = $chat[$i+3];
		 $chato = $chat[$i+4];
		 echo "<tr><td>$date <b>$nickname</b>($ip) <b>$chato</b></td></tr>";
	 }
	}
}
echo "</table>";
if($getoutput != 1){
  $getoutput1 = $getoutput + 1;;
      echo  "<a href='?o=1' class='sendbutton' style='width: 100%;'>recently</a>";
    }
  else {
    echo "<script>document.body.scrollTop = document.body.scrollHeight;</script>";
	}
}

#Main
$getinput = $_GET['i'];
$getinputr = $_GET['ir'];
$getoutput = $_GET['o'];
$setnickname = $_GET['n'];
$setnicknamer = $_GET['nr'];
if (isset($getinput)) {
  if (isset($_SESSION['nicknames'])) {
		    getinput();
  }
  else {
		setnickname();
  }
}
if (isset($getinputr)) {
  getinputr();
}
if (is_numeric($getoutput)) {
  if($getoutput < 1){
    $getoutput = 1;
  }
  getoutput($getoutput, $indexperchat);
}
if (isset($setnickname)){
  setnickname();
}
if (isset($setnicknamer)){
  setnicknamer();
}
?>
