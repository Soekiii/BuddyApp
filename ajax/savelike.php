<?php 
    session_start();
    include_once(__DIR__ . "/../classes/Like.php");
    if(!empty($_POST)){

       // new like
       $like = new Like();
       $like->setUserId($_SESSION['user_id']);
       $like->setCommentId($_POST['commentId']);

       // save()
       $like->save();

       //succes teruggeven
       $response = [
           'status' => 'succes',
           'body' => htmlspecialchars($like->getCommentId()),
           'message' => 'Like saved'
       ];

        header('Content-Type: application/json');
        echo json_encode($response); // { 'status'  :  'Succes  }
    }