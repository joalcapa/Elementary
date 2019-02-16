<?php

namespace Joalcapa\Elementary\Commands;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

class CreateModelCommand extends Command
{
    protected $commandName = 'createModel';
    protected $commandDescription = "Create Model";

    protected $commandArgumentName = "name";
    protected $commandArgumentDescription = "Who do you want to model?";

    protected $commandArgumentAttributes = "attr"; // should be specified like "app:greet John --cap"
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
            $output->writeln('Name of the required model');
            exit;
        }

        $attributesModel = '';
        if(!empty($attributes)) {
            $tokens = explode(',', $attributes);
            $attributesArray = [];
            foreach ($tokens as $token) {
                $token = explode(':', $token);

                if(sizeof($token) != 2) {
                    $output->writeln('The attributes must have a name and the type of data');
                    exit;
                }

                $attributesArray[$token[0]] = $token[1];
                $attributesModel .= "\t\t'" . $token[0] . "',\n";
            }
        }

        $data = "<?php\n\nnamespace Gauler\\Api\\Models;\n\nuse Joalcapa\\Fundamentary\\App\\Models\\BaseModel as Model;\n\nclass ". ucwords($nameModel) ."sModel extends Model {\n\n\tpublic static \$model = '". ucwords($nameModel) ."s';\n\n\tprotected \$tuples = [\n".$attributesModel."\t];\n\n\tprotected \$hidden_tuples = [\n\t];\n}";

        $fileDescriptor = fopen(__DIR__ . "/../../../../../api/models/".ucwords($nameModel)."sModel.php","w");

        fputs($fileDescriptor, $data);

        fclose($fileDescriptor);

        $output->writeln('successfully created model whith the name: ' . ucwords($nameModel) .'sModel.php');
        $output->writeln('ubication: api\\models\\' . ucwords($nameModel) .'sModel.php');
    }
}
