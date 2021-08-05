<?php require 'projectconnect.php';
$id = FILTER_INPUT(INPUT_GET, 'player', FILTER_SANITIZE_NUMBER_INT);

$query = "SELECT * FROM player WHERE id = :id";
	$statement = $db->prepare($query);
	$statement->bindValue(':id', $id, PDO::PARAM_INT);
	$statement->execute();
    $p = $statement->fetch();
    
$matchQuery = "SELECT Winner, Loser, Name FROM matches JOIN map ON map.ID = matches.Map WHERE :id IN (Winner, Loser) ORDER BY Date DESC";
	$matchStatement = $db->prepare($matchQuery);
	$matchStatement->bindValue(':id', $id, PDO::PARAM_INT);
	$matchStatement->execute();
	$matches = $matchStatement->fetchAll();
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
        <label for="searchbar">Search:</label><input type="text" name="searchbar">
		<div id="Player">
			<div id="info">
				<h2><a href="projectplayerpage.php?player=<?=$p['ID']?>"><?=$p['Handle']?></a></h2>
				<img src="img/<?=$p['Handle']?>.png" alt="<?=$p['Handle']?>">
				<p>Player Info:</p>
				<ul>
					<li>Name: <?=$p['Name']?></li>
					<li>Team: <?=$p['Team']?></li>
					<li>Race: <?=$p['Race']?></li>
					<li>Country: <?=$p['Country']?></li>
					<li>Age: <?=$p['Age']?></li>
				</ul>
			</div>
            <div id="Matches">
				<p>Full match History</p>
				<table>
					<tr>
						<th>Winner</th>
						<th>Loser</th>
						<th>Map</th>
					</tr>
					<?php foreach($matches as $m): ?>
					<tr>
						<td><?=$m['Winner'] ?></td>
						<td><?=$m['Loser']?></td>
						<td><?=$m['Name']?></p></td>
					</tr><?php endforeach?>
				</table>
			</div>
	    </div>
    </div>
	<footer>
		<p><a href="mainpage.php">HOME</a> | <a href="#">ABOUT</a> | <a href="#">CONTACT</a></p>
	</footer>
</body>
</html>