<?php
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

  // Get ID
  $post->id = isset($_GET['id']) ? $_GET['id'] : die('No ID Given');

  $post->readSingle();

  $arr = array(
    'id' => $post->id,
    'title' => $post->title,
    'body' => $post->body,
    'author' => $post->author,
    'category_id' => $post->category_id,
    'category_name' => $post->category_name,
    'created_at' => $post->created_at
  );

  echo json_encode($arr);
?>
