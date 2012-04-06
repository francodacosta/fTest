<?php
namespace fTest\Template;

class Factory
{
    private static $template = null;

    private static function createTwiginstance($userTemplateFolder)
    {
        $templatePath = __DIR__ . DIRECTORY_SEPARATOR . 'views/';
        $folders = array($templatePath);
        if (strlen(realpath($userTemplateFolder)) > 0) {
           array_unshift($folders, realpath($userTemplateFolder));
        }
        $cachePath = false;
        $twig = new Twig($folders, $cachePath);

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