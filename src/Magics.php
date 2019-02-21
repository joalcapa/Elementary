<?php

try {
    $dotenv = Dotenv\Dotenv::create(REAL_PATH);
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

/**
 * Encriptación de datos en modo PASSWORD_BCRYPT.
 *
 * @param  string  $parameter
 * @return  $string
 */
function hashBCrypt($parameter) {
    return password_hash($parameter, PASSWORD_BCRYPT);
}

/**
 * Verificación de dato encriptado.
 *
 * @param  string  $parameter
 * @param  string  $parameterHash
 * @return  boolean
 */
function verifyBCrypt($parameter, $parameterHash) {
    return password_verify($parameter, $parameterHash);
}