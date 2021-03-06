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

    protected $commandArgumentAttributes = "attr";
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
        $nameMigrate = $input->getArgument($this->commandArgumentName);
        $attributes = $input->getArgument($this->commandArgumentAttributes);

        $route = REAL_PATH . "/database/migrations";
        $directory = opendir($route);

        while ($file = readdir($directory))
            if (!is_dir($file))
            {
                $modelMigrate = preg_replace('/[0-9]+/', '', $file);
                $modelMigrate = str_replace('.php', '', $modelMigrate);
                $date = intval(preg_replace('/[^0-9]+/', '', $file), 10);

                if(empty($nameMigrate))
                    $this->migrate($file, $modelMigrate, $date, $output);
                else {
                    if(strtolower($nameMigrate) == strtolower($modelMigrate)) {
                        $this->migrate($file, $modelMigrate, $date, $output);
                        return;
                    }
                }
            }
    }

    public function migrate($file, $modelMigrate, $date, $output) {
        require(REAL_PATH . "\\Database\\Migrations\\" . $file);
        $modelMigration = "Gauler\\Database\\Migrations\\" . $modelMigrate;
        $migrate = new $modelMigration();

        $modelMigrate = str_replace('Migration', '', $modelMigrate);

        if (sizeof($migrate->attributes) > 0) {
            $isMigrate = $migrate->up($date, $modelMigrate);
            $output->writeln('<info>successfully created the table whith the name ' . strtolower($modelMigrate) . ' in the bbdd</info>');
        } else
            $output->writeln('<comment>The migration of model ' . $modelMigrate . ' file has no attributes defined for the table of the bbdd</comment>');
    }
}