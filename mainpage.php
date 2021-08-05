<?php require 'projectconnect.php';
$pstatement = $db->prepare("SELECT * FROM player ORDER BY RAND() LIMIT 1");
	$pstatement->execute();
	$player = $pstatement->fetch();

$mstatement = $db->prepare("SELECT * FROM map ORDER BY RAND() LIMIT 1");
	$mstatement->execute();
	$map = $mstatement->fetch();

$vstatement = $db->prepare("SELECT * FROM matches ORDER BY RAND() LIMIT 1");
	$vstatement->execute();
	$versus = $vstatement->fetch();

?>
<!DOCTYPE html>
<html>
<head>
	<link rel="stylesheet" type="text/css" href="project.css">
	<meta charset="utf-8">
	<title>SCII Player Library</title>
</head>
<body>
	<header>
		<h1>Starcraft II Player Library</h1>
		<div id="login">
			<?php if(isset($_SESSION['user'])):?>
				<p>Welcome <?=$_SESSION['user']?> | <a href="projectlogout.php">Log Out</a></p>
			<?php else:?>
				<p><a href="projectloginpage.php">Log In</a> | <a href="projectnewaccount.php">New Account</a>
			<?php endif?>
		</div>
		<nav>
			<ul>
				<li><a href="projectplayers.php">Players</a></li>
				<li><a href="projectmaps.php">Maps</a></li>
				<li><a href="projecttournaments.php">Tournaments</a></li>
				<li><a href="projectmatches.php">Matches</a></li>
			</ul>
		</nav>
	</header>
	<div>
		<form action="projectsearch.php" method="post" id="searchform">
		    <label for="searchbar">Search:</label><input type="text" name="searchbar"><input type="submit" name="searchbutton" value="search">
        </form> 
		<div id="feature">
			<div id="fplayer">
				<h2>Featured Player</h2>
				<ul>
					<li><a href="projectplayerpage.php?player=<?=$player['ID']?>"><?=$player['Handle']?></a></li>
					<li><?=$player['Name']?></li>
					<li><?=$player['Race']?></li>
				</ul>
			</div>
			<div id="fmap">
				<h2>Featured Map</h2>
				<ul>
					<li><a href="projectmappage.php?map=<?=$map['ID']?>"><?=$map['Name']?></a></li>
					<li><?=$map['Author']?></li>
					<li><?=$map['tileset']?></li>
				</ul>
			</div>
			<div id="fmatch">
				<h2>Featured Match</h2>
				<ul>
					<li><?=$versus['Map']?></li>
					<li><?=$versus['Winner']?></li>
					<li><?=$versus['Loser']?></li>
				</ul>
			</div>
		</div>
	</div>
	<footer>
		<p><a href="mainpage.php">HOME</a> | <a href="#">ABOUT</a> | <a href="#">CONTACT</a></p>
	</footer>
	</body>
</html>