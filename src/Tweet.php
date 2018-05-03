<?php
  require_once ("DataBase.php");

  class Tweets
  {
    private $id;
    private $userId;
    private $text;
    private $creationDate;


    public function __construct()
    {
      $this->id = -1;
      $this->userId = "";
      $this->text = "";
      $this->creationDate = "";
    }

    public function getId()
    {
      return $this->id;
    }

    public function setUserId($newUserId)
    {
      $this->userId = $newUserId;
    }

    public function getUserId()
    {
      return $this->userId;
    }

    public function setText($newText)
    {
        $this->text = $newText;
    }

    public function getText()
    {
      return $this->text;
    }

    public function setCreationDate($newCreationDate)
    {
      $this->creationDate = $newCreationDate;
    }

    public function getCreationDate()
    {
      return $this->creationDate;
    }

    static public function loadTweetById(PDO $conn, $id)
    {
      $stmt	= $conn->prepare('SELECT * FROM Tweets WHERE id=:id ');
      $result =	$stmt->execute(['id' =>	$id]);
      if ($result === true && $stmt->rowCount()	> 0) {
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        $loadedTweet = new Tweets();
        $loadedTweet->id = $row['id'];
        $loadedTweet->userId = $row['userId'];
        $loadedTweet->text = $row['text'];
        $loadedTweet->creationDate = $row['creationDate'];
        return	$loadedTweet;
      }
      return	null;
    }

    static public function loadAllTweets(PDO $conn)
    {
      $ret = []; $sql = "SELECT	* FROM Tweets ORDER BY id DESC";
      $result =	$conn->query($sql);
      if ($result !== false	&& $result->rowCount() != 0) {
        foreach	($result as $row) {
          $loadedTweet = new Tweets();
          $loadedTweet->id = $row['id'];
          $loadedTweet->userId = $row['userId'];
          $loadedTweet->text = $row['text'];
          $loadedTweet->creationDate = $row['creationDate'];
          $ret[] = $loadedTweet;
        }
      }
      return $ret;
    }

    static public function loadAllTweetsByUserId(PDO $conn, $userId)
    {
      $ret = []; $sql =	"SELECT	* FROM Tweets WHERE userId=:userId ORDER BY id DESC";
      $stmt	= $conn->prepare($sql);
      $result = $stmt->execute(['userId' =>	$userId]);
      if ($result !== false	&& $stmt->rowCount() !=	0){
        foreach ($stmt as $row){
          $loadedTweet = new Tweets();
          $loadedTweet->id = $row['id'];
          $loadedTweet->userId = $row['userId'];
          $loadedTweet->text = $row['text'];
          $loadedTweet->creationDate = $row['creationDate'];
          $ret[] = $loadedTweet;
        }
      }
      return	$ret;
    }

    public function	saveToDB(PDO $conn)
    {
      if ($this->id	== -1){
        $stmt = $conn->prepare('INSERT	INTO Tweets (userId, text, creationDate) VALUES	(:userId, :text, :creationDate)' );
        $result	= $stmt->execute(['userId' => $this->userId, 'text'	=> $this->text,'creationDate' => $this->creationDate]);
          if($result !== false)	{
            $this->id =	$conn->lastInsertId();
            return true;
          }
      }else	{
        $stmt = $conn->prepare('UPDATE	Tweets	SET	userId=:userId,	text=:text, creationDate=:creationDate WHERE id=:id');
        $result	= $stmt->execute(
          [	'userId'=>$this->userId,
            'text'=>$this->text,
            'creationDate'=> $this->creationDate,
            'id'=>$this->id,
          ]);
        if($result === true)	{
          return true;
        }
      }
      return false;
    }

  }

