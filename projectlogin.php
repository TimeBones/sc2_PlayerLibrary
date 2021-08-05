<?php require 'projectconnect.php';
if(!(isset($_POST['account'])))
{
    $_POST['account'] = "";
}
$username = FILTER_INPUT(INPUT_POST, 'username', FILTER_SANITIZE_SPECIAL_CHARS);
$password = FILTER_INPUT(INPUT_POST, 'password', FILTER_SANITIZE_SPECIAL_CHARS);

switch($_POST['account'])
{
    case "login":
        $statement = $db->prepare("SELECT * FROM users WHERE username = :username AND passwerd = :passwerd");
            $statement->bindValue(':username', $username);
            $statement->bindValue(':passwerd', $password);
            $statement->execute();
            $user = $statement->fetchAll();

        if(count($user) == 1)
        {
            $_SESSION['user'] = $user['0']['username'];
            $_SESSION['power'] = $user['0']['power'];
            header("Location: http://localhost:31337/project/mainpage.php");
        }
        else
        {
            $_SESSION['error'] = true;
            header("Location:  http://localhost:31337/project/projectloginpage.php");
        }
        break;

    case "create":
        $copy = FILTER_INPUT(INPUT_POST, 'passwordtwo', FILTER_SANITIZE_SPECIAL_CHARS);

        $statement = $db->prepare("SELECT * FROM users WHERE username LIKE :username");
            $statement->bindValue(':username', $username);
            $statement->execute();

        if($statement->rowCount() > 0)
        {
            $_SESSION['Emessage'] = "That username is taken, select another one";
            header("Location: http://localhost:31337/project/projectnewaccount.php");
        }
        else
        {
            if($password === $copy)
            {
                if(strlen($username) >= 4 && strlen($password) >= 4)
                {
                    try
                    {
                        $statement = $db->prepare("INSERT INTO users (username, passwerd) VALUES (:username, :passwerd)");
                        $statement->bindValue(':username', $username);
                        $statement->bindValue(':passwerd', $password);
                        $statement->execute();
                    }
                    catch(PDOException $e)
                    {
                        $_SESSION['Emessage'] = "Error creating account, try again";
                        header("Location: http://localhost:31337/project/projectnewaccount.php");
                    }
                    $_SESSION['user'] = $username;
                    $_SESSION['power'] = 1;
                    header("Location: http://localhost:31337/project/mainpage.php");
                }
                else
                {
                    $_SESSION['Emessage'] = "Invalid username or password, at least 4 characters required";                
                    header("Location: http://localhost:31337/project/projectnewaccount.php");
                }
            }
            else
            {
                $_SESSION['Emessage'] = "Passwords do not match";
                header("Location: http://localhost:31337/project/projectnewaccount.php");
            }
        }
        break;

    case "player": // Creating a new player
        $statement = $db->prepare("SELECT * FROM player WHERE Handle LIKE :handle");
            $statement->bindValue(':handle', $username);
            $statement->execute();

        if($statement->rowCount() > 0)
        {
            $_SESSION['Emessage'] = "That handle has already been used"; 
            header("Location: http://localhost:31337/project/projectnewplayer.php");
        }
        else
        {
            $age = FILTER_INPUT(INPUT_POST, 'age', FILTER_SANITIZE_NUMBER_INT);
            $team = FILTER_INPUT(INPUT_POST, 'team', FILTER_SANITIZE_SPECIAL_CHARS);
            $country = FILTER_INPUT(INPUT_POST, 'country', FILTER_SANITIZE_SPECIAL_CHARS);

            if(!(isset($_SESSION['Emessage'])) && strlen($username) < 4)
            {
                $_SESSION['Emessage'] = "Handle must be at least 4 characters";
            }

            if(!(isset($_SESSION['Emessage'])) && strlen($password) < 1)
            {
                $_SESSION['Emessage'] = "Full name is required";
            }

            if(!(isset($_SESSION['Emessage'])) && strlen($country) < 1)
            {
                $_SESSION['Emessage'] = "Country is required";
            }

            if(!(is_numeric($age)) || $age <= 0)
            {
                $_SESSION['error'] = "Invalid age";
            }

            if(isset($_SESSION['Emessage']))
            {
                header("Location: http://localhost:31337/project/projectnewplayer.php");
            }
            else
            {
                try
                {
                    $statement = $db->prepare("INSERT INTO player (Handle, Name, Race, Country, Age, Team) VALUES (:handle, :rname, :race, :country, :age, :team)");
                        $statement->bindValue(':handle', $username);
                        $statement->bindValue(':rname', $password);
                        $statement->bindValue(':race', $_POST['race']); // Selected from a drop down menu.
                        $statement->bindValue(':country', $country);
                        $statement->bindValue(':age', $age);
                        $statement->bindValue(':team', $team);
                        $statement->execute();

                    $player = $db->prepare("SELECT ID FROM player WHERE Handle = :handle");
                        $player->bindValue(':handle', $username);
                        $player->execute();

                    if($player->rowcount() != 1)
                    {        
                        throw new PDOException;
                    }
                    $id = $player->fetch();
                    header("Location: http://localhost:31337/project/projectplayerpage.php?player={$id['ID']}");
                }
                catch(PDOException $ex)
                {
                    $_SESSION['Emessage'] = "Error occured when creating player";
                    header("Location: http://localhost:31337/project/projectnewplayer.php");
                }
            }
        }
        break;

    case "update": // updating player info
        $id = FILTER_INPUT(INPUT_POST, 'id', FILTER_SANITIZE_NUMBER_INT);
        $age = FILTER_INPUT(INPUT_POST, 'age', FILTER_VALIDATE_INT);
        $team = FILTER_INPUT(INPUT_POST, 'team', FILTER_SANITIZE_SPECIAL_CHARS);
        $country = FILTER_INPUT(INPUT_POST, 'country', FILTER_SANITIZE_SPECIAL_CHARS);

        if(!(isset($_SESSION['Emessage'])) && strlen($username) < 4)
        {
            $_SESSION['Emessage'] = "Handle must be at least 4 characters";
        }

        if(!(isset($_SESSION['Emessage'])) && strlen($password) < 2)
        {
            $_SESSION['Emessage'] = "Full name is required";
        }

        if(!(isset($_SESSION['Emessage'])) && strlen($country) < 2)
        {
            $_SESSION['Emessage'] = "Country is required";
        }

        if(!(is_numeric($age)) || $age <= 0)
        {
            $_SESSION['error'] = "Invalid age";
        }

        if(isset($_SESSION['Emessage']))
        {
            header("Location: http://localhost:31337/project/projectplayeredit.php?id={$id}");
        }
        else
        {
            try
            {
                $statement = $db->prepare("UPDATE player SET Name = :rname, Handle = :handle, Race = :race, Country = :country, Team = :team, Age = :age WHERE ID = :id");
                    $statement->bindValue(':rname', $password);
                    $statement->bindValue(':handle', $username);
                    $statement->bindValue(':race', $_POST['race']); // Selected from drop down menu.
                    $statement->bindValue(':country', $country);
                    $statement->bindValue(':team', $team);
                    $statement->bindValue(':age', $age);
                    $statement->bindValue(':id', $id);
                    $statement->execute();
                
                header("Location: http://localhost:31337/project/projectplayerpage.php?player={$id}");
                }
            catch(PDOException $ex)
            {
                $_SESSION['Emessage'] = "Error occured when updating player";
                header("Location: http://localhost:31337/project/projectplayeredit.php?id={$id}");
            }
        }
        break;

    case "img": //adding a picture to a player
        var_dump($_FILES);
        if(!(isset($_FILES['image'])) || $_FILES['image']['name'] == "")
        {
            $_SESSION['Emessage'] = "No image selected";
            header("Location: http://localhost:31337/project/projectplayeredit.php?id={$_POST['id']}"); //POST id sanatized on edit page.
        }
        
        $allowedImg = ['image/jpeg', 'image/png', 'image/jpg'];
        $f = $_FILES['image'];
        
        if($f['error'] === 0)
        {
            if((in_array($f['type'], $allowedImg)))
            {
                $statement = $db->prepare("SELECT * FROM player WHERE ID = :id");
                    $statement->bindValue(':id', $_POST['id'], PDO::PARAM_INT); // POST id sanatized on edit page
                    $statement->execute();
                    $p = $statement->fetch();
        
                move_uploaded_file($f['tmp_name'], "img/{$p['Handle']}.png");
                header("Location: http://localhost:31337/project/projectplayerpage.php?player={$p['ID']}");
            }
            else
            {
                $_SESSION['Emessage'] = "The file type is not allowed";
                header("Location: http://localhost:31337/project/projectplayeredit.php?id={$_POST['id']}");
            }
        }
        else
        {
            $_SESSION['Emessage'] = $f['error'];
            header("Location: http://localhost:31337/project/projectplayeredit.php?id={$_POST['id']}");
        }
        break;

    default:
        header("Location: http://localhost:31337/project/mainpage.php");
}
?>