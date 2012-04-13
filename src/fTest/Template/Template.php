<?php
namespace fTest\Template;

use fTest\Runner\RunnerInterface;

class Template
{
    private $writter;
    private $twig;
    private $runner;
    private $settings;

    public function __construct(Writter $writter, Twig $twig, RunnerInterface $runner, Settings $settings)
    {
        $this->writter = $writter;
        $this->twig = $twig;
        $this->runner = $runner;
        $this->settings = $settings;
    }

    private function writeTests(){

    }

    public function write()
    {


        $twig = $this->twig->getTwig();
        $writter = $this->writter;
        $tests = $this->runner->getTests();

        // write index
        $content = $twig->render('index.html.twig', array('tests' => $tests, 'config' => $this->settings));
        $writter->write('index.html', $content);

        // write tests

        foreach($tests as $test) {
            $content = $twig->render('test.html.twig', array('tests' => $tests,'test' => $test, 'config' => $this->settings));
            $writter->write(str_replace(' ', '_', $test->getName()) . '.html', $content);
        }
    }
}