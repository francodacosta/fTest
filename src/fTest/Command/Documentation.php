<?php
namespace fTest\Command;

use fTest\Template\Factory;
use fTest\Template\Settings;


use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

use fTest\Runner\FilesystemRunner;

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

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $this->output = $output;
        $output->writeln("<info>Generating documentation, might take a while</info>");

        $outputFolder = realpath($input->getOption('output'));
        $tests = $input->getOption('tests');
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

        $writter = Factory::getTemplateWritter($runner, $settings);
        $writter->write($outputFolder . DIRECTORY_SEPARATOR . 'index.html');

        $output->writeln(sprintf("<comment>Documentation saved to %s/index.html</comment>", realpath($tests)));
    }
}