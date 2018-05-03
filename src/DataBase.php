
<?php

  class DataBase
  {
    static $username = 'root';
    static $password = 'coderslab';
    static $hostname = '127.0.0.1';
    static $database = 'twitter';
    static $conn = null;

    static public function setUsername($newUsername)
    {
      self::$username = $newUsername;
    }

    static public function setPassword($newPassword)
    {
      self::$password = $newPassword;
    }

    static public function setHostname($newHostname)
    {
      self::$hostname = $newHostname;
    }

    static public function setDatabase($newDatabase)
    {
      self::$database= $newDatabase;
    }

    static public function connect()
    {
      try{
        $dataSourceName = 'mysql:host='.self::$hostname.';dbname='.self::$database;
        self::$conn = new PDO($dataSourceName, self::$username,self::$password);
        self::$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
       // echo "Connected successfully";

        return self::$conn;

      }catch(PDOException  $e){
        echo "Connection failed: " . $e->getMessage();
      }

    }
  }


