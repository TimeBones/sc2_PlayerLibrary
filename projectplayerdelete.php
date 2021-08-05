<?php require 'projectconnect.php';

$id = FILTER_INPUT(INPUT_GET, 'id', FILTER_SANITIZE_NUMBER_INT);
$confirm = FILTER_INPUT(INPUT_GET, 'confirm', FILTER_VALIDATE_BOOLEAN);

$statement = $db->prepare("SELECT * FROM player WHERE ID = :id");
	$statement->bindValue(':id', $id, PDO::PARAM_INT);
	$statement->execute();
	$p = $statement->fetch();

if(!(isset($_SESSION['user'])) || $_SESSION['power'] < 7)
{
    header("Location: http://localhost:31337/project/projectplayerpage.php?player={$id}");
}
else
{
    if($confirm)
    {   
        echo "1: {$confirm} | {$id}";
        $del = $db->prepare("DELETE FROM player WHERE ID = :id");
            $del->bindValue(':id', $id, PDO::PARAM_INT);
            $del->execute();

        $confirm = false;
        header("Location: http://localhost:31337/project/projectplayers.php");
        echo "     2: {$confirm} | {$id}";
    }
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
    <p>Are you sure you want to delete <?=$p['Handle']?>?</p>
    <p>
        <a href="projectplayerdelete.php?id=<?=$id?>&confirm=true">Delete</a> | <a href="projectplayerpage.php?player=<?=$id?>">Cancel</a>
    </p>
</body>
</html>