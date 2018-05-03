<?php
    require_once(__DIR__.'/../src/Users.php');
    session_start();

    if(!(isset($_SESSION['userId']))){
        header("Location: signin.php");
    }

    //usunięcie konta
    if($_SERVER['REQUEST_METHOD'] === "POST" && isset($_POST['yes'])){

        $userId = $_SESSION['userId'];
        $user = User::loadUserById(DataBase::connect(), $userId);
        $user->delete(DataBase::connect());
        $_SESSION['userId'] = null;
        header("Location: signin.php");
        echo "Konto zostało usunięte ";
    }


    if($_SERVER['REQUEST_METHOD'] === "POST" && isset($_POST['password']) ){
        $userId = $_SESSION['userId'];
        $user = User::loadUserById(DataBase::connect(), $userId);
        $password = $user->getPassword();
        $passwordFromForm = $_POST['password'];

        // sprawdzenie zgodności hasła i ew. zmiany w bazie danych
        if (password_verify($passwordFromForm, $password)) {

            //zmina nazwy użytkownika
            if(isset($_POST['username']) && strlen($_POST['username']) > 0){
                $newUsername = $_POST['username'];
                $user->setUsername($newUsername);
                $user->saveToDB(DataBase::connect());
                echo "Nazwa użytkownika została zmieniona<br><br>";


            // zmian adresu email
            }elseif(isset($_POST['email']) && strlen($_POST['email']) > 0){
                $newEmail = $_POST['email'];
                $loadedUser = User::loadUserByEmail(DataBase::connect(), $newEmail);

                // sprawdzenie czy adres email nie jest już w naszej bazie danych
                if($loadedUser == null){
                    $user->setEmail($newEmail);
                    $user->saveToDB(DataBase::connect());
                    echo "Adres email został zmieniony <br><br>";

                }else {
                    echo "Podany email istnieje już w naszej bazie danych <br><br>";
                }

            // zmiana hasła
            }elseif(isset($_POST['newPassword']) && isset($_POST['repeatPassword']) && strlen($_POST['newPassword']) > 0 && strlen($_POST['repeatPassword']) > 0){
                $newPassword = $_POST['newPassword'];
                $repeatPassword = $_POST['repeatPassword'];

                if($newPassword === $repeatPassword){
                    $user->setPassword($newPassword);
                    $user->saveToDB(DataBase::connect());
                    echo "Hasło zostało zmienione <br><br>";

                }else {
                    echo "Powtórzone hasło nie jest zgodne z nowym hasłem!<br><br>";
                }

            }
            else{
                echo "Nie wszystkie pola zostały wypełnione!<br><br>";
            }

        }
        else
        {
            echo"Podane hasło jest nieprawidłowe!<br><br>";
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

    <a href="index.php">Powrót do strony głównej</a>
    <hr>
    <ul>
        <li><a href="editProfile.php?name=password">Zmiana hasła</a></li>
        <li><a href="editProfile.php?name=username">Zmiana nazwy użytkownika</a></li>
        <li><a href="editProfile.php?name=email">Zmiana adresu email</a></li>
        <li><a href="editProfile.php?name=delete">Usuń konto</a></li>
    </ul><br>

    <div class="content">
<?php
      if($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['name'])){
            $nameOfChange = $_GET['name'];

            // formularz do zmiany hasła
            if($_GET['name'] ==="password"){ ?>
                <form class="form" action="editProfile.php" method="post">
                    <label> Dotychczasowe hasło:
                        <input type="password" name="password">
                    </label><br>
                    <label> Nowe hasło:
                        <input type="password" name="newPassword">
                    </label><br>
                    <label> Powtórz hasło:
                        <input type="password" name="repeatPassword">
                    </label><br>
                    <input type = "submit" value = "Zapisz" >
                </form>


<!--             formularz do zmiany adresu email-->
            <?php }elseif($_GET['name'] ==="email"){ ?>

                <form class="form" action = "editProfile.php" method="post">
                    <label> Nowy adres email:
                        <input type = "text" name = "email" >
                    </label><br>
                    <label> Hasło:
                        <input type = "password" name = "password" >
                    </label><br>
                    <input type = "submit" value = "Zapisz" >
                </form >

<!--            formularz do zmiany nazwy użytkownika-->
            <?php }elseif($_GET['name'] ==="username"){ ?>

                <form class="form" action="editProfile.php" method="post">
                    <label> Nowa nazwa użytkownika:
                        <input type="text" name="username">
                    </label><br>
                    <label> Hasło:
                        <input type="password" name="password">
                    </label><br>
                    <input type = "submit" value = "Zapisz" >
                </form>

<!--                formularz do usunięcia konta-->
            <?php }elseif($_GET['name'] ==="delete"){ ?>
                <form action="editProfile.php" method="post" role="form">
                    <label>Czy na pewno chcesz usunąć konto?<br>
                        <input type="submit" name="yes" value="Tak">
                        <input type="submit" name="no" value="No">
                    </label>
                </form>
           <?php }
    }
?>
    </div>
</body>
</html>