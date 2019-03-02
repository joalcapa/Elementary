<?php

namespace Joalcapa\Elementary\Commands;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;


class CreateMiddlewareCommand extends Command
{
    protected $commandName = 'createMiddleware';
    protected $commandDescription = "Create Middleware";

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
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $nameMiddleware = $input->getArgument($this->commandArgumentName);

        if(empty($nameMiddleware)) {
            $output->writeln('<error>Name of the required middleware</error>');
            exit;
        }

        $nameMiddleware = ucwords(strtolower($nameMiddleware));
        $data = "<?php\n\nnamespace Gauler\Api\Middlewares;\n\nclass ".$nameMiddleware."Middleware {\n\n\t/**\n\t* @param \$request\n\t* @param \$next\n\t*/\n\tpublic function middle(\$request, \$next) {\n\t\t// killer(401);\n\t\t\$next();\n\t}\n}";

        $fileDescriptor = fopen(__DIR__ . "/../../../../../api/middlewares/".$nameMiddleware."Middleware.php","w");
        fputs($fileDescriptor, $data);
        fclose($fileDescriptor);

        $output->writeln('<info>successfully created middleware whith the name: ' . $nameMiddleware .'Middleware.php</info>');
        $output->writeln('<info>ubication: api\\middlewares\\' . $nameMiddleware .'Middleware.php</info>');
    }
}