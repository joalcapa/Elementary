<?php

namespace Joalcapa\Elementary\App;

require('C:/xampp/htdocs/gauler/vendor/joalcapa/elementary/src/Handlers/CommandHandler.php');


class Application {

    private $kernels = [];

    /**
     * Definición del directorio real e inicialización del kernel de base de datos.
     *
     * @param  string  $path
     */
    public function __construct() {

    }

    /**
     * Agregado de los kernel necesarios para el funcionamiento de la api Rest.
     *
     * @param  string  $classKernel
     */
    public function addKernelSingleton($classKernel) {

    }

    /**
     * Proceso de enviado de la respuesta de la api Rest.
     */
    public function sendResponse() {

    }

    /**
     * Punto de inicio de la api Rest, proceso de autenticación, busqueda del modelo y generación
     * de la respuesta de la api.
     */
    public function init($argv) {
        \Joalcapa\Elementary\Handlers\CommandHandler::getHandler()->makeBody($argv);
    }

    /**
     * Preparación del objeto response http, cuyo objetivo es el envío de la respuesta de la api Rest.
     *
     * @param  array  $data
     */
    public function makeResponse($data) {

    }
}
