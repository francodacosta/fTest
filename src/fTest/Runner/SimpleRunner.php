<?php
namespace fTest\Runner;

use fTest\Test\TestInterface;
/**
 * Manages test execution
 * @author nuno costa <nuno@francodacosta.com>
 *
 */
class SimpleRunner implements RunnerInterface
{
    private $tests = array();
    private $results = array();

    /**
     * adds a test to be executed
     * @param TestCase $test
     */
    public function add(TestInterface $test)
    {
        $this->tests[] = $test;
    }

    /**
     * returns all tests configured
     * @return multitype:
     */
    public function getTests()
    {
        return $this->tests;
    }

    /**
     * run all tests added to the runner
     */
    public function run()
    {
        foreach ($this->tests as $test) {
            $test->execute();
        }
    }
}