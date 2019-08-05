<html>
<head>
<title>Stream All TV - App by Allstreaming.xyz</title>
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
<script>
var expanded = false;

function showCheckboxes() {
  var checkboxes = document.getElementById("checkboxes");
  if (!expanded) {
    checkboxes.style.display = "block";
    expanded = true;
  } else {
    checkboxes.style.display = "none";
    expanded = false;
  }
}
</script>
<style>

body{
	margin:auto;
	text-align:center;
	float:center;
}

.center{
    margin: 0 auto;
    max-width: 1024px;
}

#channel{
	border: 1px solid black;
	background-color: lightgrey;
	margin:0.5%;
	width:30%;
	float:left;
}

#img{
	width:100%;
	float:center;
	margin:auto;
}

#name{

	color: black;
	float:center;
	margin:auto;
}

#nation{
	width:25%;
}

/* The container */
.container {
  display: block;
  position: relative;
  padding-left: 20px;
  cursor: pointer;
  font-size: 18px;
  -webkit-user-select: none;
  -moz-user-select: none;
  -ms-user-select: none;
  user-select: none;
}

/* Hide the browser's default checkbox */
.container input {
  position: absolute;
  opacity: 0;
  cursor: pointer;
  height: 0;
  width: 0;
}

/* Create a custom checkbox */
.checkmark {
  position: absolute;
  top: 1%;
  left: 0;
  height: 20px;
  width: 20px;
  background-color: #eee;
}

/* On mouse-over, add a grey background color */
.container:hover input ~ .checkmark {
  background-color: #ccc;
}

/* When the checkbox is checked, add a blue background */
.container input:checked ~ .checkmark {
  background-color: #2196F3;
}

/* Create the checkmark/indicator (hidden when not checked) */
.checkmark:after {
  content: "";
  position: absolute;
  display: none;
}

/* Show the checkmark when checked */
.container input:checked ~ .checkmark:after {
  display: block;
}

/* Style the checkmark/indicator */
.container .checkmark:after {
  left: 9px;
  top: 5px;
  width: 5px;
  height: 10px;
  border: solid white;
  border-width: 0 3px 3px 0;
  -webkit-transform: rotate(45deg);
  -ms-transform: rotate(45deg);
  transform: rotate(45deg);
}

.multiselect {
  margin:0.5% auto;
}

.selectBox {
  position: relative;
}

.selectBox select {
  width: 100%;
  font-weight: bold;
}

.overSelect {
  position: absolute;
  left: 0;
  right: 0;
  top: 0;
  bottom: 0;
}

#checkboxes {
  display: none;
  border: 1px lightgrey solid;
}

#checkboxes label {
  display: block;
}


</style>
</head>
</html>
<?php header('Content-type: application/json');
			header("Access-Control-Allow-Origin: *"); 
//array nazioni
$nations=array("Mix","All","Albania","Arabic","Belgium","Brasil","Canada","Ex-Yu","France","Germany","Italy","Netherland","Poland","Portugal","Russia","Scandinavian","Spain","Sweden","Switzerland","Turkey","Uk","Usa","Ukraine");
//echo form
echo $form='<form method="post" action="index.php"><div class="multiselect"><div class="selectBox" onclick="showCheckboxes()"><select><option>Seleziona le nazioni</option></select><div class="overSelect"></div></div><div id="checkboxes">';
//ciclo creazione option
foreach( $nations as $nation){ 
	if($nation=="Uk" || $nation=="Usa") $nation = "Uk-Usa";
	$label.='<label class="container"><img width="25px" height="25px" src="img/channels/'.$nation.'/default.png">'.$nation.'<input name="nations[]" type="checkbox" value="'.strtolower($nation).'"><span class="checkmark"></span></label>';
}
echo $label.='</div></div><input type="submit" value="Cerca" /></form>';

$nations = isset($_POST['nations']) ? $_POST['nations'] : array();

if (!count($nations)) echo 'Errore! Devi selezionare almeno una nazione!';
else {
	echo '<p>Ecco i canali delle nazioni da te selezionate:</p>';
	foreach($nations as $nation) {
		if($nation!="all"){
			$nation=ucfirst($nation);
			echo '<div class="center w3-row"><p>'.$nation."</p>";
			channels($nation).'</div>';
		}else{
			$allNations=array("Albania","Arabic","Belgium","Brasil","Canada","Ex-Yu","France","Germany","Italy","Netherland","Poland","Portugal","Russia","Scandinavian","Spain","Sweden","Switzerland","Turkey","Uk","Usa","Ukraine");
			foreach($allNations as $nation){
				$nation=ucfirst($nation);
				echo '<div class="center w3-row"><p>'.$nation."</p>";
				channels($nation).'</div>';
			}
		}
	}
}

function channels($nation){
	$nation=ucfirst($nation);
	if($nation=="Uk" || $nation=="Usa") $nation = "Uk-Usa";
	if($nation=="Ex-yu") $nation = "Ex-Yu";
	foreach (glob('m3u/'.$nation.'/channels/*.m3u') as $channel) {
		channel($channel,$nation);
	}
}

function channel($channel,$nation){
	$path_parts = pathinfo($channel);
	$file_name = $path_parts['filename'];
	$dir = $path_parts['dirname'];
	$file = $path_parts['basename'];
	$file_link = $dir."/".$file;
	
	echo '<div id="channel" class="w3-card-4 w3-display-container"><a href="'.$file_link.'"><img id="nation" class="w3-display-topleft" src="img/channels/'.$nation.'/default.png"><img id="img" src="img/channels/default.png" alt=""><div class="w3-container w3-center"><p id="name">'.$file_name.'</p></div></a></div>';
	
}

function debug_to_console( $data ) {
    $output = $data;
    if ( is_array( $output ) )
        $output = implode( ',', $output);
    echo "<script>console.log( 'Debug Objects: " . $output . "' );</script>";
}

?>
