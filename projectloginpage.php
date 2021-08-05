<?php require 'projectconnect.php';

if(!isset($_SESSION['error']))
{
    $_SESSION['error'] = false;
}
$error = $_SESSION['error'];
$_SESSION['error'] = false;

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
    <din id="logindiv">
        <form action="projectlogin.php" method="post" id="loginform">
            <legend>Log In</legend>
            <?php if($error == true): ?>
            <p id="error">Log in attempt failed</p>
            <?php endif?>
            <p>
                <label for="username">Username</label>
                <input name="username" id="username" type="text"/>
            </p>
            <p>
                <label for="password">Password</label>
                <input name="password" id="pword" type="password"/>
            </p>
            <p>
                <input type="submit" name="account" value="login"/>
            </p>
        </form>
        <a href="projectnewaccount.php">Create new account</a>
    </div>
    <footer>
		<p><a href="mainpage.php">HOME</a> | <a href="#">ABOUT</a> | <a href="#">CONTACT</a></p>
	</footer>
</body>
</html>