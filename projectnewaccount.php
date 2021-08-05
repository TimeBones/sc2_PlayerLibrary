<?php require 'projectconnect.php';


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
    <din id="newaccountdiv">
        <form action="projectlogin.php" method="post" id="loginform">
            <legend>Create Account</legend>
            <?php if(isset($_SESSION['Emessage'])):?>
            <p id="error"><?= $_SESSION['Emessage']?></p>
            <?php unset($_SESSION['Emessage'])?>
            <?php endif?>
            <p>
                <label for="email">Email</label>
                <input name="email" id="email" type="email" required/>
            <p>
                <label for="username">Username</label>
                <input name="username" id="username" type="text" required/>
            </p>
            <p>
                <label for="password">Password</label>
                <input name="password" id="pword" type="password" required/>
            </p>
            <p>
                <label for="passwordtwo">Re-enter Password</label>
                <input name="passwordtwo" id="pword" type="password" required/>
            </p>
            <p>
                <input type="submit" name="account" value="create"/>
            </p>
        </form>
    </div>
    <a href="projectloginpage.php">Log Into An Existing Account</a>
    <footer>
		<p><a href="mainpage.php">HOME</a> | <a href="#">ABOUT</a> | <a href="#">CONTACT</a></p>
	</footer>
</body>
</html>