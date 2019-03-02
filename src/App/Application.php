<?php

namespace Joalcapa\Elementary\App;

use Symfony\Component\Console\Application as App;
use Joalcapa\Elementary\Commands\SeedersCommand as SeedersCommand;
use Joalcapa\Elementary\Commands\MigrateCommand as MigrateCommand;
use Joalcapa\Elementary\Commands\CreateModelCommand as CreateModelCommand;
use Joalcapa\Elementary\Commands\CreateSeederCommand as CreateSeederCommand;
use Joalcapa\Elementary\Commands\CreateMigrationCommand as CreateMigrationCommand;
use Joalcapa\Elementary\Commands\CreateControllerCommand as CreateControllerCommand;
use Joalcapa\Elementary\Commands\CreateMiddlewareCommand as CreateMiddlewareCommand;

class Application {

    private $kernels = [];

    /**
     * Definición del directorio real e inicialización del kernel de base de datos.
     *
     * @param  string  $path
     */
    public function __construct($path) {
        define("REAL_PATH", $path);
        require(__DIR__.'\\..\\Magics.php');
    }

    /**
     * Agregado de los kernel necesarios para el funcionamiento de la api Rest.
     *
     * @param  string  $classKernel
     */
    public function addKernelSingleton($classKernel) {

    }

    /**
     * Punto de inicio de la api Rest, proceso de autenticación, busqueda del modelo y generación
     * de la respuesta de la api.
     */
    public function init() {
        $application = new App();
        $application->add(new SeedersCommand());
        $application->add(new MigrateCommand());
        $application->add(new CreateModelCommand());
        $application->add(new CreateSeederCommand());
        $application->add(new CreateMigrationCommand());
        $application->add(new CreateControllerCommand());
        $application->add(new CreateMiddlewareCommand());
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
