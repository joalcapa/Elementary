<?php

namespace Joalcapa\Elementary\Handlers;

class CommandHandler {

    private static $commandHandler;
    private $command;
    private $argCommand;

    private function __construct() {

    }

    /**
     * Inicialización del objeto singleton.
     *
     * @return  object
     */
    public static function getHandler() {
        if (!self::$commandHandler instanceof self)
            self::$commandHandler = new self;
        return self::$commandHandler;
    }

    /**
     * PROHIBICIÓN DEL MÉTODO MÁGICO QUE VIOLA EL PATRON SINGLETON.
     */
    public function __clone() { }

    /**
     * PROHIBICIÓN DEL MÉTODO MÁGICO QUE VIOLA EL PATRON SINGLETON.
     */
    public function __wakeup() { }

    public function makeBody($argv) {

        $parameter = $argv[1];
        if(empty($parameter))
            echo 'killer';

        $pos = 0;
        $len = strlen($parameter);
        while($pos < $len){
            switch(ord($parameter[$pos])) {
                case 45:
                    echo 'guion' . PHP_EOL;
                    break;
                default:
                    echo 'value' . PHP_EOL;
                    break;
            }

            $pos++;
            echo PHP_EOL;
            echo PHP_EOL;
        }
    }
}
