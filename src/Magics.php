<?php

try {
    $dotenv = new Dotenv\Dotenv(REAL_PATH);
    $dotenv->load();
} catch(Exception $exception) {
    echo 'Error: '. $exception;
}

function env($environment, $parameter) {
    $env = getenv($environment);
    if(isset($env))
        return $env;
    return $parameter;
}