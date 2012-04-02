<?php
namespace fTest\Template;

class Factory
{
    private static $template = null;

    private static function createTwiginstance($userTemplateFolder)
    {
        if (0==strlen($userTemplateFolder)) {
            $userTemplateFolder = '.';
        }
        $templatePath = __DIR__ . DIRECTORY_SEPARATOR . 'views/';
        $cachePath = false;
        $twig = new Twig(array($userTemplateFolder, $templatePath), $cachePath);

        return $twig;
    }

    public static function getTemplateWritter($runner, Settings $config)
    {
        if (is_null(self::$template)) {
            $template = new Writter( self::createTwigInstance($config->getTemplateFolder()));
            $template->setRunner($runner);
            $template->setSettings($config);

            self::$template = $template;
        }

        return self::$template;
    }
}