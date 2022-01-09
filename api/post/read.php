<?php
  //Headers
  header('Access-Control-Allow-Origin: *');
  header('Content-Type: application/json');
  header('Access-Control-Allow-Methods: GET');

  include(__DIR__."/../../config/Database.php");
  include(__DIR__."/../../models/Post.php");

  //DB connection
  $database = new Database();
  $db = $database->connect(); // will return connection

  //BLog Post Object
  $post = new Post($db);

  //Blog post query
  $result = $post->read();
  //Get row count
  $num = $result->rowCount();

  if($num> 0 ){
    $arr = array();
    $arr['data'] = array();

    while($row = $result->fetch(PDO::FETCH_ASSOC)){
      extract($row); // assigns $title to $row['title']

      $post_item = array(
        'id' => $id,
        'title' => $title,
        'body' => html_entity_decode($body),
        'author' => $author,
        'category_id' => $category_id,
        'category_name' => $category_name,
        'created_at' => $created_at
      );

      array_push($arr['data'], $post_item);
    }

    // Convert to JSON
    echo json_encode($arr);

  } else{
    echo json_encode( array('message' => 'no posts') );
  }
?>
