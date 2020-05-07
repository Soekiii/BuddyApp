<?php
include_once(__DIR__ . "/classes/Forum.php");

if (!empty($_POST)) {

    // new like
    $like = new Forum();
    $like->setUserID($_POST['userID']);
    $like->setCommentID($_POST['commentID']);

    // save()
    $like->saveLike();

    //succes teruggeven
    $response = [
        'status' => 'success',
        'body' => htmlspecialchars($like->getCommentID()),
        'message' => 'Comment liked'
    ];

    header('Content-Type: application/json');
    echo json_encode($response); // { 'status'  :  'Succes  }
}
