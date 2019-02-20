<?php

namespace Joalcapa\Elementary\Commands;

use \DateTime;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

use Joalcapa\Elementary\Generics\TypeAttrQ as TypeAttrQ;

class CreateMigrationCommand extends Command
{
    protected $commandName = 'createMigration';
    protected $commandDescription = "Create Migration";

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
        $nameMigration = $input->getArgument($this->commandArgumentName);
        $attributes = $input->getArgument($this->commandArgumentAttributes);
        self::createMigration($nameMigration, $attributes, $output);
    }

    public static function createMigration($nameMigration, $attributes, $output) {

        if(empty($nameMigration)) {
            $output->writeln('<error>Name of the required migration</error>');
            exit;
        }

        $attributesModel = '';
        if(!empty($attributes)) {
            $tokens = explode(',', $attributes);
            foreach ($tokens as $token) {
                $token = explode(':', $token);

                if(sizeof($token) != 2) {
                    $output->writeln('<error>The attributes must have a name and the type of data</error>');
                    exit;
                }

                $typeBBDD = '';
                switch ($token[1]) {
                    case TypeAttrQ::STRING:
                        $typeBBDD = 'TypeAttrQ::STRING';
                        break;
                    case TypeAttrQ::INTEGER:
                        $typeBBDD = 'TypeAttrQ::INTEGER';
                        break;
                    default:
                        $output->writeln('<error>The attributes does not have a type valid</error>');
                        exit;
                }
                $attributesModel .= "\t\t'" . $token[0] . "' => " .$typeBBDD.",\n";
            }
        }

        $data = "<?php\n\nnamespace Gauler\Database\Migrations;\n\nuse Joalcapa\Elementary\Generics\TypeAttrQ as TypeAttrQ;\nuse Joalcapa\Elementary\Migrations\BaseMigration as Migration;\n\nclass ".ucwords($nameMigration)."sMigration extends Migration {\n\n\tpublic \$attributes = [\n".$attributesModel."\t];\n}";

        $date = new DateTime();
        $nameFile = $date->getTimestamp().ucwords($nameMigration);
        $fileDescriptor = fopen(__DIR__ . "/../../../../../database/migrations/".$nameFile."sMigration.php","w");
        fputs($fileDescriptor, $data);
        fclose($fileDescriptor);

        $output->writeln('<info>successfully created migration whith the name: ' . $nameFile .'sMigration.php</info>');
        $output->writeln('<info>ubication: database\\migrations\\' . ucwords($nameFile) .'sMigration.php</info>');
    }
}