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
        <h6> Currently under construction </h6>
    </div>
	<footer>
		<p><a href="mainpage.php">HOME</a> | <a href="#">ABOUT</a> | <a href="#">CONTACT</a></p>
	</footer>
	</body>
</html>