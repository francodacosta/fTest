<?php
namespace fTest\Command;

use fTest\Template\Factory;

use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

use fTest\Runner\FilesystemRunner;
use fTest\Runner\ConsoleRunnerDecorator;

class TestsCommand extends BaseCommand
{
    public function configure()
    {
        $this->setName('test');
        $this->setDescription('Executes test cases');
        $this->setDefinition(array(
            new InputOption('tests', 't', InputArgument::OPTIONAL, 'The root folder where all tests are located', '.'),
        ));
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $this->output = $output;

        $tests = $input->getOption('tests');

        $output->writeln("<info>Running tests, might take a while</info>");
        $runner = new ConsoleRunnerDecorator(new FilesystemRunner($tests), $this->output);

        ob_start();
        $runner->run();
        ob_end_clean();

        $count = 0;
        foreach($runner->getTests() as $test)
        {
            $result = $test->getResult();
            if ($result->getCode() > 0) {
                $count++;
            }
        }


        if (0 == $count) {
            $this->writeSuccess("All tests passed");
        } else {
            $this->writeError(sprintf("%d tests failed", $count));
        }
    }
}