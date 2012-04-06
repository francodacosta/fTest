<?php
namespace fTest\Command;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class BaseCommand extends Command
{
    protected $output;

    protected function writeError($msg)
    {
        $this->output->writeln("");
        $this->output->writeln("<error>\n\t$msg\n</error>");
        $this->output->writeln("");
    }
    protected function writeSuccess($msg)
    {
        $this->output->writeln("");
        $this->output->writeln("<info>\n\t$msg\n</info>");
        $this->output->writeln("");
    }

    public function configure()
    {
        switch ($this->getName()) {
            case 'document' :
                $this->setCliOptions('document');
                break;

            case 'tests' :
                $this->setCliOptions('tests');
                break;

            case 'default':
                $this->setCliOptions('document');
                $this->setCliOptions('tests');
                break;
        }
    }

    protected function setCliOptions($name) {

        $defenition = $this->getDefinition();
        switch($name) {
            case 'document' :
                $defenition->addOption(new InputOption('output', 'o', InputArgument::OPTIONAL, 'the folder where to store the documentation', './docs'));
                $defenition->addOption(new InputOption('tests', 't', InputArgument::OPTIONAL, 'The root folder where all tests are located'));
                $defenition->addOption(new InputOption('template', null, InputArgument::OPTIONAL, 'The root folder where template files are located', null));
                $defenition->addOption(new InputOption('title', null, InputArgument::OPTIONAL, 'The project title'));
                $defenition->addOption(new InputOption('logo', null, InputArgument::OPTIONAL, 'The project logo'));
                $defenition->addOption(new InputOption('name', null, InputArgument::OPTIONAL, 'The project name'));
                break;

            case 'tests':
                $defenition->addOption(new InputOption('tests', 't', InputArgument::OPTIONAL, 'The root folder where all tests are located'));
                $defenition->addOption(new InputOption('bootstrap', 'b', InputArgument::OPTIONAL, 'run this file before executing tests', './bootstrap.php'));
                break;
        }

        $this->setDefinition($defenition);
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {

        register_shutdown_function(function() use ($output){
            $error = error_get_last();
            if ($error ) {
                $message = array(
                    'Fatal Error:',
                     $error['message'],
                     'From:',
                     $error['file'] . ' line ' . $error['line'] ,
                );


                $output->writeln("");
                $output->writeln("<error>\t\n\t". implode("\n\t", $message) ."\n</error>");
                $output->writeln("");
            }

        });
    }

}