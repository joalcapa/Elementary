<?php

namespace Joalcapa\Elementary\Commands;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

use Joalcapa\Fundamentary\Database\Kernel as KernelDB;

class SeedersCommand extends Command
{
    protected $commandName = 'seeders';
    protected $commandDescription = "Run seeders";

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
        $nameSeeder = $input->getArgument($this->commandArgumentName);
        $attributes = $input->getArgument($this->commandArgumentAttributes);

        KernelDB::getKernel();
        $route = REAL_PATH . "/seeders";
        $directory = opendir($route);

        while ($file = readdir($directory))
            if (!is_dir($file))
            {
                $modelSeeder = str_replace('.php', '', $file);
                if(empty($nameSeeder))
                    $this->boom($file, $modelSeeder, $output);
                else {
                    if(strtolower($nameSeeder) == strtolower($modelSeeder)) {
                        $this->boom($file, $modelSeeder, $output);
                        return;
                    }
                }
            }
    }

    public function boom($file, $modelSeeder, $output) {
        require(REAL_PATH . "\\Seeders\\" . $file);
        $modelSeeder = "Gauler\\Seeders\\" . $modelSeeder;
        $seeder = new $modelSeeder();
        $seeder->boom();
        $output->writeln('<info>successfully run seeder ' . strtolower($modelSeeder) . ' in the bbdd</info>');
    }
}