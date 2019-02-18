<?php

namespace Joalcapa\Elementary\Commands;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

class CreateSeederCommand extends Command
{
    protected $commandName = 'createSeeder';
    protected $commandDescription = "Create Seeder";

    protected $commandArgumentName = "name";
    protected $commandArgumentDescription = "Who do you want to model?";

    protected $commandArgumentAttributes = "attr";
    protected $commandArgumentAttributesDescription = 'If set, it will greet in uppercase letters';

    protected function configure()
    {
        $this
            ->setName($this->commandName)
            ->setDescription($this->commandDescription)
            ->addArgument(
                $this->commandArgumentName,
                InputArgument::REQUIRED,
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
            $output->writeln('<error>Name of the required model</error>');
            exit;
        }

        $data = "<?php\n\nnamespace Gauler\\Seeders;\n\nclass ". ucwords($nameModel) ."sSeeder {\n\n\tpublic function boom() {\n\n\t}\n}";
        $fileDescriptor = fopen(__DIR__ . "/../../../../../seeders/".ucwords($nameModel)."sSeeder.php","w");

        fputs($fileDescriptor, $data);
        fclose($fileDescriptor);

        $output->writeln('<info>successfully created model whith the name: ' . ucwords($nameModel) .'sSeeder.php</info>');
        $output->writeln('<info>ubication: seeders\\' . ucwords($nameModel) .'sSeeder.php</info>');
    }
}