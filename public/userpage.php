<?php
  session_start();
  require_once(__DIR__.'/../src/Tweet.php');
  require_once(__DIR__.'/../src/DataBase.php');

    // pobranie id użytkownika, który jest obecnie zalogowany, jeżeli nie jest zalogowany - odesłanie na stronę logowania
    if(!(isset($_SESSION['userId']))){
        header("Location: signin.php");
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

    <a href='index.php'>Powrót do strony głównej</a>

    <!--wyświetlenie wszystkich tweetow użytkownika-->
    <hr>
    <h3>Twoje tweety</h3>

    <table>
        <tr>
            <th>Data utworzenia tweeta</th>
            <th>Treść tweeta</th>
        </tr>
<?php
    $tweets  = Tweets::loadAllTweetsByUserId(DataBase::connect(), $_SESSION['userId']);
    foreach($tweets as $tweet){
    echo "<tr>";
    echo "<td>".$tweet->getCreationDate()."</td>";
    echo "<td>".$tweet->getText()."</td>";
    echo "</tr>";
  }
?>
    </table>

</body>
</html>

