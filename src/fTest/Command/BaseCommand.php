<?php
namespace fTest\Command;

use Symfony\Component\Console\Command\Command;

class BaseCommand extends Command
{
    protected $output;

    protected function writeError($msg)
    {
        $this->output->writeln("");
        $this->output->writeln("<error>\n\t$msg\n</error>");
        $this->output->writeln("");
    }
    protected function writeSuccess($msg)
    {
        $this->output->writeln("");
        $this->output->writeln("<info>\n\t$msg\n</info>");
        $this->output->writeln("");
    }
}