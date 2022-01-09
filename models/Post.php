<?php
  class Post{
    private $con;
    private $table = 'posts';

    //Post Props
    public $id;
    public $category_id;
    public $category_name;
    public $title;
    public $body;
    public $author;
    public $created_at;

    public function __construct($db){
      $this->con = $db;
    }

    // Read posts
    public function read(){
      $query = 'select
                  c.name as category_name,
                  p.id,
                  p.category_id,
                  p.title,
                  p.body,
                  p.author,
                  p.created_at
                from
                  '.$this->table.' p
                left join
                  categories c on p.category_id = c.id
                order by
                  p.created_at desc;
                ';

      //Statement
      $stmt = $this->con->prepare($query);
      $stmt->execute();

      return $stmt;
    }


    // Read single
    public function readSingle(){
      $query = 'select
                  c.name as category_name,
                  p.id,
                  p.category_id,
                  p.title,
                  p.body,
                  p.author,
                  p.created_at
                from
                  '.$this->table.' p
                left join
                  categories c on p.category_id = c.id
                where
                  p.id = ?;
                ';

      $stmt = $this->con->prepare($query);
      $stmt->bindParam(1, $this->id);
      $stmt->execute();


      $row = $stmt->fetch(PDO::FETCH_ASSOC);
      if(!$row) die('No such data');

      //Setting props
      extract($row);
      $this->title = $title;
      $this->body = html_entity_decode($body);
      $this->category_id = $category_id;
      $this->category_name = $category_name;
      $this->created_at = $created_at;
      $this->author = $author;
    }


    // Post new post
    public function postPost(){
      $query = 'insert into '
                  .$this->table.'(title, body, author, category_id)
                values
                  (:title, :body, :author, :category_id)';

      $stmt = $this->con->prepare($query);

      //Clean data
      $this->title = htmlspecialchars(strip_tags(trim($this->title)));
      $this->body = htmlspecialchars(strip_tags(trim($this->body)));
      $this->author = htmlspecialchars(strip_tags(trim($this->author)));
      $this->category_id = htmlspecialchars(strip_tags(trim($this->category_id)));

      //Bind
      $stmt->bindParam(':title', $this->title);
      $stmt->bindParam(':body', $this->body);
      $stmt->bindParam(':author', $this->author);
      $stmt->bindParam(':category_id', $this->category_id);

      try{
        if($stmt->execute()) return true;
      } catch(PDOException $e){
        echo 'Error is: '.$e."\n";
        return false;
      }
    }


    // Update post
    public function updatePost(){
      $query = 'update '
                  .$this->table.'
                set
                  title = :title,
                  body = :body,
                  author = :author,
                  category_id = :category_id
                where
                  id = :id';

      $stmt = $this->con->prepare($query);

      //Clean data
      $this->title = htmlspecialchars(strip_tags(trim($this->title)));
      $this->body = htmlspecialchars(strip_tags(trim($this->body)));
      $this->author = htmlspecialchars(strip_tags(trim($this->author)));
      $this->category_id = htmlspecialchars(strip_tags(trim($this->category_id)));
      $this->id = htmlspecialchars(strip_tags(trim($this->id)));

      //Bind
      $stmt->bindParam(':title', $this->title);
      $stmt->bindParam(':body', $this->body);
      $stmt->bindParam(':author', $this->author);
      $stmt->bindParam(':category_id', $this->category_id);
      $stmt->bindParam(':id', $this->id);

      try{
        if($stmt->execute()) return true;

      } catch(PDOException $e){
        echo 'Error is: '.$e."\n";
        return false;
      }
    }


    // Delete post
    public function deletePost(){
      $query = 'delete from' . $this->table . ' where id = ?';

      $stmt = $this->con->prepare($query);
      $this->id = htmlspecialchars(strip_tags(trim($this->id)));

      $stmt->bindParam(1, $this->id);

      try{
        if($stmt->execute()) return true;

      } catch(PDOException $e){
        echo 'Error is: '.$e."\n";
        return false;
      }
    }
  }
?>
