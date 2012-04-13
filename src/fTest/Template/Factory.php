<?php
namespace fTest\Template;

class Factory
{
    private static $template = null;

    private static function createTwiginstance($userTemplateFolder)
    {
        $templatePath = __DIR__ . DIRECTORY_SEPARATOR . 'Default/';
        $folders = array($templatePath);
        if (strlen(realpath($userTemplateFolder)) > 0) {
           array_unshift($folders, realpath($userTemplateFolder));
        }
        $cachePath = false;
        $twig = new Twig($folders, $cachePath);

        return $twig;
    }

    public static function getTemplate($runner, Settings $settings, $baseFolder)
    {
        if (is_null(self::$template)) {
            $writter = new Writter($baseFolder);
            $twig =  self::createTwigInstance($settings->getTemplateFolder());



            self::$template = new Template($writter, $twig, $runner, $settings);
        }

        return self::$template;
    }
}