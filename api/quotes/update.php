<?php
    // Headers
    header('Access-Control-Allow-Origin: *');
    header('Content-Type: application/json');
    header('Access-Control-Allow-Methods: PUT');
    header('Access-Control-Allow-Headers: Access-Control-Allow-Headers, Content-Type, Access-Control-Allow-Methods, Authorization, X-Requested-With');


    include_once '../../config/Database.php';
    include_once '../../models/Quote.php';

    // Instantiate DB & connect

    $database = new Database();
    $db = $database->connect();

    // Instantiate Quote object
    $quote = new Quote($db);

    // Get raw posted data
    $data = json_decode(file_get_contents("php://input"));

    if(!isset($data->id) || !isset($data->quote) || !isset($data->author_id) || !isset($data->category_id)) {
        echo json_encode(
            array('message' => 'Missing Required Parameters')
        );
        exit();
    }

    // Set ID to update

    $quote->id = $data->id;

    $quote->author_id = $data->author_id;
    $quote->quote = $data->quote;
    $quote->category_id = $data->category_id;
    $quote->id = $data->id;

    // Update quote
    if($quote->update()) {
        echo json_encode(
            array('id'=>$quote->id, 'quote'=>$quote->quote, 'author_id'=>$quote->author_id, 'category_id'=>$quote->category_id)
        );
    } else {
        echo json_encode(
            array('message' => 'No Quotes Found')
        );
    }
?>