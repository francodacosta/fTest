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

        parent::configure();
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        parent::execute($input, $output);
        $this->output = $output;

        $tests = $input->getOption('tests');
        if (!$tests) {
            throw new \UnexpectedValueException("Must specify the tests folder");
        }

        $bootstrap = realpath($input->getOption('bootstrap'));
        $output->writeln("");
        $output->writeln("<info>Running tests, might take a while</info>");
        $output->writeln("<info>Tests folder</info>: " . realpath($tests));

        $runner = new ConsoleRunnerDecorator(new FilesystemRunner($tests), $this->output);

        if (0 == count($runner->getTests())) {
            $this->writeError("No tests found");
            exit(1);
        }

        if (file_exists($bootstrap)) {
            $output->writeln('<info>Loading bootstrap file:</info> ' . $bootstrap);
            require $bootstrap;
        }

        $output->writeln("");
        ob_start();
        $runner->run();
        ob_end_clean();

        $count = 0;
        foreach ($runner->getTests() as $test) {
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