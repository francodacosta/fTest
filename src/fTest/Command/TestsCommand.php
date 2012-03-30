<?php
namespace fTest\Command;

use fTest\Template\Factory;

use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

use fTest\Runner\FilesystemRunner;

class TestsCommand extends BaseCommand
{
    public function configure()
    {
        $this->setName('document');

        $this->setDefinition(array(
            new InputOption('tests', 't', InputArgument::OPTIONAL, 'The root folder where all tests are located', '.'),
        ));
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $this->output = $output;

        $tests = $input->getOption('tests');

        $output->writeln("<info>Running tests, might take a while</info>");
        $runner = new FilesystemRunner($tests);

        $runner->run();

        foreach($runner->getTests() as $test)
        {
            $result = $test->getResult();
            if ($result->getCode() > 0) {
                $output->writeln(sprintf("<error>\ttest %s failed with error %3d message: %s</error>", $test->getName(), $result->getCode(), $result->getMessage()));
            }
        }


        $output->writeln(sprintf("<comment>Executed %d tests</comment>", count($runner->getTests())));
    }
}