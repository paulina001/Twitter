<?php
    require_once(__DIR__.'/../src/Users.php');
    session_start();

// sprawdzenie użytkownika w bazie danych
    if(isset($_POST) && $_SERVER['REQUEST_METHOD'] === "POST"){
        if(strlen($_POST['email']) > 0 && strlen($_POST['password'])) {
            $email = $_POST['email'];
            $password = $_POST['password'];

            $loadedUser = User::loadUserByEmail(DataBase::connect(), $email);

            if ($loadedUser !== null) {
                if (password_verify($password, $loadedUser->getPassword())) {
                    header('Location: index.php');
                    $_SESSION['userId'] = $loadedUser->getId();

                } else {
                    echo "Nie poprawny email lub hasło!";
                }

            }else{
                echo "Nie poprawny email lub hasło!";
            }
        } else {
            echo "Nie wszystkie pola zostały wypełnione !";
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

    <!--formularz do logowania -->
    <form action="signin.php" method="post" role="form">
        <h3>Zaloguj się </h3>
        <label>Adres email:<br>
            <input type="email" name="email" placeholder="email użytkownika...">
        </label><br>
        <label>Hasło:<br>
            <input type="password" name="password" placeholder="hasło...">
        </label><br>
        <input type="submit" value="zaloguj się">
    </form>

    <a href="createAccount.php"> Nie masz jeszcze konta? Zarejestruj się!</a>

</body>
</html>
