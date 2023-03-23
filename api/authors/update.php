<?php
    // Headers
    header('Access-Control-Allow-Origin: *');
    header('Content-Type: application/json');
    header('Access-Control-Allow-Methods: PUT');
    header('Access-Control-Allow-Headers: Access-Control-Allow-Headers, Content-Type, Access-Control-Allow-Methods, Authorization, X-Requested-With');


    include_once '../../config/Database.php';
    include_once '../../models/Auhtor.php';

    // Instantiate DB & connect

    $database = new Database();
    $db = $database->connect();

    // Instantiate Author object
    $author = new Author($db);

    // Get raw posted data
    $data = json_decode(file_get_contents("php://input"));

    if(!isset($data->author)) {
		echo json_encode(
			array('message' => 'Missing Required Parameters')
		);
		exit();
    }

    // Set ID to update

    $author->id = $data->id;

    $author->author = $data->author;


    // Update author
    if($author->update()) {
        echo json_encode(
            array('id'=>$author->id, 'author'=>$author->author)
        );
    } else {
        echo json_encode(
            array('message' => 'No Category Found')
        );
    }
    ?>