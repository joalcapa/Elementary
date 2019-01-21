<?php

namespace Joalcapa\Elementary\Commands;

use \DateTime;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

class CreateMigrationCommand extends Command
{
    protected $commandName = 'create-migration';
    protected $commandDescription = "Create Migration";

    protected $commandArgumentName = "name";
    protected $commandArgumentDescription = "Who do you want to model?";

    protected $commandOptionName = "attributes"; // should be specified like "app:greet John --cap"
    protected $commandOptionDescription = 'If set, it will greet in uppercase letters';

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
            ->addOption(
                $this->commandOptionName,
                null,
                InputOption::VALUE_NONE,
                $this->commandOptionDescription
            )
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $nameMigration = $input->getArgument($this->commandArgumentName);
        
        if(empty($nameMigration)) {
            $output->writeln('Name of the required migration');
            exit;
        }
        
        $attributesModel = '';

        $data = "<?php\n\nnamespace Gauler\Database\Migrations;\n\nuse Joalcapa\Origins\App\Migrations\BaseMigration as Migration;\nuse Joalcapa\Origins\App\DataBase\Types\DBTypes as DBTypes;\n\nclass ".ucwords($nameMigration)."sMigration extends Migration {\n\n\tpublic \$attributes = [\n\t];\n\n\tpublic \$dependencias = [\n\t];\n}";
        
        /*if ($input->getOption($this->commandOptionName)) {
            $text = strtoupper($text);
        }*/

        $date = new DateTime();
        $nameFile = $date->getTimestamp().ucwords($nameMigration);
        $fileDescriptor = fopen(__DIR__ . "/../../../../../database/migrations/".$nameFile."sMigration.php","w");
        fputs($fileDescriptor, $data);
        fclose($fileDescriptor);

        $output->writeln('successfully created migration whith the name: ' . $nameFile .'sMigration.php');
        $output->writeln('ubication: database\\migrations\\' . ucwords($nameFile) .'sMigration.php');
    }

}