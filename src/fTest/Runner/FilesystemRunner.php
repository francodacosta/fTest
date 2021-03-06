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
    private $loaded = false;

    public function __construct($path)
    {
        $this->basePath = $path;
    }

    private function addTests(\Iterator $iterator)
    {



        foreach($iterator as $path) {
            $className = basename($path, '.php');

            require_once $path;
            if (!class_exists($className)) {
                //@todo show a message saying the file was found but no class was found
                continue;
            }
            $class = new $className;

            if ($class instanceof \fTest\Test\TestInterface) {
                $this->add($class);
            }

        }

        $this->loaded = true;
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
        if (!$this->isLoaded()) {
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

    /**
     * return true if tests are loaded
     */
    public function isLoaded()
    {
        return $this->loaded;
    }
}