<?php
    session_start();
    require_once(__DIR__.'/../src/Tweet.php');
    require_once(__DIR__.'/../src/DataBase.php');
    require_once(__DIR__.'/../src/Users.php');

    // pobranie id użytkownika, który jest obecnie zalogowany, jeżeli nie jest zalogowany - odesłanie na stronę logowania
    if(!(isset($_SESSION['userId']))){
      header("Location: signin.php");
    }
    $userId = $_SESSION['userId'];


    // zapisanie nowego tweeta do bazy danych
    if($_SERVER['REQUEST_METHOD'] === "POST" && strlen($_POST['text']) > 0 ) {
        $text = $_POST['text'];
        if(strlen($text) <= 140) {
            $date = date('Y-m-d H:i:s');
            $tweet = new Tweets();
            $tweet->setUserId($userId);
            $tweet->setCreationDate($date);
            $tweet->setText($text);
            $tweet->saveToDB(DataBase::connect());
        }else{
            echo "Twój tweet jest za długi!";
        }
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
    <h1> Witaj na Twitterze!</h1>
    <hr>

    <!-- menu użytownika-->
    <ul>
        <li><a href='index.php'>Home</a></li>
        <li><a href='userpage.php'>Twoje Tweety</a></li>
        <li><a href='messages.php'>Twoje wiadomości</a></li>
        <li><a href='logout.php'>Wyloguj </a></li>
        <li><a href='editProfile.php'>Edytuj swój profil </a></li>
    </ul>
    <hr>

    <!-- formularz do publikacji tweeta-->
    <form action="index.php" method="post" role="form">
        <label>Opublikuj nowego twitta<br>
            <textarea rows="4" cols="50" name="text" placeholder="Opublikuj nowego twitta..."></textarea>
        </label><br>
        <input type="submit" value="Opublikuj">
    </form>


    <!-- pobranie i wyświetlenie wszystkich tweetów-->
    <table>
        <tr>
            <th>Nazwa użytkownika</th>
            <th>Treść tweeta</th>
            <th>Data publikacji</th>
            <th>Szczegóły</th>
        </tr>

<?php
    $tweets  = Tweets::loadAllTweets(DataBase::connect());

    foreach($tweets as $tweet){

        // pobranie id użytkownika i id tweeta do przesłania za pomocą metody GET w linkach
        $idTweet = $tweet->getId();
        $userId = $tweet->getUserId();

        // pobranie danych do wyświetlenia nazwy uzytkownika, który opublikował tweet
        $user = User::loadUserById(DataBase::connect(), $userId);
        $userNameOfTweet = $user->getUsername();

        echo "<tr>";
        echo "<td><a href='aboutUser.php?idOtherUser=$userId'>".$userNameOfTweet ."</a></td>";
        echo "<td>".$tweet->getText()."</td>";
        echo "<td>".$tweet->getCreationDate()."</td>";
        echo "<td><a href='tweetdetails.php?id=$idTweet'> przejdź do tweeta</a></td>";
        echo "</tr>";
    }
?>
  </table>

</body>
</html>
