<?php

  require_once ('DataBase.php');
  class Comment
  {
    private $id;
    private $userId;
    private $postId;
    private $creationDate;
    private $text;


    public function getId()
    {
      return $this->id ;
    }

    public function setUserId($newUserId)
    {
      $this->userId = $newUserId;
    }

    public function getUserId()
    {
      return $this->userId;
    }

    public function setPostId($newPostId)
    {
      $this->postId = $newPostId;
    }

    public function getPostId()
    {
      return $this->postId;
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

    public function __construct()
    {
      $this->id = -1;
      $this->userId = "";
      $this->postId = "";
      $this->creationDate = "";
      $this->text = "";
    }

    static public function loadCommentById(PDO $conn, $id)
    {
      $stmt = $conn->prepare('SELECT * FROM Comments WHERE id=:id');
      $result = $stmt->execute(['id' => $id]);
      if($result === true && $stmt->rowCount() > 0 ){
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        $loadedComment = new Comment();
        $loadedComment->id = $row['id'];
        $loadedComment->userId = $row['userId'];
        $loadedComment->postId = $row['postId'];
        $loadedComment->creationDate = $row['creationDate'];
        $loadedComment->text = $row['text'];
        return $loadedComment;
      }
      return null;
    }

    static public function loadAllCommentByPostId(PDO $conn, $postId)
    {
      $ret = [];
      $sql = "SELECT * FROM Comment WHERE postId=:postId ORDER BY id DESC";
      $stmt = $conn->prepare($sql);
      $result = $stmt->execute(['postId' => $postId]);
      if ($result !== false && $stmt->rowCount() != 0 ){
        foreach ($stmt as $row){
          $loadedComment = new Comment();
          $loadedComment->id = $row['id'];
          $loadedComment->postId = $row['postId'];
          $loadedComment->userId = $row['userId'];
          $loadedComment->text = $row['text'];
          $loadedComment->creationDate = $row['creationDate'];
          $ret [] = $loadedComment;
        }
      }
      return $ret;
    }

    public function saveToDB(PDO $conn)
    {
      if ($this->id == -1){
        $stmt = $conn->prepare("INSERT INTO Comment (userId, postId, text, creationDate) VALUE (:userId, :postId, :text, :creationDate)");
        $result = $stmt->execute([
          'userId' => $this->userId,
          'postId' => $this->postId,
          'text' => $this->text,
          'creationDate' => $this->creationDate
        ]);
        if($result !== false){
          $this->id = $conn->lastInsertId();
          return true;
        }

      }else{
        $stmt = $conn->prepare("UPDATE Tweets SET UserId=:userId, postId=:postId, text=:text, creationDate=:creationDate WHERE id=:id");
        $result = $stmt->execute(
          [
            'userId' => $this->userId,
            'postId' => $this->postId,
            'text' => $this->text,
            'creationDate' => $this->creationDate,
          ]);
        if($result === true){
          return true;
        }
      }

      return false;
    }

  }

