<!DOCTYPE html>
<html>
<head><title>Open API online game</title>
<link rel="stylesheet" href="http://www.w3schools.com/lib/w3.css">
<link rel="stylesheet" href="http://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.6.3/css/font-awesome.min.css">
<meta name="viewport" content="width=device-width, initial-scale=1">
</head>	
<body class="w3-light-grey">
<?php
ini_set('display_errors',1); 
 error_reporting(E_ALL); //gives meaningful errors instead of blank page

 $conn = new mysqli("localhost", "nkhx10ho_auto", "u70L-2r+i9", "nkhx10ho_game");
 // Check connection
 if ($conn->connect_error) {
	die("<div class=w3-red>Connection failed: " . $conn->connect_error . "</div>");
 }
 //this prepares the MySQL connection for the header "badges".
?>
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

  <!-- Header -->
  <header class="w3-container" style="padding-top:22px">
    <h5><b><i class="fa fa-dashboard"></i> Robots of kepler-23e (working title)</b></h5>
  </header>

  <div class="w3-row-padding w3-margin-bottom">
    <div class="w3-third">
      <div class="w3-container w3-khaki w3-padding-16">
        <div class="w3-left"><i class="fa fa-map w3-xxxlarge"></i></div>
        <div class="w3-right">
          <h3><?=$conn->query("SELECT * FROM Map")->num_rows?></h3>
        </div>
        <div class="w3-clear"></div>
        <h4>Regions</h4>
      </div>
    </div>
    <div class="w3-third">
      <div class="w3-container w3-blue w3-padding-16">
        <div class="w3-left"><i class="fa fa-android w3-xxxlarge"></i></div>
        <div class="w3-right">
          <h3>0</h3>
        </div>
        <div class="w3-clear"></div>
        <h4>Robots</h4>
      </div>
    </div>
    <div class="w3-third">
      <div class="w3-container w3-teal w3-padding-16">
        <div class="w3-left"><i class="fa fa-share-alt w3-xxxlarge"></i></div>
        <div class="w3-right">
          <h3><?php
			echo $conn->query("SELECT * FROM Map")->field_count ;
			$conn->close();
		  ?></h3>
        </div>
        <div class="w3-clear"></div>
        <h4>Database columns</h4>
      </div>
    </div>
    </div>

  <div class="w3-container w3-section">
    <div class="w3-row-padding" style="margin:0 -16px">
      <div class="w3-third">
        <h5>Welcome</h5>
        <img src="MapExample.png" style="width:100%" alt="Pretend this is an actual game map">
      </div>
      <div class="w3-twothird">
        <h5>Brief Story</h5>
		The premise of this game is that you have found a far-away planet that is rich in resources, but also in harmful radiation.  Because of this, and a non-breathable atmosphere, you send robots to collect resources and explore.  The point of this game is to program those robots. The other point is to be an open-API game that you can play anywhere that can send HTTP requests (the Linux Terminal, your phone, you name it).
      </div>
    </div>
    <div class="w3-row-padding" style="margin:0 -16px">
      <div class="w3-twothird">
        <h5>Robot programming</h5>
The robot is controlled by means of programs you instruct it to run. When you manually move your robot forward, you are actually just telling it to run a small program that just moves it forward one step.
More complicated programs can be accomplished by means of loops. more info to come....
        <h5>Terrain types</h5>
more info to come....
      </div>
      <div class="w3-third">
        <h5>Gameplay</h5>
        <img src="weirdness.png" style="width:100%" alt="Pretend this is an actual game screenshot">
      </div>
    </div>
        <h5>Technical Details</h5>
        <img src="MapExample.png" style="width:100%" alt="Pretend this is an actual game map">
      </div>
      <div class="w3-twothird">
        <h5>SQL Table Structure</h5>
The original query used to create the Map table is:
<pre>
CREATE TABLE IF NOT EXISTS Map (
n BIGINT,
w BIGINT,
groundColor BINARY(3),
item_type MEDIUMINT UNSIGNED,
item_value TEXT(30),
item_color BINARY(3),
PRIMARY KEY (n, w)
</pre>
<br>
add a column for altitude?
        <h5>other</h5>
use openid instead of asking people to make a password? 

more info to come....

      </div>
    </div>
  </div>
  <hr>
  
  <!-- Footer -->
  <footer class="w3-container w3-padding-16 w3-light-grey">
    <h4></h4><!-- name it acknoledgements or something? -->
    <p>Powered by <a href="http://www.w3schools.com/w3css/default.asp" target="_blank">w3.css</a> and <a href="http://x10hosting.com">x10hosting.com</a></p>
  </footer>

  <!-- End page content -->
</div>

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

</body>
</html>