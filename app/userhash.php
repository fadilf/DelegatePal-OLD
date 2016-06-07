<?php
include "app-functions.php";

$array = [
    "hash" => userhash(),
    "id" => id()
];

echo json_encode($array);