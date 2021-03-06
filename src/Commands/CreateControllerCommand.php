<?php

namespace Joalcapa\Elementary\Commands;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

class CreateControllerCommand extends Command
{
    protected $commandName = 'createController';
    protected $commandDescription = "Create Controller";

    protected $commandArgumentName = "name";
    protected $commandArgumentDescription = "Who do you want to controller?";

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
        $nameController = $input->getArgument($this->commandArgumentName);
        
        if(empty($nameController)) {
            $output->writeln('<error>Name of the required model</error>');
            exit;
        }
        
        $attributesModel = '';
        $data = "<?php\n\nnamespace Gauler\Api\Controllers;\n\nuse Joalcapa\Fundamentary\App\Controllers\BaseController as Controller;\n\nclass ".ucwords($nameController)."sController extends Controller {\n\n\t/**\n\t* @param \$request\n\t* @return  array\n\t*/\n\tpublic function index(\$request) {\t\t}\n\n\n\t/**\n\t* @param  \$request\n\t* @return  array\n\t*/\n\tpublic function show(\$request) {\t\t}\n\n\n\t/**\n\t* @param \$request\n\t* @return  array\n\t*/\n\tpublic function store(\$request) {\t\t}\n\n\n\t/**\n\t* @param \$request\n\t* @return  array\n\t*/\n\tpublic function update(\$request) {\t\t}\n\n\n\t/**\n\t* @param  \$request\n\t* @return  array\n\t*/\n\tpublic function destroy(\$request) {\t\t}\n}";

        $fileDescriptor = fopen(__DIR__ . "/../../../../../api/controllers/".ucwords($nameController)."sController.php","w");
        fputs($fileDescriptor, $data);
        fclose($fileDescriptor);

        $output->writeln('<info>successfully created controller whith the name: ' . ucwords($nameController) .'sController.php</info>');
        $output->writeln('<info>ubication: api\\controllers\\' . ucwords($nameController) .'sController.php</info>');
    }
}
