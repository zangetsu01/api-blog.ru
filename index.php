

<?php
// http://api.blog.ru/posts.php

header('Content-Type: application/json');
require 'conectdb.php';
require 'function.php';
//die(print_r($_POST));

// die(print_r($_SERVER));

$method = $_SERVER['REQUEST_METHOD'];
$params = explode('/', $_GET['q']);
$type = $params[0];
if (isset($params[1])) {
    $id = $params[1];
}


switch ($method) {
    case 'GET':
        if ($type === 'posts'){
            if (isset($id)){
                //вывод одного поста
                getPost($pdo, $id);
            } else {
                getPosts($pdo);
            }
        }
        break;
    case 'POST':
        if ($type === 'posts'){
            addPost($pdo, $_POST);
        }
        break;
    case 'PATCH':
        if ($type === 'posts'){
            if (isset($id)){
                $data = file_get_contents ('php://input');
                $data = json_decode($data, true); 
            // die($data['title']);
                updatePost($pdo, $id, $data);
            } 
        }
        break;
        case 'DELETE':
            if ($type === 'posts'){
                if (isset($id)){
            deletePost($pdo, $id);
                }
        }
}