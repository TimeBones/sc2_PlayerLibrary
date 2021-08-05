<?php require 'projectconnect.php';
$id = FILTER_INPUT(INPUT_GET, 'player', FILTER_SANITIZE_NUMBER_INT);

$statement = $db->prepare("SELECT * FROM player WHERE id = :id");
	$statement->bindValue(':id', $id, PDO::PARAM_INT);
	$statement->execute();
    $p = $statement->fetch();

$commentStatement = $db->prepare("SELECT * FROM playercomment WHERE playerID = :id ORDER BY commenttime DESC");
	$commentStatement->bindValue(':id', $id, PDO::PARAM_INT);
	$commentStatement->execute();
	$comments = $commentStatement->fetchAll();
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
        <div id="Player">
			<div id="info">
				<h2><a href="projectplayerpage.php?player=<?=$p['ID']?>"><?=$p['Handle']?></h2>
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
            <div id="Comments">
				<h2>Comments</h2>				
				<?php foreach($comments as $c): ?>
				<div id=commentsingle>
					<p><?=$c['writer']?> on <?=$c['commenttime']?></p>
					<p><?=$c['comment']?></p>
				</div><?php endforeach?>
				<form action="projectcommentsubmit.php" method="post" id="addcomment">
					<textarea id="newcomment" name="newcomment" placeholder="Add a comment..." maxlength=1000 cols=90 rows=11 style="resize: none"></textarea>
					<p>
						<?php if (isset($_SESSION['user'])):?>
						<input type="submit" name="type" value="Post">
						<input type="hidden" name="playerid" value="<?=$id?>">
						<input type="hidden" name="writer" value="<?=$_SESSION['username']?>">
						<?php else:?>
						<a href="projectloginpage.php">Log in to comment</a>
						<?php endif?>
					</p>
				</form>
			</div>
        </div>
    </div>
	<footer>
		<p><a href="mainpage.php">HOME</a> | <a href="#">ABOUT</a> | <a href="#">CONTACT</a></p>
	</footer>
</body>
</html>