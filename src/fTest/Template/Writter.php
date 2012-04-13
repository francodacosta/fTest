<?php
namespace fTest\Template;

use fTest\Runner\RunnerInterface;

class Writter
{
    private $runner;
    private $twig;
    private $settings;

    public function __construct($basePath)
    {
        $this->basePath = realpath($basePath);
    }

    public function getBasePath()
    {
        return $this->basePath;
    }
    public function write($file, $content)
    {
//         $twig = $this->twig->getTwig();
//         $tests = $this->runner->getTests();
//         $content = $twig->render($template, array('tests' => $tests, 'config' => $this->getSettings()));

        file_put_contents($this->basePath  . DIRECTORY_SEPARATOR . $file, $content);
    }

}
