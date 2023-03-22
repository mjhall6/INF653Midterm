<?php
    // Headers
    header('Access-Control-Allow-Origin: *');
    header('Content-Type:application/json');

    include_once '../../config/Database.php';
    include_once '../../models/Author.php';

    // Instantiate DB & connect

    $database = new Database();
    $db = $database->connect();

    // Instantiate Author object
    $author = new Author($db);

    // Get ID 
    $author->id = isset($_GET['id']) ? $_GET['id'] : die();

    // Get Author
    $author->read_single();

    // Create array
    $author_arr = array(
        'id' => $author->id,
        'author' => $author->author
    );

    //Make JSON
    print_r(json_encode($author_arr));
?>