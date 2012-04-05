<?php
namespace fTest\Command;

use fTest\Template\Factory;
use fTest\Template\Settings;

use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

use fTest\Runner\FilesystemRunner;

class Documentation extends BaseCommand
{
    public function configure()
    {
        $this->setName('document');

        $this->setDescription('generated documentation from configured tests');

        $this->setDefinition(array(
            new InputArgument('output folder', InputArgument::OPTIONAL, 'the folder where to store the documentation', './docs'),
            new InputOption('tests', 't', InputArgument::OPTIONAL, 'The root folder where all tests are located', '.'),
            new InputOption('template', null, InputArgument::OPTIONAL, 'The root folder where template files are located'),
            new InputOption('title', null, InputArgument::OPTIONAL, 'The project title'),
            new InputOption('logo', null, InputArgument::OPTIONAL, 'The project logo'),
            new InputOption('name', null, InputArgument::OPTIONAL, 'The project name'),
        ));
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

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $this->output = $output;

        $outputFolder = $input->getArgument('output folder');
        $tests = $input->getOption('tests');
        if (! is_dir($outputFolder)) {
            $this->writeError('Folder ' . $outputFolder . ' not found!');
            return;
        }

        $output->writeln("<info>Generating documentation, might take a while</info>");
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

        $writter = Factory::getTemplateWritter($runner, $settings);
        $writter->write($outputFolder . DIRECTORY_SEPARATOR . 'index.html');

        $output->writeln(sprintf("<comment>Documentation saved to %s/index.html</comment>", realpath($tests)));
    }
}