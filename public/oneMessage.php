<?php
    session_start();
    require_once("../src/Messages.php");
    require_once("../src/Users.php");

    // pobranie id użytkownika, który jest obecnie zalogowany, jeżeli nie jest zalogowany - odesłanie na stronę logowania
    if(!(isset($_SESSION['userId']))){
        header("Location: signin.php");
    }

    if(isset($_GET['id'])){
        // zmiana statusu wiadomości na przeczytaną
        $message  = Messages::loadOneMessageById(DataBase::connect(), $_GET['id']);
        $message->setIsRead(1);
        $message->saveToDB(DataBase::connect());

        // pobranie nazwy uzytkownika
        $userSend = User::loadUserById(DataBase::connect(), $message->getUserIdSend());
        $userGet = User::loadUserById(DataBase::connect(), $message->getUserIdGet());
        $usernameSend = $userSend->getUsername();
        $usernameGet = $userGet->getUsername();
    }

?>
<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title></title>
    <link rel="stylesheet" href="../src/css/style.css">
</head>
<body>
    <a href="messages.php"> Powrót do wszystkich wiadomości </a><br>
    <hr><br>

    <table>
        <tr>
            <th>Nadawca</th>
            <th>Odbiorca</th>
            <th>Tekst wiadomości:</th>
            <th>Data utworzenia:</th>
        </tr>
        <tr>
            <?php if(isset($_GET['id'])){
                echo "<td>$usernameSend</td>";
                echo "<td>$usernameGet</td>";
                echo "<td>{$message->getText()}</td>";
                echo "<td>{$message->getCreationDate()}</td>";
             }?>
        </tr>
    </table>
</body>
</html>
