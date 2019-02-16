<?php

namespace Joalcapa\Elementary\Commands;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

class MigrateCommand extends Command
{
    protected $commandName = 'migrate';
    protected $commandDescription = "Run migrations";

    protected $commandArgumentName = "name";
    protected $commandArgumentDescription = "Who do you want to migration?";

    protected $commandArgumentAttributes = "attr"; // should be specified like "app:greet John --cap"
    protected $commandArgumentAttributesDescription = 'If set, it will greet in uppercase letters';

    protected function configure()
    {
        $this
            ->setName($this->commandName)
            ->setDescription($this->commandDescription)
            ->addArgument(
                $this->commandArgumentName,
                InputArgument::OPTIONAL,
                $this->commandArgumentDescription
            )
            ->addArgument(
                $this->commandArgumentAttributes,
                InputArgument::OPTIONAL,
                $this->commandArgumentAttributesDescription
            )
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $nameModel = $input->getArgument($this->commandArgumentName);
        $attributes = $input->getArgument($this->commandArgumentAttributes);

        if(empty($nameModel)) {

            $route = REAL_PATH . "/database/migrations";
            $directory = opendir($route);

            while ($file = readdir($directory))
                if (!is_dir($file))
                {
                    require(REAL_PATH . "\\Database\\Migrations\\".$file);
                    $modelMigrate = preg_replace('/[0-9]+/', '', $file);
                    $modelMigrate = str_replace('.php', '', $modelMigrate);
                    $date = intval(preg_replace('/[^0-9]+/', '', $file), 10);

                    $modelMigration = "Gauler\\Database\\Migrations\\".$modelMigrate;
                    $migrate = new $modelMigration();

                    $modelMigrate = str_replace('Migration', '', $modelMigrate);
                    $migrate->up($date, $modelMigrate);

                    $output->writeln('successfully created the table whith the name ' . strtolower($modelMigrate) . ' in the bbdd');
                }
        } else {

        }

    }
}