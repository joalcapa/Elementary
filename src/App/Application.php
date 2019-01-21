<?php

namespace Joalcapa\Elementary\App;

use Symfony\Component\Console\Application as App;


require('C:/xampp/htdocs/gauler2/vendor/joalcapa/elementary/src/Commands/CreateModelCommand.php');
require('C:/xampp/htdocs/gauler2/vendor/joalcapa/elementary/src/Commands/CreateMigrationCommand.php');
require('C:/xampp/htdocs/gauler2/vendor/joalcapa/elementary/src/Commands/CreateControllerCommand.php');


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
    public function init() {
        $application = new App();
        $application->add(new \Joalcapa\Elementary\Commands\CreateModelCommand());
        $application->add(new \Joalcapa\Elementary\Commands\CreateMigrationCommand());
        $application->add(new \Joalcapa\Elementary\Commands\CreateControllerCommand());
        $application->run();
    }

    /**
     * Preparación del objeto response http, cuyo objetivo es el envío de la respuesta de la api Rest.
     *
     * @param  array  $data
     */
    public function makeResponse($data) {

    }
}
