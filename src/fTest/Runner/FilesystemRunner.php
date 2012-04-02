<?php
namespace fTest\Runner;

use fTest\Test\TestInterface;
/**
 * Manages test execution
 * this class will load all tests in a folder recursively
 * only .php files that implement TestInterface will be loaded
 * @author nuno costa <nuno@francodacosta.com>
 *
 */
class FilesystemRunner implements RunnerInterface
{
    private $tests = array();
    private $results = array();
    private $basePath = null;

    public function __construct($path)
    {
        $this->basePath = $path;
    }

    private function addTests(\Iterator $iterator)
    {
        foreach($iterator as $path) {
            $className = basename($path, '.php');
            require $path;
            $class = new $className;

            if ($class instanceof \fTest\Test\TestInterface) {
                $this->add($class);
            }

        }
    }

    private function getTestsInPath($path)
    {
        $Directory = new \RecursiveDirectoryIterator($this->basePath);
        $Iterator = new \RecursiveIteratorIterator($Directory);
        $Regex = new \RegexIterator($Iterator, '/.*\.php$/i');
        return $Regex;
    }

    /**
     * adds a test to be executed
     * @param TestCase $test
     */
    private function add(TestInterface $test)
    {
        $test->configure();
        $this->tests[] = $test;
    }

    /**
     * returns all tests configured
     * @return multitype:
     */
    public function getTests()
    {
        if (0 == count($this->tests)) {
           $this->addTests($this->getTestsInPath($this->basePath));
        }

        return $this->tests;
    }

    /**
     * run all tests added to the runner
     */
    public function run()
    {
        foreach ($this->getTests() as $test) {
            $test->execute();
        }
    }
}