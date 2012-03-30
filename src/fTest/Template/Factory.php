<?php
namespace fTest\Template;

class Factory
{
    private static $template = null;

    private static function createTwiginstance()
    {
        $templatePath = __DIR__ . DIRECTORY_SEPARATOR . 'views/';
        $cachePath = false;
        $twig = new Twig($templatePath, $cachePath);

        return $twig;
    }

    public static function getTemplateWritter($runner)
    {
        if (is_null(self::$template)) {
            self::$template = new Writter( self::createTwigInstance());
            self::$template->setRunner($runner);
        }

        return self::$template;
    }
}