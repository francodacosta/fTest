<?php
include __DIR__ . "/vendor/.composer/autoload.php";

use fTest\Application;
use fTest\Command\Documentation;
use fTest\Command\TestsCommand;
use fTest\Command\DefaultCommand;

// error_reporting(0);
$app = new Application('fTest', '0.1');
$app->add(new documentation);
$app->add(new TestsCommand);
$app->add(new DefaultCommand);
$app->setDefaultCommandName('default');


echo sprintf("\n%s %s\n", $app->getName(), $app->getVersion());

// only run the app if this file was executed directly
if ( ! defined('NO_EXECUTE') ) {
    $app->run();
}


