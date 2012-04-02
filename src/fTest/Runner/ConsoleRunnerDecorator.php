<?php
namespace fTest\Runner;

use Symfony\Component\Console\Output\OutputInterface;
use fTest\Test\Result\ResultInterface;
/**
 * Decorates a runner and adds output hability to it
 *
 * It wa thought of to be used from the console component as way to show progress
 * and output information from the test execution
 *
 * @author nuno costa <nuno@francodacosta.com>
 *
 */
class ConsoleRunnerDecorator implements RunnerInterface
{
    private $runner;
    private $output;

    /**
     * Creates this decorator
     * @param RunnerInterface $runner
     * @param OutputInterface $output
     */
    public function __construct(RunnerInterface $runner, OutputInterface $output)
    {
        $this->runner = $runner;
        $this->output = $output;
    }


    /**
     * (non-PHPdoc)
     * @see fTest\Runner.RunnerInterface::getTests()
     */
    public function getTests()
    {
        return $this->runner->getTests();
    }

    /**
     * nice output of test execution status
     * @param string $name the test name
     * @param Result $result
     */
    private function writeTestInformation ($name, ResultInterface $result)
    {
        $status = (0 == $result->getCode()) ? "\t<info>Passed</info>" : "\n\t<error>Failed</error>";
        $extra = (0 == $result->getCode()) ? '' : sprintf("\n\t\tError: %s, %s\n", $result->getCode(), $result->getMessage());

        $this->output->writeln(sprintf("%-6s %s %s", $status, $name, $extra));
    }

    /**
     * (non-PHPdoc)
     * @see fTest\Runner.RunnerInterface::run()
     */
    public function run()
    {
        $tests = $this->getTests();

        foreach($tests as $test) {
            $output = $this->output;

            $test->configure();
            $test->execute();
            $this->writeTestInformation($test->getName(), $test->getResult());

        }
    }

}