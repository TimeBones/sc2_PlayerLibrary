<?php require 'projectconnect.php';
echo var_dump($_SESSION);
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
        <form method="post" action="projectlogin.php" id="newplayerform">
            <legend>Create Account</legend>
            <?php if(isset($_SESSION['Emessage'])):?>
                <p id="error"><?= $_SESSION['Emessage']?></p>
                <?php unset($_SESSION['Emessage'])?>
            <?php endif?>
            <p>
                <label for="username">Handle</label>
                <input name="username" id="username" type="text" required/>
            </p>
            <p>
                <label for="password">Full Name</label>
                <input name="password" id="pword" type="text" required/>
            </p>
            <p>
                <label for="team">Team</label>
                <input name="team" id="team" type="text"/>
            </p>
            <p>
                <label for="race">Race</label>
                <select id="race" name="race">
                    <option value="Zerg">Zerg</option>
                    <option value="Terran">Terran</option>
                    <option value="Protoss">Protoss</option>
                </select>
            </p>
            <p>
                <label for="country">Country</label>
                <input name="country" id="country" type="text"/>
            </p>
            <p>
                <label for="age">Age</label>
                <input name="age" id="age" type="text"/>
            <p>
                <input type="submit" name="account" value="player"/>
            </p>
        </form>
    </div>
    <footer>
		<p><a href="mainpage.php">HOME</a> | <a href="#">ABOUT</a> | <a href="#">CONTACT</a></p>
	</footer>
	</body>
</body>
</html>