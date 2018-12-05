<?php

namespace Joalcapa\Elementary\Handlers;

class CommandHandler {

    private static $commandHandler;
    private $command;
    private $argCommand;

    private function __construct() {
        $this->commandFirts = $this->commandLast = null;
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
        
        $parameter = strtolower($argv[1].' l');
        if(empty($parameter))
            echo 'killer';

        $pos = 0;
        $len = strlen($parameter);
        $value = '';
        while($pos < $len){
            switch(ord($parameter[$pos])) {
                case 45:
                    if($this->commandFirts == null) $this->commandFirts = $value;
                    $value = '';
                    break;
                case 32:
                    if($this->commandLast == null) $this->commandLast = $value;
                    $value = '';
                    break;
                default:
                    $value .= $parameter[$pos];
                    break;
            }

            $pos++;
        }
    }
}
