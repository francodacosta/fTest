<?php
namespace fTest\Template;

class Twig
{
    private $templateFolder;
    static private $twig = null;
    private $cacheFolder;

    /**
     *
     * @param Array|string $templatePath the path(s) to the templates
     * @param unknown_type $cachePath
     */
    public function __construct($templatePath, $cachePath)
    {
        $this->templateFolder = $templatePath;
        $this->cacheFolder = $cachePath;
    }

    public function getTemplateFolder()
    {
        return $this->templateFolder;
    }


    public function getCacheFolder()
    {
        return $this->cacheFolder;
    }



    public function getTwig()
    {
        if (is_null(self::$twig)) {
            $loader = new \Twig_Loader_Filesystem($this->getTemplateFolder());
            $twig = new \Twig_Environment($loader, array(
                    'cache' => $this->getCacheFolder(),
            ));



            self::$twig = $twig;
        }

        return self::$twig;
    }




}
