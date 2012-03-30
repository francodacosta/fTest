<?php
namespace fTest\Runner;

Interface RunnerInterface
{
    /**
     * get all tests assigned to this runner
     *
     * @return Array of fTest\Test\TestInterface
     */
    public function getTests();

    /**
     * executes the tests
     */
    public function run();
}