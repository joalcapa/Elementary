<?php

namespace Joalcapa\Elementary\Commands;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

class CreateModelCommand extends Command
{
    protected $commandName = 'create-model';
    protected $commandDescription = "Create Model";

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
        $name = $input->getArgument($this->commandArgumentName);
        
        if(empty($nameModel)) {
            $output->writeln('Name of the required model');
            exit;
        }
        
        $attributesModel = '';

        $data = "<?php\n\nnamespace Gauler\\Api\\Models;\n\nuse Joalcapa\\Fundamentary\\App\\Models\\BaseModel as Model;\n\nclass ". ucwords($name) ."sModel extends Model {\n\n\tpublic static \$model = '". ucwords($name) ."s';\n\n\tprotected \$tuples = [\n\t\t\t".$attributesModel."\n\t];\n\n\tprotected \$hidden_tuples = [\n\t];\n}";

        /*if ($input->getOption($this->commandOptionName)) {
            $text = strtoupper($text);
        }*/

        $fileDescriptor = fopen(__DIR__ . "/../../../../../api/models/".ucwords($name)."sModel.php","w");
        fputs($fileDescriptor,$data);
        fclose($fileDescriptor);

        $output->writeln('successfully created model whit the name: ' . ucwords($name) .'sModel.php');
        $output->writeln('ubicacion: api\\models\\' . ucwords($name) .'sModel.php');
    }
}
