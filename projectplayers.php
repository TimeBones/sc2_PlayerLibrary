<?php require 'projectconnect.php';
// would you actually need to sanatize this GET?
$Gsort = FILTER_INPUT(INPUT_GET, 'sort', FILTER_SANITIZE_FULL_SPECIAL_CHARS);

if(!(isset($_SESSION['user'])))
{
	$Gsort = "";
}

switch($Gsort)
{	
	case 'name':
		$query = "SELECT * FROM player ORDER BY Name";
		$sort = "name";
		break;
	case 'country':
		$query = "SELECT * FROM player ORDER BY Country";
		$sort = "country";
		break;
	case 'team':
		$query = "SELECT * FROM player ORDER BY Team";
		$sort = "team";
		break;
	default:
		$query = "SELECT * FROM player ORDER BY Handle";
		$sort = "handle";	
}

$statement = $db->prepare($query);
	$statement->execute();
	$Players = $statement->fetchAll();

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
		<?php if(isset($_SESSION['user'])):?>
			<div id="playertop">
				<p>Sort by: <a href="projectplayers.php">Handle</a> | 
							<a href="projectplayers.php?sort=name">Name</a> | 
							<a href="projectplayers.php?sort=country">Country</a> | 
							<a href="projectplayers.php?sort=team">Team</a>
				</p>
				<?php if($_SESSION['power'] >= 7):?>
				<p><a href="projectnewplayer.php">New Player</a></p>
				<?php endif?>
			</div>
		<?php endif?>
		<p>All players sorted by <?=$sort?>.</p>
		<?php foreach($Players as $p): ?>
			<div id="Player">
				<h2><a href="projectplayerpage.php?player=<?=$p['ID']?>"><?=$p['Handle']?></a></h2>				
				<p>Player Info:</p>
				<ul>
					<li>Name: <?=$p['Name']?></li>
					<li>Team: <?=$p['Team']?></li>
					<li>Race: <?=$p['Race']?></li>
					<li>Country: <?=$p['Country']?></li>
					<li>Age: <?=$p['Age']?></li>
				</ul>
			</div>
		<?php endforeach?>
	</div>
	<footer>
		<p><a href="mainpage.php">HOME</a> | <a href="#">ABOUT</a> | <a href="#">CONTACT</a></p>
	</footer>
	</body>
</html>