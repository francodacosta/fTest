<?php
namespace fTest\Command;

use fTest\Template\Factory;
use fTest\Template\Settings;
use fTest\Runner\FilesystemRunner;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Finder\Finder;


class Documentation extends BaseCommand
{
    public function configure()
    {
        $this->setName('document');

        $this->setDescription('generated documentation from configured tests');

       parent::configure();
    }


    private function settingsFromOptions(Settings $settings, array $options, InputInterface $input)
    {
        foreach($options as $option => $map) {
            $opt = $input->getOption($option) ;
            if ($opt) {
                $settings->$map($opt);
            }
        }

        return $settings;
    }

    /**
     * @todo refactor this crap
     */
    private function copyTemplateFiles($sourceFolder, $destinationFolder) {

        if ( DIRECTORY_SEPARATOR !== substr($destinationFolder, -1,1)) {
            $destinationFolder .= DIRECTORY_SEPARATOR;
        }

        $finder = new Finder();

        $iterator = $finder
          ->directories()
          ->name('*.*')
          ->notName('*.twig')
          ->in($sourceFolder);

        foreach ($iterator as $folder) {
            $path = str_replace($sourceFolder, $destinationFolder, $folder->getPathName());
            if (! is_dir($path)) {
                mkdir($path);
            }
        }


        $iterator = $finder
        ->files()
        ->name('*.*')
        ->notName('*.twig')
        ->in($sourceFolder);

        foreach ($iterator as $file) {
            $path = str_replace($sourceFolder, $destinationFolder, $file->getPathName());
            copy($file->getPathName(), $path );
        }
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $this->output = $output;
        $tests = $input->getOption('tests');
        if(!$tests) {
            $this->writeError("Must specify the tests folder");
            echo $this->getHelp();
            exit(253);
        }

        $output->writeln("<info>Generating documentation, might take a while</info>");

        $outputFolder = realpath($input->getOption('output'));

        if (! is_dir($outputFolder)) {
            $this->writeError('Output Folder ' . $outputFolder . " not found! have you created it ? \n\tyou can change it with --output option ");
            return;
        }


        $runner = new FilesystemRunner($tests);

        if (0 == count($runner->getTests())) {
            $this->writeError("No tests found");
            exit(1);
        }

        $settings = $this->settingsFromOptions(new Settings(), array(
            'template' => 'setTemplateFolder',
            'title' => 'setProjectTitle',
            'logo' => 'setProjectLogo',
            'name' => 'setProjectName',
        ), $input);

        $template = Factory::getTemplate($runner, $settings, $outputFolder );
        $template->write();
//         $writter->write($outputFolder . DIRECTORY_SEPARATOR . 'index.html');


        $this->copyTemplateFiles($settings->getTemplateRoot() ,$outputFolder );
        if ($settings->getTemplateFolder()) {
            $this->copyTemplateFiles(realpath($settings->getTemplateFolder()) ,$outputFolder );
        }


        $output->writeln(sprintf("<comment>Documentation saved to %s/index.html</comment>", realpath($outputFolder)));
    }
}