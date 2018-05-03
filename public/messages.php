<?php
    session_start();
    require_once("../src/Messages.php");
    require_once("../src/Users.php");
    require_once("../src/DataBase.php");

    if(!(isset($_SESSION['userId']))){
        header("Location: signin.php");

    }else{
        $id = $_SESSION['userId'];
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
    <a href="index.php">Powrót do strony głównej</a>

    <!--pobranie i wyświetlenie otrzymanych wiadomości-->
    <h3>Wiadomości otrzymane:</h3>
    <table>
        <tr>
            <th>Otrzymana od:</th>
            <th>Tekst wiadomości:</th>
            <th>Data utworzenia:</th>
        </tr>

<?php
     $messagesGet  = Messages::loadGetMessagesById(DataBase::connect(), $id);

     foreach($messagesGet as $message){

          $user = User::loadUserById(DataBase::connect(), $message->getUserIdSend());
          $userName = $user->getUsername();

         // sprawdzenie czy wiadomość została odczytana
         $class = $message->getIsRead() == false ?  'bold' : 'normal';
         $messageId = $message->getId();
         $textOfMessage = substr($message->getText(), 0, 30);

          echo "<tr>";
          echo "<td>".$userName."</td>";
          echo "<td><a class='{$class}' href='oneMessage.php?id=$messageId' >".$textOfMessage."</a></td>";
          echo "<td>".$message->getCreationDate()."</td>";
          echo "</tr>";
  }
?>
    </table>


    <!-- pobranie i wyświetlenie wiadomości wysłanych -->
    <h3>Wiadomości wysłane:</h3>
    <table>
        <tr>
            <th>Wysłana do:</th>
            <th>Tekst wiadomości:</th>
            <th>Data utworzenia:</th>
        </tr>

<?php
        $messagesSend  = Messages::loadSendMessagesById(DataBase::connect(), $id);

    foreach($messagesSend as $message){
        // pobranie nazwy użytkownika
        $user = User::loadUserById(DataBase::connect(), $message->getUserIdGet());
        $userIdWhoGetMessage = $user->getUsername();
        $messageIdSend = $message->getId();
        $textOfMessage = substr($message->getText(), 0, 30);


        echo "<tr>";
        echo "<td>".$userIdWhoGetMessage."</td>";
        echo "<td><a href='oneMessage.php?id=$messageIdSend' >".$textOfMessage."</td>";
        echo "<td>".$message->getCreationDate()."</td>";
        echo "</tr>";
    }
?>
  </table>
</body>
</html>
