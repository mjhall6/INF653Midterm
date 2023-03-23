<?php
    // Headers
    header('Access-Control-Allow-Origin: *');
    header('Content-Type: application/json');

    include_once '../../config/Database.php';
    include_once '../../models/Category.php';

    // Instantiate DB & connect

    $database = new Database();
    $db = $database->connect();

    // Instantiate Category object
    $category = new Category($db);

    // Category query
    $result = $category->read();

    // Get row count
    $num = $result->rowCount();

    // Check if any categories
    if($num > 0) {
        // Quote array
        $category_arr = array();
        //$category_arr['data'] = array();

        while($row = $result->fetch(PDO::FETCH_ASSOC)) {
            //extract($row);

            //$category_item = array(
            //    'id' => $id,
            //    'category' => $category
            //);
            $category_item = array(
                'id' => $row['id'],
                'category' => $row['category']
            );

            // Push to "data"
            array_push($category_arr, $category_item);
        }

        // Turn to JSON & output
        echo json_encode($category_arr);

    } else {

        //No categories
        echo json_encode(
            array('message' => 'No Category Found')
        );

    }
?>    