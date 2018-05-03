<?php
  require_once ("DataBase.php");

  class Messages
  {
    private $id;
    private $userIdSend;
    private $userIdGet;
    private $creationDate;
    private $text;
    private $isRead = 0;


    public function getId()
    {
      return $this->id;
    }

    public function setUserIdSend($newUserIdSend)
    {
      $this->userIdSend = $newUserIdSend ;
    }

    public function getUserIdSend()
    {
      return $this->userIdSend;
    }

    public function setUserIdGet($newUserIdGet)
    {
      $this->userIdGet = $newUserIdGet ;
    }

    public function getUserIdGet()
    {
      return $this->userIdGet;
    }

    public function setCreationDate($newCreationDate)
    {
      $this->creationDate = $newCreationDate;
    }

    public function getCreationDate()
    {
      return $this->creationDate;
    }

    public function setText($newText)
    {
      $this->text = $newText;
    }

    public function getText()
    {
      return $this->text;
    }

    public function setIsRead($value)
    {
      $this->isRead = $value;
    }

    public function getIsRead()
    {
      return $this->isRead;
    }

    public function __construct()
    {
      $this->id = -1;
      $this->isRead = 0;
      $this->userIdSend = "";
      $this->userIdGet = "";
      $this->creationDate = "";
      $this->text = "";

    }

    static public function loadSendMessagesById(PDO $conn, $userIdSend)
    {

      $ret = [];
      $sql = "SELECT * FROM Messages WHERE userIdSend=:userIdSend ORDER BY id DESC";
      $stmt = $conn->prepare($sql);
      $result = $stmt->execute(['userIdSend' => $userIdSend]);
      if ($result !== false && $stmt->rowCount() != 0 ){
        foreach ($stmt as $row){
          $loadedMessage= new Messages();
          $loadedMessage->id = $row['id'];
          $loadedMessage->userIdSend = $row['userIdSend'];
          $loadedMessage->userIdGet = $row['userIdGet'];
          $loadedMessage->text = $row['text'];
          $loadedMessage->creationDate = $row['creationDate'];
          $ret [] = $loadedMessage;
        }
      }
      return $ret;
    }

    static public function loadGetMessagesById(PDO $conn, $userIdGet)
    {
      $ret = [];
      $sql = "SELECT * FROM Messages WHERE userIdGet=:userIdGet ORDER BY id DESC";
      $stmt = $conn->prepare($sql);
      $result = $stmt->execute(['userIdGet' => $userIdGet]);
      if ($result !== false && $stmt->rowCount() != 0 ){
        foreach ($stmt as $row){
          $loadedMessage= new Messages();
          $loadedMessage->id = $row['id'];
          $loadedMessage->userIdSend = $row['userIdSend'];
          $loadedMessage->userIdGet = $row['userIdGet'];
          $loadedMessage->text = $row['text'];
          $loadedMessage->creationDate = $row['creationDate'];
          $loadedMessage->isRead = $row['isRead'];
          $ret [] = $loadedMessage;
        }
      }
      return $ret;
    }

    public function saveToDB(PDO $conn)
    {
      if ($this->id == -1){
        $stmt = $conn->prepare("INSERT INTO Messages ( userIdSend, userIdGet, text, creationDate, isRead) VALUES ( :userIdSend, :userIdGet, :text, :creationDate, :isRead)");
        $result = $stmt->execute([
          'userIdSend' => $this->userIdSend,
          'userIdGet' => $this->userIdGet,
          'text' => $this->text,
          'creationDate' => $this->creationDate,
          'isRead' => $this->isRead,
        ]);
        if($result !== false){
          $this->id = $conn->lastInsertId();
          return true;
        }

      }else{
        $stmt = $conn->prepare("UPDATE Messages SET userIdSend=:userIdSend, userIdGet=:userIdGet, text=:text, creationDate=:creationDate , isRead=:isRead WHERE id=:id");
        $result = $stmt->execute(
          [
            'id' => $this->id,
            'userIdSend' => $this->userIdSend,
            'userIdGet' => $this->userIdGet,
            'text' => $this->text,
            'creationDate' => $this->creationDate,
            'isRead' => $this->isRead,
          ]);
        if($result === true){
          return true;
        }
      }

      return false;
    }

    static public function loadOneMessageById(PDO $conn, $id){
      $sql = "SELECT * FROM Messages WHERE id=:id ";
      $stmt = $conn->prepare($sql);
      $result = $stmt->execute(['id' => $id]);
      if ($result !== false && $stmt->rowCount() != 0 ) {
        foreach ($stmt as $row) {
          $loadedMessage = new Messages();
          $loadedMessage->id = $row['id'];
          $loadedMessage->userIdSend = $row['userIdSend'];
          $loadedMessage->userIdGet = $row['userIdGet'];
          $loadedMessage->text = $row['text'];
          $loadedMessage->creationDate = $row['creationDate'];
          return $loadedMessage;
        }
      }
    }


  }




