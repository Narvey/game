<?php

include_once "query.php";
ini_set('display_errors',1); 
error_reporting(E_ALL & ~E_NOTICE); //gives meaningful errors instead of blank page


//REST API params
$n1 = intval($_GET["n1"]); //North coordinate of the bottom right corner. default: 0
$w1 = intval($_GET["w1"]); //West coordinate of the bottom right corner. default: 0
if (is_null($_GET["n2"])) $n2 = $n1+10;
	else $n2 = intval($_GET["n2"]); //North coordinate of the top left corner. default: n1+10
if (is_null($_GET["w2"])) $w2 = $w1+10;
	else $w2 = intval($_GET["w2"]); //West coordinate of the top left corner. default: w1+10
if (is_null($_GET["format"])) $ext = "htm";
	else $ext = strtolower($_GET["format"]); //might replace this with actual file extension if I can get ErrorDocument and .htaccess working.
if (is_null($_GET["delim"])) $delim = "|";
	else $delim = strtolower($_GET["delim"]);


//more API param handling
if ($n2<$n1)
{
	$temp = $n2;
	$n2 = $n1;
	$n1 = $temp;
}
if ($w2<$w1)
{
	$temp = $w2;
	$w2 = $w1;
	$w1 = $temp;
}
$sql = SQL::getInstance();
$table = $sql->getMapRange($n1,$w1,$n2,$w2);
$mapHeight = $n2 - $n1 + 1; //I'll calculate these here as well for convenience.
$mapWidth = $w2 - $w1 + 1; //I'll calculate these here as well for convenience.

switch($ext) 
{
case "csv":  // if the file extension requested is CSV, do a plain text table with packed data for each tile.
header('Content-type: text/csv');
	for ($y = 0; $y < $mapHeight; $y++)
	{
		for ($x = 0; $x < $mapWidth; $x++)
		{
			$cell = $table[$y][$x];
			$csvData .= $cell->getn();
			$csvData .= $delim;
			$csvData .= $cell->getw();
			$csvData .= $delim;
			$csvData .= $cell->getgroundColor();
			$csvData .= $delim;
			$csvData .= $cell->getterrain();
			if($x < $mapWidth - 1) $csvData .= ","; //don't append comma on the last cell of the line.
		}
		$csvData .= "\r\n";
	}
	die($csvData);
	break;
case "html":
case "htm":
	//TODO: html cases go here
	break;
default: //put imagemagic stuff here later
	die("Images and other formats not supported yet."); 
}


?>


<!DOCTYPE html>
<html>
<head><title>Query Results</title>
<link rel="stylesheet" href="http://www.w3schools.com/lib/w3.css">
<link rel="stylesheet" href="http://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.6.3/css/font-awesome.min.css">
<meta name="viewport" content="width=device-width, initial-scale=1">
</head>
<body class="w3-light-grey">

<!-- Top container -->
<div class="w3-container w3-top w3-black w3-large w3-padding" style="z-index:4">
  <button class="w3-btn w3-hide-large w3-padding-0 w3-hover-text-grey" onclick="w3_open();"><i class="fa fa-bars"></i> &nbsp;Menu</button>
  <span class="w3-right">&nbsp;</span><!-- put ads here maybe? -->
</div>

<!-- Sidenav/menu -->
<nav class="w3-sidenav w3-collapse w3-white w3-animate-left" style="z-index:3;width:300px;" id="mySidenav"><br>
  <div class="w3-container">
    <h5>Dashboard</h5>
  </div>
  <a href="index.php" class="w3-padding"><i class="fa fa-home fa-fw"></i>&nbsp; Home</a>
  <a href="viewMap.php" class="w3-padding"><i class="fa fa-map fa-fw"></i>&nbsp; Map</a>
<!--  <a href="#" class="w3-padding-16 w3-hide-large w3-dark-grey w3-hover-black" onclick="w3_close()" title="close menu"><i class="fa fa-remove fa-fw"></i>&nbsp; Close Menu</a>
  <a href="#" class="w3-padding w3-blue"><i class="fa fa-users fa-fw"></i>&nbsp; Overview</a>
  <a href="#" class="w3-padding"><i class="fa fa-eye fa-fw"></i>&nbsp; Views</a>
  <a href="#" class="w3-padding"><i class="fa fa-users fa-fw"></i>&nbsp; Traffic</a>
  <a href="#" class="w3-padding"><i class="fa fa-bullseye fa-fw"></i>&nbsp; Geo</a>
  <a href="#" class="w3-padding"><i class="fa fa-diamond fa-fw"></i>&nbsp; Orders</a>
  <a href="#" class="w3-padding"><i class="fa fa-bell fa-fw"></i>&nbsp; News</a>
  <a href="#" class="w3-padding"><i class="fa fa-bank fa-fw"></i>&nbsp; General</a>
  <a href="#" class="w3-padding"><i class="fa fa-history fa-fw"></i>&nbsp; History</a>
  <a href="#" class="w3-padding"><i class="fa fa-cog fa-fw"></i>&nbsp; Settings</a>-->
  <br><br>
</nav>


<!-- Overlay effect when opening sidenav on small screens -->
<div class="w3-overlay w3-hide-large w3-animate-opacity" onclick="w3_close()" style="cursor:pointer" title="close side menu" id="myOverlay"></div>
	
<!-- !PAGE CONTENT! -->
<div class="w3-main" style="margin-left:300px;margin-top:43px;">

<div class="w3-card-5">
<?php
//echo '<table class="w3-table">'; 
/*while($row = $result.fetch_row())
{
echo "<TR><TD>N</TD><TD>W</TD><TD>Item?</TD></TR>"; 
echo "<tr style=\"background: tan" . "\"><td>"; 
echo $row[0]; //n
echo "</td><td>";   
echo $row[1]; //w
echo "</td><td>";    
echo "none"; //////////////////CHANGE to dynamic
echo "</TD></tr>";  
}
echo "</table>";    */

?>
</div>
</div>
</div>
</body>
<script>
// Get the Sidenav
var mySidenav = document.getElementById("mySidenav");

// Get the DIV with overlay effect
var overlayBg = document.getElementById("myOverlay");

// Toggle between showing and hiding the sidenav, and add overlay effect
function w3_open() {
    if (mySidenav.style.display === 'block') {
        mySidenav.style.display = 'none';
        overlayBg.style.display = "none";
    } else {
        mySidenav.style.display = 'block';
        overlayBg.style.display = "block";
    }
}

// Close the sidenav with the close button
function w3_close() {
    mySidenav.style.display = "none";
    overlayBg.style.display = "none";
}
</script>

</html>
