<?php require 'projectconnect.php';

if(!(isset($_SESSION['user'])) || $_SESSION['power'] < 7)
{
    header("Location: http://localhost:31337/project/projectplayers.php");
}
else
{
    $id = FILTER_INPUT(INPUT_GET, 's', FILTER_SANITIZE_NUMBER_INT);
    $statement = $db->prepare("SELECT * FROM player WHERE ID = :id");
        $statement->bindValue(':id', $id, PDO::PARAM_INT);
        $statement->execute();
        $p = $statement->fetch();

    try
    {
        rename("img/{$p['Handle']}.png", "img/del{$p['Handle']}.png");
        header("Location: http://localhost:31337/project/projectplayerpage.php?player={$p['ID']}");
    }
    catch(PDOException $e)
    {
        $_SESSION['Emessage'] = "Error removing image";
        header("Location: http://localhost:31337/project/projectplayeredit.php?id={$p['ID']}");
    }
}
?>