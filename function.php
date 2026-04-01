<?php

function getPosts($pdo)
{
    $sql = "SELECT * FROM `posts`";
    $stmt = $pdo->prepare($sql);
    $stmt->execute();
    $posts = $stmt->fetchAll(PDO::FETCH_ASSOC);
    echo json_encode($posts);
}

function getPost($pdo, $id)
{
    $stmt = $pdo->prepare("SELECT * FROM posts WHERE id = :id");
    $stmt->bindParam(':id', $id);
    $stmt->execute();

    if($stmt->rowCount() === 1){
 $post = $stmt->fetch(PDO::FETCH_ASSOC);
 echo json_encode($post);

    } else {
        http_response_code(404);
        $response = [
            "status" => false,
            "massage" => 'Post not found'
        ];
    echo json_encode($response);
        }
    }

function addPost($pdo, $data)
{
    $sql = "INSERT INTO `posts`(`title`, `body`) VALUES (:title, :body)";
    $stmt = $pdo->prepare($sql);
    $stmt->execute($data);
    http_response_code(201);
    $response = [
        "status" => true,
        "post_id" => $pdo->lastInsertId()
    ];
    echo json_encode($response);

}

function deletePost($pdo, $id) 
{
    $sql = "DELETE FROM posts WHERE id = :id";
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(':id', $id);
    $stmt->execute();
    http_response_code(200);
    $response = [
        'status' => true,
        "mesend" => 'delete!'
    ];
    echo json_encode($response);
}

function updatePost($pdo, $id, $data) {
    $stmt = $pdo -> prepare("UPDATE `posts` SET title = :title, body = :body WHERE `id` = :id");
    $stmt -> execute(['title' => $data['title'], 'body' => $data['body'], 'id' => $id]);
    http_response_code(200);
    $response = [
        'status' => true,
        'message' => 'Modified!'
    ];
    echo json_encode($response);
}