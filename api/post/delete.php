<?php
  //Headers
  header('Access-Control-Allow-Origin: *');
  header('Content-Type: application/json');
  header('Access-Control-Allow-Methods: DELETE');
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

  $post->id = $data['id'];

  if($post->deletePost()){
    http_response_code(200);
    echo json_encode(array(
      "Message" => "Post deleted"
    ));
  } else {
    http_response_code(400);
    echo json_encode(array(
      "Message" => "Post could not be deleted"
    ));
  }
?>
