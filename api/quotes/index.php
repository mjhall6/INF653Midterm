<?php

// Headers
header('Acces-Control-Allow-Origin: * ');
header('Content-Type: application/json');
$method = $_SERVER["REQUEST_METHOD"];

// If OPTION request

if($method === 'OPTIONS'){
    header('Access-Control-Allow-Methods: GET, POST, PUT, DELETE');
    header('Access-Control-Allow-Headers: Origin, Accept, Content-Type, X-Requested-With');
    exit();
}

// if GET Request
if($method === "GET"){

    if(isset($_GET['id'])){
        include_once('read_single.php');
    } else {
        include_once('read.php');
    }

} else if($method === "PUT"){
    include_once('update.php');

} else if($method === "DELETE"){
    include_once('delete.php');

} else if($method === "POST"){
    include_once('create.php');

} else {
    echo("Incorrect Method beimg used. It must be either GET, PUT, DELETE, or POST.");
}
