<?php require 'projectconnect.php';
$id = FILTER_INPUT(INPUT_GET, 'id', FILTER_SANITIZE_NUMBER_INT);

if(!(isset($_SESSION['user'])) || $_SESSION['power'] < 7)
{
    header("Location: http://localhost:31337/project/projectplayerpage.php?player={$id}");
}
else 
{
    $statement = $db->prepare("SELECT * FROM player WHERE id = :id");
        $statement->bindValue(':id', $id, PDO::PARAM_INT);
        $statement->execute();
        $p = $statement->fetch();
}
?>
<!DOCTYPE html>
<html>
<head>
	<link rel="stylesheet" type="text/css" href="project.css">
	<meta charset="utf-8">
	<title>SCII Player Library</title>
</head>
<body>
    <div id="newplayer">
        <form method="post" action="projectlogin.php" id="editplayerform" enctype="multipart/form-data">
            <legend>Edit Player</legend>
            <?php if(isset($_SESSION['Emessage'])):?>
                <p id="error"><?= $_SESSION['Emessage']?></p>
                <?php unset($_SESSION['Emessage'])?>
            <?php endif?>
            <p>
                <label for="username">Handle</label>
                <input name="username" id="username" type="text" value="<?=$p['Handle']?>">
            </p>
            <p>
                <label for="password">Full Name</label>
                <input name="password" id="pword" type="text" value="<?=$p['Name']?>">
            </p>
            <p>
                <label for="team">Team</label>
                <input name="team" id="team" type="text" value="<?=$p['Team']?>">
            </p>
            <p>
                <label for="race">Race</label>
                <select id="race" name="race" value="<?=$p['Race']?>">
                    <option value="Zerg">Zerg</option>
                    <option value="Terran">Terran</option>
                    <option value="Protoss">Protoss</option>
                </select>
            </p>
            <p>
                <label for="country">Country</label>
                <input name="country" id="country" type="text" value="<?=$p['Country']?>">
            </p>
            <p>
                <label for="age">Age</label>
                <input name="age" id="age" type="text" value="<?=$p['Age']?>">
            </p>
            <p>
                <input type="submit" name="account" value="update"/>
                <input type="hidden" name="id" value="<?=$id?>"/>
            </p>
            <p><a href="projectplayerpage.php?player=<?=$p['ID']?>">Cancel</a></p>
            <?php if(file_exists("img/{$p['Handle']}.png")):?>
                <img src="img/<?=$p['Handle']?>.png" alt="<?=$p['Handle']?>">
                <p><a href="projectimgdelete.php?s=<?=$p['ID']?>">Remove Photo</a></p>
            <?php else:?>
                <label for="image">Image:</label>
                <input type="file" name="image" id="image"/>
                <input type="submit" name="account" value="img"/>
        <?php endif?>
        </form>
    </div>
    <footer>
		<p><a href="mainpage.php">HOME</a> | <a href="#">ABOUT</a> | <a href="#">CONTACT</a></p>
	</footer>
	</body>
</body>
</html>