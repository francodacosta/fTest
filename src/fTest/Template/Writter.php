<?php
namespace fTest\Template;


use fTest\Runner\RunnerInterface;

class Writter
{
    private $runner;
    private $twig;

    public function __construct(Twig $twig)
    {
        $this->twig = $twig;
    }

    public function setRunner(RunnerInterface $runner)
    {
        $this->runner= $runner;
    }


    public function write($file)
    {
        $twig = $this->twig->getTwig();
        $tests = $this->runner->getTests();

        $content = $twig->render("default.html.twig", array('tests' => $tests));

        file_put_contents($file, $content);
    }
}