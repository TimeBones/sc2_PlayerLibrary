<?php require 'projectconnect.php';
$look = FILTER_INPUT(INPUT_POST, "searchbar", FILTER_SANITIZE_STRING);
$search = "%" . $look . "%";

$mapquery = "SELECT * FROM map WHERE lower(Author) LIKE :search
                                  OR lower(Name) LIKE :search
                                  OR lower(tileset) LIKE :search";
    $mapstatement = $db->prepare($mapquery);
	$mapstatement->bindValue('search', strtolower($search));
	$mapstatement->execute();
    $mresults = $mapstatement->fetchAll();
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
        <div id="searchresults">
            <div id="mapresults">
                <?php if(count($mresults) > 0):?>
                    <p>All Map results</p>
                    <table>
                        <?php foreach($mresults as $mr):?>
                        <tr>
                            <td><a href="projectmappage.php?map=<?=$mr['ID']?>"><?=$mr['Name']?></a></td>
                            <td><?=$mr['Author']?></td>
                            <td><?=$mr['tileset']?></td>
                        </tr>
                        <?php endforeach?>
                    </table>
                    <p><a href="projectsearchplayers.php?search=<?=$look?>">All player results</a></p>
                <?php else:?>
                    <p>There are no map results</p>
                <?php endif?>
            </div>
        </div>
    </div>
    <footer>
		<p><a href="mainpage.php">HOME</a> | <a href="#">ABOUT</a> | <a href="#">CONTACT</a></p>
	</footer>
</body>
</html>