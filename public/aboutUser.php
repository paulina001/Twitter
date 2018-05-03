<?php
    session_start();
    require_once(__DIR__.'/../src/Tweet.php');
    require_once(__DIR__.'/../src/DataBase.php');
    require_once(__DIR__.'/../src/Messages.php');
    require_once(__DIR__.'/../src/Users.php');

    // pobranie id użytkownika, który jest obecnie zalogowany, jeżeli nie jest zalogowany - odesłanie na stronę logowania
    if(!(isset($_SESSION['userId']))){
        header("Location: signin.php");
    }

    // pobranie id użytkownika za pomocą GET, jeżeli została wysłana prywatna wiadomość - za pomocą POST
    if (isset($_POST['idOtherUser']) && $_SERVER['REQUEST_METHOD'] === "POST" && strlen($_POST['idOtherUser']) > 0) {
        $idOtherUser = $_POST['idOtherUser'];

    } elseif (isset($_GET['idOtherUser']) && $_SERVER['REQUEST_METHOD'] === "GET" && strlen($_GET['idOtherUser']) > 0) {
        $idOtherUser = $_GET['idOtherUser'];
    }


    // zapisanie wysłanej wiadomości do bazy danych
    if($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['text']) ){

        if($idOtherUser === $_SESSION['userId'] && strlen($_POST['text']) > 0){
            echo "Widomość nie została wysłana, nie można wysyłać wiadomości do siebie! <br>";

        }elseif(strlen($_POST['text']) > 0 && strlen($_POST['text']) < 300){
            $text = $_POST['text'];
            $date = date('Y-m-d H:i:s');
            $message  = new Messages();
            $message->setUserIdSend($_SESSION['userId']);
            $message->setUserIdGet($idOtherUser);
            $message->setCreationDate($date);
            $message->setText($text);
            $message->saveToDB(DataBase::connect());

            echo "Wiadomość została wysłana <br><br>";

        }else{
            echo  "Nie wszystkie pola zostały wypełnione lub wiadomość jest zbyt długa! <br><br>";
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
    <a href='index.php'>Powrót do strony głównej</a><br><br>
    <hr>
<?php if(isset($idOtherUser)) {?>
    <!-- formularz do wysyłania wiadomości-->
    <form action="aboutUser.php" role="form" method="post">
        <h3>Wyślij prywatną wiadomość:</h3>
        <label>Tekst wiadomości:<br>
            <textarea name="text" rows="5" cols="60" placeholder="Twoja wiadomość..."></textarea>
        </label><br>
        <input type="hidden" name="idOtherUser" value="<?php echo $idOtherUser ?>">
        <input type="submit" value="Wyślij">
    </form>

<?php }?>
<!--pobranie i wyświetlenie wszystkich tweetów użytkownika-->
<h3>Wszystkie Twitty użytkownika :</h3>

    <table>
        <tr>
            <th>Numer Id Tweeta</th>
            <th>Data utworzenia tweeta</th>
            <th>Treść tweeta</th>
        </tr>

<?php
    if(isset($idOtherUser)){

        $tweets  = Tweets::loadAllTweetsByUserId(DataBase::connect(),$idOtherUser );
            foreach($tweets as $tweet){

            // pobranie nazwy uzytkownika
            $user = User::loadUserById(DataBase::connect(), $tweet->getUserId());
            $userName= $user->getUsername();

            echo "<tr>";
            echo "<td>".$userName."</td>";
            echo "<td>".$tweet->getCreationDate()."</td>";
            echo "<td>".$tweet->getText()."</td>";
            echo "</tr>";
        }
    }

?>
    </table>
</body>
</html>








