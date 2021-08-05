<?php require 'projectconnect.php';
    var_dump($_POST);
    if(!(isset($_POST['type'])))
    {
        $_POST['type'] = "";
    }

    if($_POST['type'] == "Post")
    {
        $comm = filter_input(INPUT_POST, "newcomment", FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        if($comm != "")
        {
            $statement = $db->prepare("INSERT INTO playercomment (PlayerID, Comment, writer) VALUES (:id, :comm, :writer)");
            $statement->bindValue(':id', (int)$_POST['playerid'], PDO::PARAM_INT);
            $statement->bindValue(':comm', $comm);
            $statement->bindValue('writer', $_POST['writer']);
            $statement->execute();
        }
        $id = $_POST['playerid'];
        header("Location: http://localhost:31337/project/projectplayerpage.php?player={$id}");
    }
?>