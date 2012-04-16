<?php
namespace DocBlock;

class Docblock
{
    private $raw;
    private $description;
    private $tags = array();

    public function __construct($raw)
    {
        $this->raw = $raw;
        $this->parse($raw);
    }

    private function parse($content)
    {
        //remove start and end tags
        $content = substr($content, 3, -2);

        // Split into arrays of lines
        $content = preg_split('/\r?\n\r?/', $content);

        // Trim asterisks and whitespace from the beginning and whitespace from the end of lines
        $content = array_map(function($line) {
          return ltrim(rtrim($line), "* \t\n\r\0\x0B");
        }, $content);

        // remove tags from array
        $tags = array();
        foreach($content as $key=> $line) {
            if (preg_match('/^@/', $line)) {
                unset($content[$key]);
                $tags[] = $line;
            }
        }

        $this->tags = $this->processTags($tags);

        $this->description = ltrim( implode("\n", $content), "\n");

    }

    private function processTags(array $tags)
    {
        $ret = array();
        foreach($tags as $tag) {
            $tag = ltrim($tag, '@');
            list($name, $value) = explode(' ', $tag, 2);
            if(! array_key_exists($name, $ret)) {
                $ret[$name] = array();
            }

            $ret[$name][] = $value;
        }
    }

    /**
     * gets the short description
     *
     * Short descriptions should always end in either a full stop, or 2 consecutive new lines. If it is not closed like this then any long description will be considered as part of the short description.
     * _Note_ A full stop means that the dot needs to be succeeded by a new line or other type of whitespace. This way it is possible to mention a version number, for example, without stopping the short description.
     *
     * @return string
     */
    public function getShortDescription()
    {
        $pattern = '/\.[\n \t]/';
        $subject = $this->description;

        $ret = null;
        if (1 == preg_match($pattern, $subject)) {
            $match = preg_split($pattern, $subject);
            $ret = $match[0];
        } else {
            $ret = $subject;
        }

        return $ret;
    }

    public function getLongDescription()
    {
      $start = strlen($this->getShortDescription());
      return substr($this->description, $start+1);
    }

    public function getTags()
    {
        return $this->tags;
    }
}