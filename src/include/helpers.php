<?php


try{
    $pdo = new PDO(
        'mysql:host=db;dbname=world',
        'root',
        'r00tp@sswoRd!', [
        PDO::MYSQL_ATTR_INIT_COMMAND => "set session sql_mode='STRICT_TRANS_TABLES,NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_AUTO_CREATE_USER,NO_ENGINE_SUBSTITUTION';"]);
}
catch (\Throwable | Exception $e){
    die('no connection to db (or dump in progress)');
}

function getFieldName ($template) {
    return FIELD_LIST[strtolower($template)]
        ?? DEFAULT_SORT_FIELD;
}
