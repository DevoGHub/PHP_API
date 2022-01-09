<?php
  //Headers
  header('Access-Control-Allow-Origin: *');
  header('Content-Type: application/json');
  header('Access-Control-Allow-Methods: POST');
  header('Access-Control-Allow-Headers: Access-Control-Allow-Headers, Content-Type, Access-Control-Allow-Methods, Authorization, X-Requested-With');

  include(__DIR__."/../../config/Database.php");
  include(__DIR__."/../../models/Post.php");

  //DB connection
  $database = new Database();
  $db = $database->connect(); // will return connection

  //BLog Post Object
  $post = new Post($db);

  //Get raw posted data
  $dataObject = new ArrayObject(json_decode(file_get_contents('php://input')));
  $data = $dataObject->getArrayCopy();

  $post->title = isset($data['title']) && trim($data['title']) != '' ? $data['title'] : die('All fields not filled');
  $post->body = isset($data['body']) && trim($data['body']) != '' ? $data['body'] : die('All fields not filled');
  $post->author = isset($data['author']) && trim($data['author']) != '' ? $data['author'] : die('All fields not filled');
  $post->category_id = isset($data['category_id']) && trim($data['category_id']) != '' ? $data['category_id'] : die('All fields not filled');

  if($post->postPost()){
    echo json_encode(
      http_response_code(200);
      array('message' => 'Done!')
    );
  } else{
    http_response_code(400);
    echo json_encode(
      array('message' => 'Error')
    );
  }
?>
