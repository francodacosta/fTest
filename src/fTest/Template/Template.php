<?php
namespace fTest\Template;

use fTest\Runner\RunnerInterface;
// use Assetic\AssetWriter;
// use Assetic\Extension\Twig\TwigFormulaLoader;
// use Assetic\Extension\Twig\TwigResource;
// use Assetic\Factory\LazyAssetManager;
// use Assetic\Extension\Twig\AsseticExtension;
// use Assetic\Factory\AssetFactory;

// use Assetic\FilterManager;
// use Assetic\Filter\Yui;
use Symfony\Component\Finder\Finder;


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

    private function getAssetic()
    {
        $factory = new AssetFactory($this->writter->getBasePath(), false);

        $fm = new FilterManager();
        $fm->set('yui_css', new Yui\CssCompressorFilter('/path/to/yuicompressor.jar'));


        $factory->setFilterManager($fm);

        return $factory;
    }
    private function writeTests(){

    }

    public function write()
    {


        $twig = $this->twig->getTwig();
//         $factory = $this->getAssetic();
//         $twig->addExtension(new AsseticExtension($factory));
        $writter = $this->writter;
        $tests = $this->runner->getTests();

        $files = array();

        // write index
        $content = $twig->render('index.html.twig', array('tests' => $tests, 'config' => $this->settings));
        $writter->write('index.html', $content);
        $files[]='index.html.twig';
        $files[]='default.html.twig';

        // write tests

        foreach($tests as $test) {
            $content = $twig->render('test.html.twig', array('tests' => $tests,'test' => $test, 'config' => $this->settings));
            $file = str_replace(' ', '_', $test->getName()) . '.html';
            $writter->write($file, $content);
            $files[] = 'test.html.twig';
        }


//         $am = new LazyAssetManager($factory);

//         // enable loading assets from twig templates
//         $twigLoader = new TwigFormulaLoader($twig);
//         $am->setLoader('twig', $twigLoader);

//         $finder = new Finder();

//         $iterator = $finder
//         ->files()
//         ->name('*.twig')
//         ->in($twig->getLoader()->getPaths());

//         // loop through all your templates
//         foreach ($iterator as $template) {
//             $resource = new TwigResource($twig->getLoader(), $template->getFilename());
//             $am->addResource($resource, 'twig');
//         }


//         $writer = new AssetWriter($writter->getBasePath());

//         $writer->writeManagerAssets($am);
    }
}