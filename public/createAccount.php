<?php
  session_start();
  require_once(__DIR__.'/../src/Users.php');
  require_once(__DIR__.'/../src/DataBase.php');

// zapisanie użytkownika do bazy danych
  if($_SERVER['REQUEST_METHOD'] === "POST" && isset($_POST)){
     if( strlen($_POST['username']) > 0  && strlen($_POST['email']) > 0 && isset($_POST['password']) > 0){
         $username = $_POST['username'];
         $email = $_POST['email'];
         $password = $_POST['password'];


         $user = new User;
         $user->setUsername($username);
         $user->setEmail($email);
         $user->setPassword($password);
         $user->saveToDB(DataBase::connect());


         header("Location: index.php");
         $_SESSION['userId'] = $user->getId();


    }else{
       echo "Nie wszystkie pola zostały uzupełnione";
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
</head>
<body>

<!--  formularz do rejestracji-->
<form action="createAccount.php" method="post" role="form">
  <h3>Zarejestruj się </h3>
  <label>Nazwa użytkownika:<br>
    <input type="text" name="username" placeholder="nazwa użytkownika...">
  </label><br>
  <label>Email:<br>
    <input type="email" name="email" placeholder="email...">
  </label><br>
  <label>Hasło:<br>
    <input type="password" name="password" placeholder="hasło...">
  </label><br>

  <input type="submit" value="zarejestruj się">
</form>


</body>
</html>



