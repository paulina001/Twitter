<?php
    session_start();
    require_once(__DIR__.'/../src/Tweet.php');
    require_once(__DIR__.'/../src/DataBase.php');
    require_once(__DIR__.'/../src/Comment.php');
    require_once(__DIR__.'/../src/Users.php');

    // pobranie id użytkownika, który jest obecnie zalogowany, jeżeli nie jest zalogowany - odesłanie na stronę logowania
    if(!(isset($_SESSION['userId']))){
        header("Location: signin.php");
    }

    // pobranie id tweeta GET-em w razie przejścia z z poprzedniej strony , POST-em jeżeli został opublikowany komentarz
    if (isset($_POST['id']) && $_SERVER['REQUEST_METHOD'] === "POST") {
        $idTweeta = $_POST['id'];
        $tweet = Tweets::loadTweetById(DataBase::connect(), $idTweeta);

    } elseif (isset($_GET['id']) && $_SERVER['REQUEST_METHOD'] === "GET") {
        $idTweeta = $_GET['id'];
        $tweet = Tweets::loadTweetById(DataBase::connect(), $idTweeta);
    }

    //dodanie komentarza do bazy danych
    if (isset($_POST['text']) && strlen($_POST['text']) > 0) {

        $text = $_POST['text'];
        if(strlen($text) <= 60) {
            $date = date('Y-m-d H:i:s');
            $newComment = new Comment();
            $newComment->setCreationDate($date);
            $newComment->setText($text);
            $newComment->setPostId($idTweeta);
            $newComment->setUserId($_SESSION['userId']);
            $newComment->saveToDB(DataBase::connect());
        }else{
            echo "Twój komentarz jest za długi!<br><br>";
        }
    }

    // pobranie nazwy użytkownika, który utworzył tweeta
    $userWhoTweet = User::loadUserById(DataBase::connect(), $tweet->getUserId());
    $userNameWhoTweet = $userWhoTweet->getUsername();


    // wyświetlenie tabeli z tweetem
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

    <hr>
    <br><br>

    <table >
        <tr>
            <th>Nazwa użytkownika</th>
            <th>Data utworzenia tweeta</th>
            <th>Treść tweeta</th>
        </tr>
        <tr>
            <td><?php echo $userNameWhoTweet ?></td>
            <td><?php echo $tweet->getCreationDate() ?></td>
            <td><?php echo $tweet->getText() ?></td>
        </tr>
    </table><br>

    <!-- formularz do dodawania komentarzy-->
    <form action="tweetdetails.php" role="form" method="post">
        <label>Dodaj komentarz:<br>
            <textarea rows="5" cols="60" name="text" placeholder="Twój komentarz..."></textarea>
        </label><br>
    <!--  przesłanie id wyświetlanego na stronie tweeta metodą POST-->
        <input type="hidden" name="id" value="<?php echo $idTweeta ?>">
        <input type="submit" value="dodaj komentarz">
    </form><br>


<!--  wyświetlanie komentarzy -->
    <h3> Komentarze:</h3>

    <table >
        <tr>
            <th>Nazwa użytkownika</th>
            <th>Komentarz</th>
            <th>Data publikacji</th>
        </tr>

<?php
    // pobranie komentarze z bazy danych
    $comments  = Comment::loadAllCommentByPostId(DataBase::connect(), $idTweeta);

    foreach($comments as $comment){

        // pobranie nazwy użytkownika, który wystawił komentarz
        $userId = $comment->getUserId();
        $username =  User::getUserNameByID(DataBase::connect(), $userId);
        echo "<tr>";
        echo "<td>".$username."</td>";
        echo "<td>".$comment->getText()."</td>";
        echo "<td>".$comment->getCreationDate()."</td>";
        echo "</tr>";
    }
?>
    </table>
</body>
</html>




