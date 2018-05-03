<?php

  require_once('DataBase.php');
  class User
  {
    private $id;
    private $username;
    private $hashPass;
    private $email;

    public function __construct() {
      $this->id	= -1;
      $this->username =	"";
      $this->email =	"";
      $this->hashPass =	"";
    }

    public function setUsername($newUsername)
    {
      $this->username = $newUsername;
    }

    public function getUsername()
    {
      return $this->username;
    }

    public function	setPassword($newPass)	{
      $newHashedPass = password_hash($newPass,PASSWORD_BCRYPT);
      $this->hashPass	=	$newHashedPass;
    }

    private function isValidPassword($password)
    {
      $conn = DataBase::connect();
      $stmt	= $conn->prepare('SELECT password FROM	Users WHERE	password=:password');
      $result =	$stmt->execute(['password' => $password]);
      if ($result === true && $stmt->rowCount()	> 0) {
        return false;

      }else{
        return true;
      }

    }


    public function setEmail($newEmail)
    {
      if($this->isValidEmail($newEmail)){
        $this->email = $newEmail;
      }else{
        echo "Isnieje już konto powiązane z tym adresem email";
      }

    }

    private function isValidEmail($email)
    {
      $conn = DataBase::connect();
      $stmt	= $conn->prepare('SELECT email FROM Users WHERE email=:email');
      $result =	$stmt->execute(['email'	=>	$email]);
      if ($result === true && $stmt->rowCount()	> 0) {
        return false;

      }else{
         return true;
      }

    }

    public function getEmail()
    {
      return $this->email;
    }

    public function getId()
    {
      return $this->id;
    }

    public function getPassword()
    {
        if($this->hashPass){
          return $this->hashPass;

        }else{
          return false;
        }
    }

    public function	saveToDB(PDO $conn)
    {
      if ($this->id	== -1) {
        $stmt =	$conn->prepare('INSERT	INTO Users(username, email,	hash_pass) VALUES (:username, :email, :pass)' );
        $result	= $stmt->execute([
          'username' => $this->username,
          'email' => $this->email,
          'pass' =>	$this->hashPass]);

        if ($result	!==	false)	{
          $this->id	= $conn->lastInsertId();
          return true;
        }
      }else	{
        $stmt =	$conn->prepare('UPDATE	Users SET username=:username, email=:email, hash_pass=:hash_pass WHERE id=:id');
        $result	= $stmt->execute([
          'username' => $this->username,
          'email' => $this->email,
          'hash_pass' => $this->hashPass,
          'id' => $this->id,
          ]);

        if ($result	===	true) {
          return true;
        }
      }
      return false;
    }


    static public function loadUserById(PDO	$conn, $id)
    {
      $stmt	= $conn->prepare('SELECT * FROM Users	WHERE id=:id');
      $result =	$stmt->execute(['id' =>	$id]);
      if ($result === true && $stmt->rowCount()	> 0) {
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        $loadedUser	= new User();
        $loadedUser->id	= $row['id'];
        $loadedUser->username =	$row['username'];
        $loadedUser->hashPass =	$row['hash_pass'];
        $loadedUser->email = $row['email'];
        return $loadedUser;
      }
      return null;
    }

    static public function loadAllUsers(PDO	$conn)	{
      $ret = [];
      $sql = "SELECT * FROM	Users";
      $result =	$conn->query($sql);
      if($result !== false && $result->rowCount() != 0)	{
        foreach ($result as	$row)	{
          $loadedUser =	new	User();
          $loadedUser->id = $row['id'];
          $loadedUser->username	= $row['username'];
          $loadedUser->hashPass	= $row['hash_pass'];
          $loadedUser->email = $row['email'];
          $ret[] = $loadedUser;
        }
      }
      return $ret;
    }

    public function	delete(PDO	$conn)
    {
      if ($this->id	!=	-1)	{
        $stmt =	$conn->prepare('DELETE	FROM Users WHERE id=:id');
        $result	= $stmt->execute(['id' => $this->id]);
        if ($result ===	true) {
          $this->id	= -1;
          return true;
        }
        return false;
      }
      return true;
    }

    static public function loadUserByEmail(PDO $conn, $email)
    {
      $stmt	= $conn->prepare('SELECT * FROM Users WHERE email=:email');
      $result = $stmt->execute(['email' => $email]);
      if ($result === true && $stmt->rowCount()	> 0) {
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        $loadedUser	= new User();
        $loadedUser->id	= $row['id'];
        $loadedUser->username =	$row['username'];
        $loadedUser->hashPass =	$row['hash_pass'];
        $loadedUser->email = $row['email'];

        return $loadedUser;
      }
      return null;
    }

    static public function getUserNameByID (PDO $conn , $id)
    {
      $stmt	= $conn->prepare('SELECT *  FROM Users	 WHERE id=:id');
      $result =	$stmt->execute(['id' =>	$id]);
      if ($result === true && $stmt->rowCount()	> 0) {
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        $loadedUser	= new User();
        $loadedUser->id	= $row['id'];
        $loadedUser->username =	$row['username'];
        $loadedUser->hashPass =	$row['hash_pass'];
        $loadedUser->email = $row['email'];
        return $loadedUser->getUsername();
      }
      return null;
    }
  }
