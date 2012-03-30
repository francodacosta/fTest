<?php
namespace fTest\Command;

use fTest\Template\Factory;

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

        $this->setDefinition(array(
            new InputArgument('output folder', InputArgument::OPTIONAL, 'the folder where to store the documentation', './docs'),
            new InputOption('tests', 't', InputArgument::OPTIONAL, 'The root folder where all tests are located', '.'),
        ));
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

        $writter = Factory::getTemplateWritter($runner);
        $writter->write($outputFolder . DIRECTORY_SEPARATOR . 'index.html');

        $output->writeln(sprintf("<comment>Documentation saved to %s/index.html</comment>", realpath($tests)));
    }
}