<?php

define('_PASSWORD_MIN_LEN', 6);
define('_PASSWORD_MAX_LEN', 20);

// ##############################

function _response($status, $error_message, $line = (-1)){
    header('Content-Type: application/json');
    http_response_code($status);
    $response = ["info"=>$error_message];
    if ($line != (-1)){
        $response = ["info"=>$error_message, "error_line"=>$line];
    }
    echo json_encode($response);
    exit();
}

// ##############################
function _db(){
    $database_user_name = 'amazon'; //  root FUDM40jA45oh6Ra0
    $database_pasword = 'FUDM40jA45oh6Ra0'; // Lonpvet1 172.105.244.156
    $database_connection = 'mysql:host=172.105.244.156; dbname=amazon; charset=utf8mb4';

    $database_options = [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        // PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_OBJ
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
    ];
    return new PDO($database_connection, $database_user_name, $database_pasword, $database_options);
}
