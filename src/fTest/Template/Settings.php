<?php
namespace fTest\Template;
class Settings
{
    private $templateFolder = '';
    private $projectTitle = 'project documentation';
    private $projectLogo = null;

    public function getTemplateFolder()
    {
        return $this->templateFolder;
    }

    public function setTemplateFolder($templateFolder)
    {
        $this->templateFolder = $templateFolder;
    }

    public function getProjectTitle()
    {
        return $this->projectTitle;
    }

    public function setProjectTitle($projectTitle)
    {
        $this->projectTitle = $projectTitle;
    }

    public function getProjectLogo()
    {
        return $this->projectLogo;
    }

    public function setProjectLogo($projectLogo)
    {
        $this->projectLogo = $projectLogo;
    }

    public function getTemplateRoot()
    {
        return __DIR__ . '/views/';
    }

}
