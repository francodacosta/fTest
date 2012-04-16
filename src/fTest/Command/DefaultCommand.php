<?php
namespace fTest\Command;

use fTest\Command\BaseCommand;

use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class DefaultCommand extends BaseCommand
{
    public function configure()
    {
        $this->setName('doctest');
        $this->setDescription('Executes test and creates documentation');

        parent::configure();
    }


    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $commands = array(

            new TestsCommand(),
            new Documentation(),


        );

        foreach($commands as $command) {
            $command->execute($input, $output);
        }
    }
}
