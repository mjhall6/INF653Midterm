<?php
    // Headers
    header('Access-Control-Allow-Origin: *');
    header('Content-Type: application/json');

    include_once '../../config/Database.php';
    include_once '../../models/Quote.php';

    // Instantiate DB & connect

    $database = new Database();
    $db = $database->connect();

    // Instantiate Quote object
    $quote = new Quote($db);

    // Quote query
    $result = $quote->read();

    // Get row count
    $num = $result->rowCount();

    // Check if any quotes
    if($num > 0) {
        // Quote array
        $quote_arr = array();
        //$quote_arr['data'] = array();

        while($row = $result->fetch(PDO::FETCH_ASSOC)) {
            //extract($row);

            //$quote_item = array(
            //  'id' => $id,
            //  'quote' => $quote,
            //   'author' => $author,
            //   'category' => $category
            //);

            $quote_item = array(
                'id' => $row['id'],
                'quote' => html_entity_decode($row['quote']),
                'author' => $row['author_id'],
                'category' => $row['category_id']
            );

            // Push to "data"
            array_push($quote_arr, $quote_item);
        }

        // Turn to JSON & output
        echo json_encode($quote_arr);

    } else {

        //No quotes
        echo json_encode(
            array('message' => 'No Quotes Found')
        );

    }
?>